/*
 * Driver & vehicle documentation - upload cards, preview, admin review.
 *
 * One delegated set of listeners on the page root drives every card, so cards
 * can be re-rendered by the server (after an upload / review) without rebinding
 * anything. This file deliberately never logs to the console: it handles
 * sensitive documents.
 */
(function () {
    'use strict';

    var root = document.querySelector('[data-dd-root]');
    if (!root) { return; }

    var MAX_BYTES  = parseInt(root.getAttribute('data-max-bytes'), 10) || 10485760;
    var EXTENSIONS = (root.getAttribute('data-extensions') || 'pdf,jpg,jpeg,png').split(',');
    var MIMES      = (root.getAttribute('data-mimes') || '').split(',');
    var TOKEN      = (root.querySelector('input[name="_token"]') || {}).value || '';
    var MAX_MB     = Math.round(MAX_BYTES / 1048576);

    var uploads = new WeakMap();   // card wrapper -> in-flight XMLHttpRequest

    // ---------------------------------------------------------------- helpers

    function cardOf(el) { return el.closest('[data-dd-card]'); }

    function errorFor(file) {
        var ext = (file.name.split('.').pop() || '').toLowerCase();
        if (EXTENSIONS.indexOf(ext) === -1 || (file.type && MIMES.indexOf(file.type) === -1)) {
            return 'Only PDF, JPG, JPEG and PNG files are accepted.';
        }
        if (file.size > MAX_BYTES) {
            return 'That file is too large. The maximum size is ' + MAX_MB + ' MB.';
        }
        if (file.size === 0) {
            return 'That file is empty.';
        }
        return null;
    }

    function showMsg(wrap, text, ok) {
        var el = wrap.querySelector('.dd-msg');
        if (!el) { return; }
        el.textContent = text;
        el.classList.toggle('is-success', !!ok);
        el.hidden = false;
        if (ok) {
            setTimeout(function () { el.hidden = true; }, 5000);
        }
    }

    function setBusy(wrap, busy) {
        var card = wrap.querySelector('.dd-card');
        if (card) { card.classList.toggle('is-busy', busy); }
    }

    function parse(xhrOrText) {
        try { return JSON.parse(typeof xhrOrText === 'string' ? xhrOrText : xhrOrText.responseText); }
        catch (e) { return null; }
    }

    /** Human message for a failed HTTP response that carried no usable JSON. */
    function statusMessage(status) {
        if (status === 419) { return 'Your session has expired. Please refresh the page and try again.'; }
        if (status === 413) { return 'That file is larger than the server allows.'; }
        if (status === 429) { return 'Too many attempts. Please wait a moment and try again.'; }
        if (status === 401 || status === 403) { return 'You don’t have permission to do that.'; }
        return 'Something went wrong. Please try again.';
    }

    /** Swap a card (and the overall summary) for the server-rendered versions. */
    function applyServerResult(wrap, data, successText) {
        var tmp = document.createElement('div');
        tmp.innerHTML = data.card;
        var fresh = tmp.firstElementChild;

        var oldDetails = wrap.querySelector('.dd-review');
        var wasOpen = oldDetails && oldDetails.open;

        wrap.replaceWith(fresh);

        if (wasOpen) {
            var d = fresh.querySelector('.dd-review');
            if (d) { d.open = true; }
        }
        var summary = root.querySelector('[data-dd-summary]');
        if (summary && data.summary) { summary.innerHTML = data.summary; }

        showMsg(fresh, successText || data.message || 'Done.', true);
    }

    // ---------------------------------------------------------------- dialogs

    var previewDlg = document.getElementById('ddPreview');
    var confirmDlg = document.getElementById('ddConfirm');
    var hasDialog  = typeof HTMLDialogElement === 'function';

    function confirmAction(opts, onOk) {
        if (!hasDialog || !confirmDlg) {
            if (window.confirm(opts.text)) { onOk(); }
            return;
        }
        confirmDlg.querySelector('#ddConfirmTitle').textContent = opts.title;
        confirmDlg.querySelector('[data-dd-confirm-text]').textContent = opts.text;
        var ok = confirmDlg.querySelector('[data-dd-confirm-ok]');
        ok.textContent = opts.ok || 'Confirm';
        ok.className = 'dd-btn dd-btn-sm ' + (opts.danger ? 'dd-btn-danger' : 'dd-btn-primary');
        ok.onclick = function () { confirmDlg.close(); onOk(); };
        confirmDlg.showModal();
    }

    function openPreview(btn) {
        var src  = btn.getAttribute('data-src');
        var kind = btn.getAttribute('data-kind');
        var name = btn.getAttribute('data-name') || 'Document';

        if (!hasDialog || !previewDlg) { window.open(src, '_blank', 'noopener'); return; }

        var body = previewDlg.querySelector('[data-dd-preview-body]');
        body.textContent = '';

        var el;
        if (kind === 'pdf') {
            el = document.createElement('iframe');
            el.title = 'Preview of ' + name;
        } else {
            el = document.createElement('img');
            el.alt = 'Preview of ' + name;
        }
        el.src = src;
        body.appendChild(el);

        previewDlg.querySelector('#ddPreviewTitle').textContent = name;
        previewDlg.querySelector('[data-dd-download]').setAttribute('href', btn.getAttribute('data-download') || src);
        previewDlg.showModal();
    }

    if (previewDlg) {
        // Drop the (sensitive) content from the DOM as soon as the preview closes.
        previewDlg.addEventListener('close', function () {
            previewDlg.querySelector('[data-dd-preview-body]').textContent = '';
        });
    }
    // The dialogs sit outside the page root, so they get their own listeners:
    // the backdrop and any [data-dd-close] button dismiss them.
    [previewDlg, confirmDlg].forEach(function (dlg) {
        if (!dlg) { return; }
        dlg.addEventListener('click', function (e) {
            if (e.target === dlg || e.target.closest('[data-dd-close]')) { dlg.close(); }
        });
    });

    // ----------------------------------------------------------------- upload

    /** Reads the driver's own issue/expiry date inputs on this card, if present. */
    function appendDates(wrap, form) {
        var issue = wrap.querySelector('.dd-upload-issue-date');
        var expiry = wrap.querySelector('.dd-upload-expiry-date');
        if (issue && issue.value) { form.append('issue_date', issue.value); }
        if (expiry && expiry.value) { form.append('expiry_date', expiry.value); }
    }

    function startUpload(wrap, file, confirmed) {
        var problem = errorFor(file);
        if (problem) { showMsg(wrap, problem, false); return; }

        if (wrap.getAttribute('data-approved') === '1' && !confirmed) {
            confirmAction({
                title: 'Replace approved document?',
                text: 'This document is already approved. The new file will need to be reviewed again before it is approved.',
                ok: 'Replace Document'
            }, function () { startUpload(wrap, file, true); });
            return;
        }

        var form = new FormData();
        form.append('document', file);
        if (confirmed) { form.append('confirm_replace', '1'); }
        appendDates(wrap, form);

        var progress = wrap.querySelector('.dd-progress');
        var bar      = progress.querySelector('.dd-progress-bar');
        var barFill  = bar.firstElementChild;
        var pct      = progress.querySelector('.dd-progress-pct');
        progress.querySelector('.dd-progress-name').textContent = file.name;

        function paint(p) {
            barFill.style.width = p + '%';
            pct.textContent = p + '%';
            bar.setAttribute('aria-valuenow', p);
        }

        paint(0);
        wrap.querySelector('.dd-msg').hidden = true;
        progress.hidden = false;
        setBusy(wrap, true);

        var xhr = new XMLHttpRequest();
        uploads.set(wrap, xhr);
        xhr.open('POST', wrap.getAttribute('data-upload-url'));
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('X-CSRF-TOKEN', TOKEN);

        xhr.upload.onprogress = function (e) {
            if (e.lengthComputable) { paint(Math.min(99, Math.round(e.loaded / e.total * 100))); }
        };

        function finish() { uploads.delete(wrap); progress.hidden = true; setBusy(wrap, false); }

        xhr.onload = function () {
            var data = parse(xhr);
            finish();

            if (xhr.status >= 200 && xhr.status < 300 && data && data.ok) {
                applyServerResult(wrap, data, 'Uploaded successfully.');
            } else if (xhr.status === 409 && data && data.reason === 'confirm_replace') {
                // The server says it's approved (state changed since the page loaded):
                // re-enter through the confirmation dialog.
                wrap.setAttribute('data-approved', '1');
                startUpload(wrap, file, false);
            } else {
                showMsg(wrap, (data && data.message) || statusMessage(xhr.status), false);
            }
        };
        xhr.onerror = function () { finish(); showMsg(wrap, 'Network problem — the upload didn’t finish. Check your connection and try again.', false); };
        xhr.onabort = function () { finish(); showMsg(wrap, 'Upload cancelled.', false); };

        xhr.send(form);
    }

    // Drag & drop -----------------------------------------------------------

    function hasFiles(e) {
        return e.dataTransfer && Array.prototype.indexOf.call(e.dataTransfer.types || [], 'Files') !== -1;
    }

    root.addEventListener('dragover', function (e) {
        var wrap = e.target.closest && e.target.closest('[data-dd-card]');
        if (!wrap || !hasFiles(e)) { return; }
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
        wrap.querySelector('.dd-card').classList.add('is-dragover');
    });

    root.addEventListener('dragleave', function (e) {
        var wrap = e.target.closest && e.target.closest('[data-dd-card]');
        if (!wrap || wrap.contains(e.relatedTarget)) { return; }
        wrap.querySelector('.dd-card').classList.remove('is-dragover');
    });

    root.addEventListener('drop', function (e) {
        var wrap = e.target.closest && e.target.closest('[data-dd-card]');
        if (!wrap || !hasFiles(e)) { return; }
        e.preventDefault();
        wrap.querySelector('.dd-card').classList.remove('is-dragover');

        var files = e.dataTransfer.files;
        if (files.length !== 1) { showMsg(wrap, 'Please drop one file at a time.', false); return; }
        startUpload(wrap, files[0], false);
    });

    // A file dropped anywhere else must not navigate the browser away from the page.
    ['dragover', 'drop'].forEach(function (type) {
        window.addEventListener(type, function (e) { if (hasFiles(e)) { e.preventDefault(); } });
    });

    // Click & keyboard ------------------------------------------------------

    function pickFile(wrap, confirmed) {
        wrap._confirmed = !!confirmed;
        wrap.querySelector('.dd-input').click();
    }

    root.addEventListener('change', function (e) {
        if (!e.target.classList.contains('dd-input')) { return; }
        var wrap = cardOf(e.target);
        var file = e.target.files && e.target.files[0];
        var confirmed = !!wrap._confirmed;
        wrap._confirmed = false;
        e.target.value = '';           // so picking the same file again still fires "change"
        if (file) { startUpload(wrap, file, confirmed); }
    });

    root.addEventListener('keydown', function (e) {
        var zone = e.target.closest && e.target.closest('[data-dd-pick]');
        if (zone && (e.key === 'Enter' || e.key === ' ')) {
            e.preventDefault();
            pickFile(cardOf(zone), false);
        }
    });

    root.addEventListener('click', function (e) {
        var zone = e.target.closest('[data-dd-pick]');
        if (zone) { pickFile(cardOf(zone), false); return; }

        var btn = e.target.closest('[data-dd-action]');
        if (btn) {
            var wrap = cardOf(btn);
            var action = btn.getAttribute('data-dd-action');

            if (action === 'preview') {
                openPreview(btn);
            } else if (action === 'replace') {
                if (wrap.getAttribute('data-approved') === '1') {
                    confirmAction({
                        title: 'Replace approved document?',
                        text: 'This document is already approved. The new file will need to be reviewed again before it is approved.',
                        ok: 'Choose New File'
                    }, function () { pickFile(wrap, true); });
                } else {
                    pickFile(wrap, false);
                }
            } else if (action === 'delete') {
                confirmAction({
                    title: 'Delete this document?',
                    text: 'The uploaded file will be permanently removed.',
                    ok: 'Delete',
                    danger: true
                }, function () { deleteDocument(wrap, btn.getAttribute('data-url')); });
            } else if (action === 'cancel') {
                var xhr = uploads.get(wrap);
                if (xhr) { xhr.abort(); }
            } else if (action === 'save-dates') {
                saveDates(wrap, btn.getAttribute('data-url'));
            }
        }
    });

    function saveDates(wrap, url) {
        // Visible the instant the click registers, before the network call even
        // starts - so it's obvious from the click alone whether this handler ran.
        showMsg(wrap, 'Saving…', true);

        var form = new FormData();
        appendDates(wrap, form);

        setBusy(wrap, true);
        fetch(url, {
            method: 'POST',
            body: form,
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': TOKEN },
            credentials: 'same-origin'
        }).then(function (res) {
            return res.text().then(function (text) { return { status: res.status, data: parse(text) }; });
        }).then(function (r) {
            setBusy(wrap, false);
            if (r.status >= 200 && r.status < 300 && r.data && r.data.ok) {
                applyServerResult(wrap, r.data, 'Dates saved.');
            } else {
                showMsg(wrap, (r.data && r.data.message) || statusMessage(r.status), false);
            }
        }).catch(function () {
            setBusy(wrap, false);
            showMsg(wrap, 'Network problem — dates weren’t saved. Please try again.', false);
        });
    }

    function deleteDocument(wrap, url) {
        setBusy(wrap, true);
        fetch(url, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': TOKEN },
            credentials: 'same-origin'
        }).then(function (res) {
            return res.text().then(function (text) { return { status: res.status, data: parse(text) }; });
        }).then(function (r) {
            setBusy(wrap, false);
            if (r.status >= 200 && r.status < 300 && r.data && r.data.ok) {
                applyServerResult(wrap, r.data, 'Document removed.');
            } else {
                showMsg(wrap, (r.data && r.data.message) || statusMessage(r.status), false);
            }
        }).catch(function () {
            setBusy(wrap, false);
            showMsg(wrap, 'Network problem — nothing was deleted. Please try again.', false);
        });
    }

    // ------------------------------------------------------------ admin review

    root.addEventListener('click', function (e) {
        var b = e.target.closest('.dd-review-form button[name="action"]');
        if (b) { b.form.setAttribute('data-last-action', b.value); }   // fallback where SubmitEvent.submitter is missing
    });

    // Any form marked data-dd-confirm asks first (approve / decline / deactivate account).
    root.addEventListener('submit', function (e) {
        var form = e.target.closest('form[data-dd-confirm]');
        if (!form || form.getAttribute('data-dd-confirmed')) { return; }
        e.preventDefault();
        confirmAction({
            title: form.getAttribute('data-dd-confirm-title') || 'Are you sure?',
            text: form.getAttribute('data-dd-confirm'),
            ok: form.getAttribute('data-dd-confirm-ok') || 'Confirm',
            danger: form.hasAttribute('data-dd-confirm-danger')
        }, function () {
            form.setAttribute('data-dd-confirmed', '1');
            form.submit();
        });
    });

    root.addEventListener('submit', function (e) {
        var form = e.target.closest('[data-dd-review]');
        if (!form) { return; }
        e.preventDefault();

        var wrap   = cardOf(form);
        var action = (e.submitter && e.submitter.value) || form.getAttribute('data-last-action');
        var errEl  = form.querySelector('.dd-review-error');
        var buttons = form.querySelectorAll('button');
        if (!action) { return; }

        var data = new FormData(form);
        data.set('action', action);

        errEl.hidden = true;
        buttons.forEach(function (b) { b.disabled = true; });

        fetch(form.getAttribute('action'), {
            method: 'POST',
            body: data,
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': TOKEN },
            credentials: 'same-origin'
        }).then(function (res) {
            return res.text().then(function (text) { return { status: res.status, data: parse(text) }; });
        }).then(function (r) {
            if (r.status >= 200 && r.status < 300 && r.data && r.data.ok) {
                applyServerResult(wrap, r.data);
                return;
            }
            buttons.forEach(function (b) { b.disabled = false; });
            var msg = r.data && r.data.errors
                ? Object.keys(r.data.errors).map(function (k) { return r.data.errors[k][0]; })[0]
                : (r.data && r.data.message) || statusMessage(r.status);
            errEl.textContent = msg;
            errEl.hidden = false;
        }).catch(function () {
            buttons.forEach(function (b) { b.disabled = false; });
            errEl.textContent = 'Network problem — nothing was saved. Please try again.';
            errEl.hidden = false;
        });
    });

    // ----------------------------------------------------------------- on load

    var target = root.querySelector('[data-dd-scroll]');
    if (target && target.scrollIntoView) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
})();
