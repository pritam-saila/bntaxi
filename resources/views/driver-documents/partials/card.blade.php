{{--
    Reusable document upload card - one per document type, used by both the
    driver and the admin screens (and re-rendered by the upload/review XHR).

    Expects: $type, $def, $doc (DriverDocument|null), $mode, $routes
--}}
@php
    $admin    = $mode === 'admin';
    $status   = $doc?->effectiveStatus() ?? 'not_uploaded';
    $expiry   = $doc?->expiryInfo();
    $approved = $status === 'approved';                       // currently valid approval: replacing needs confirmation
    $label    = \App\Models\DriverDocument::STATUS_LABELS[$status];
    $canDelete = $doc && ($admin || !$approved);
@endphp
<div class="dd-card-wrap" id="doc-{{ $type }}" data-dd-card
     data-type="{{ $type }}"
     data-label="{{ $def['label'] }}"
     data-upload-url="{{ $routes->upload($type) }}"
     data-approved="{{ $approved ? 1 : 0 }}">
    <article class="dd-card dd-card-{{ $status }}">

        <header class="dd-card-head">
            <div class="dd-card-title">
                <h4>{{ $def['label'] }}</h4>
                <span class="dd-tag {{ $def['required'] ? 'dd-tag-req' : '' }}">{{ $def['required'] ? 'Required' : 'Optional' }}</span>
            </div>
            <span class="dd-badge dd-badge-{{ $status }}">{{ $label }}</span>
        </header>
        <p class="dd-desc">{{ $def['description'] }}</p>

        @if(!$doc)
            {{-- ───────── Empty: drop zone ───────── --}}
            <div class="dd-drop" role="button" tabindex="0" data-dd-pick aria-label="Upload {{ $def['label'] }}. Drag and drop a file here, or press Enter to browse.">
                <svg class="dd-drop-icon" viewBox="0 0 24 24" width="34" height="34" aria-hidden="true"><path fill="currentColor" d="M19.4 10.1A7.5 7.5 0 0 0 5.1 8.6 5.5 5.5 0 0 0 6 19.5h11.5a4.5 4.5 0 0 0 1.9-8.4zM13 13v4h-2v-4H8l4-4.5 4 4.5h-3z"/></svg>
                <span class="dd-drop-main">Drag &amp; drop your file here</span>
                <span class="dd-drop-or">or</span>
                <span class="dd-btn dd-btn-primary dd-btn-sm">Browse Files</span>
                <span class="dd-drop-hint">PDF, JPG, JPEG or PNG · max {{ round(config('driver_documents.max_size_kb') / 1024) }} MB</span>
            </div>
        @else
            {{-- ───────── Uploaded file ───────── --}}
            <div class="dd-file">
                <div class="dd-thumb {{ $doc->isPdf() ? 'dd-thumb-pdf' : 'dd-thumb-img' }}">
                    @if($doc->isImage() && $doc->thumb_path)
                        <img src="{{ $routes->file($doc, thumb: true) }}" alt="Thumbnail of {{ $doc->original_name }}" loading="lazy" width="72" height="72">
                    @elseif($doc->isPdf())
                        <svg viewBox="0 0 24 24" width="30" height="30" aria-hidden="true"><path fill="currentColor" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 7V3.5L18.5 9H13zM8.5 17.5v-4h1.4c.9 0 1.5.5 1.5 1.3s-.6 1.3-1.5 1.3h-.6v1.4h-.8zm.8-2.1h.5c.4 0 .6-.2.6-.5s-.2-.5-.6-.5h-.5v1zm2.7 2.1v-4h1.2c1.2 0 2 .8 2 2s-.8 2-2 2H12zm.8-.7h.4c.7 0 1.1-.5 1.1-1.3s-.4-1.3-1.1-1.3h-.4v2.6zm3-.1v-3.2h2v.7h-1.2v.7h1v.7h-1v1.1h-.8z"/></svg>
                        <span>PDF</span>
                    @else
                        <svg viewBox="0 0 24 24" width="30" height="30" aria-hidden="true"><path fill="currentColor" d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5z"/></svg>
                    @endif
                </div>
                <div class="dd-file-meta">
                    <strong class="dd-file-name" title="{{ $doc->original_name }}">{{ $doc->original_name }}</strong>
                    <span class="dd-file-line">{{ $doc->fileTypeLabel() }} · {{ $doc->humanSize() }}</span>
                    <span class="dd-file-line">Uploaded {{ $doc->uploaded_at?->format('d M Y, H:i') }}</span>
                </div>
            </div>

            @if($doc->issue_date || $expiry)
                <dl class="dd-dates">
                    @if($doc->issue_date)
                        <div><dt>Issued</dt><dd>{{ $doc->issue_date->format('d M Y') }}</dd></div>
                    @endif
                    @if($doc->expiry_date)
                        <div><dt>Expires</dt><dd>{{ $doc->expiry_date->format('d M Y') }}</dd></div>
                    @endif
                </dl>
            @endif

            @if($expiry && $expiry['state'] !== 'valid')
                <p class="dd-expiry dd-expiry-{{ $expiry['state'] }}" role="status">
                    <span aria-hidden="true">{{ $expiry['state'] === 'expired' ? '⛔' : '⚠' }}</span> {{ $expiry['label'] }}
                </p>
            @endif

            @if($doc->status === 'rejected')
                <div class="dd-reject" role="alert">
                    <strong>Rejected{{ $doc->rejected_at ? ' on ' . $doc->rejected_at->format('d M Y') : '' }}</strong>
                    <p>{{ $doc->rejection_reason }}</p>
                </div>
            @endif

            <div class="dd-actions">
                <button type="button" class="dd-btn dd-btn-outline dd-btn-sm" data-dd-action="preview"
                        data-src="{{ $routes->file($doc) }}"
                        data-download="{{ $routes->file($doc, download: true) }}"
                        data-kind="{{ $doc->isPdf() ? 'pdf' : 'image' }}"
                        data-name="{{ $doc->original_name }}">Preview</button>

                @if($doc->status === 'rejected')
                    <button type="button" class="dd-btn dd-btn-primary dd-btn-sm" data-dd-action="replace">Re-upload</button>
                @elseif($status === 'expired')
                    <button type="button" class="dd-btn dd-btn-primary dd-btn-sm" data-dd-action="replace">Upload Renewed Copy</button>
                @elseif($approved)
                    <button type="button" class="dd-btn dd-btn-outline dd-btn-sm" data-dd-action="replace">Replace Document</button>
                @else
                    <button type="button" class="dd-btn dd-btn-outline dd-btn-sm" data-dd-action="replace">Replace</button>
                @endif

                @if($canDelete)
                    <button type="button" class="dd-btn dd-btn-danger-outline dd-btn-sm" data-dd-action="delete"
                            data-url="{{ $routes->destroy($doc) }}">Delete</button>
                @endif
            </div>

            @if($approved && !$admin)
                <p class="dd-note">This document is approved. Replacing it will send the new file back for review.</p>
            @endif
        @endif

        {{-- Upload progress / result (driven by JS) --}}
        <div class="dd-progress" hidden>
            <div class="dd-progress-top">
                <span class="dd-progress-name"></span>
                <span class="dd-progress-pct">0%</span>
            </div>
            <div class="dd-progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><span></span></div>
            <button type="button" class="dd-link" data-dd-action="cancel">Cancel</button>
        </div>
        <p class="dd-msg" role="alert" aria-live="assertive" hidden></p>

        <input type="file" class="dd-input" accept=".pdf,.jpg,.jpeg,.png,application/pdf,image/jpeg,image/png" hidden tabindex="-1" aria-hidden="true">

        {{-- ───────── Admin: dates, decision, history ───────── --}}
        @if($admin && $doc)
            <details class="dd-review" @if(in_array($doc->status, ['uploaded', 'under_review'])) open @endif>
                <summary>Review &amp; history</summary>

                <form class="dd-review-form" data-dd-review action="{{ $routes->review($doc) }}" method="POST" novalidate>
                    @csrf
                    @if($def['has_issue_date'] || $def['has_expiry'])
                        <div class="dd-row">
                            @if($def['has_issue_date'])
                                <label class="dd-mini">Issue date
                                    <input type="date" name="issue_date" value="{{ $doc->issue_date?->format('Y-m-d') }}">
                                </label>
                            @endif
                            @if($def['has_expiry'])
                                <label class="dd-mini">Expiry date <span class="dd-req-star" title="Required to approve">*</span>
                                    <input type="date" name="expiry_date" value="{{ $doc->expiry_date?->format('Y-m-d') }}">
                                </label>
                            @endif
                        </div>
                    @endif

                    <label class="dd-mini">Message to the driver <small>(required to reject or request a re-upload)</small>
                        <textarea name="reason" rows="2" maxlength="2000" data-no-richtext placeholder="e.g. The image is blurry — please upload a clearer photo."></textarea>
                    </label>
                    <label class="dd-mini">Internal note <small>(never shown to the driver)</small>
                        <textarea name="note" rows="2" maxlength="2000" data-no-richtext></textarea>
                    </label>

                    <p class="dd-review-error" role="alert" hidden></p>

                    <div class="dd-actions">
                        <button type="submit" name="action" value="approve" class="dd-btn dd-btn-success dd-btn-sm">Approve</button>
                        <button type="submit" name="action" value="reject" class="dd-btn dd-btn-danger dd-btn-sm">Reject</button>
                        <button type="submit" name="action" value="reupload" class="dd-btn dd-btn-warn dd-btn-sm">Request Re-upload</button>
                        @if($def['has_issue_date'] || $def['has_expiry'])
                            <button type="submit" name="action" value="dates" class="dd-btn dd-btn-outline dd-btn-sm">Save Dates</button>
                        @endif
                        <button type="submit" name="action" value="note" class="dd-btn dd-btn-outline dd-btn-sm">Add Note</button>
                    </div>
                </form>

                <h5 class="dd-hist-title">Review history</h5>
                @include('driver-documents.partials.history', ['reviews' => $doc->reviews])
            </details>
        @endif
    </article>
</div>
