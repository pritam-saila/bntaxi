<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $isReplacement ? 'Document re-uploaded' : 'New document uploaded' }} – {{ $driver->name }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; color: #18304f; }
        .container { max-width: 640px; margin: 24px auto; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,.06); }
        .header { background-color: #0757d9; padding: 22px 20px; color: #fff; }
        .header h1 { margin: 0; font-size: 19px; }
        .header p { margin: 4px 0 0; font-size: 12px; opacity: .9; }
        .content { padding: 24px 22px; }
        .ref { font-size: 13px; color: #555; margin-bottom: 16px; }
        .ref strong { color: #063b91; font-size: 15px; }
        .section-title { font-size: 13px; font-weight: bold; color: #0757d9; border-bottom: 2px solid #eaeaea; padding-bottom: 6px; margin: 20px 0 12px; text-transform: uppercase; }
        .detail-table { width: 100%; border-collapse: collapse; }
        .detail-table th { text-align: left; padding: 9px 10px; background-color: #f8f9fa; border-bottom: 1px solid #eee; width: 36%; font-weight: 600; font-size: 13px; }
        .detail-table td { padding: 9px 10px; border-bottom: 1px solid #eee; font-size: 13px; }
        .pill { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 700; background: #eaf3ff; color: #063b91; }
        .pill-replace { background: #fff7e6; color: #b45309; }
        .btn-row { text-align: center; margin: 26px 0 6px; }
        .btn { display: inline-block; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; background: #0757d9; color: #fff; }
        .footer { background-color: #f8f9fa; text-align: center; padding: 16px; font-size: 11px; color: #888; border-top: 1px solid #eee; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{ $isReplacement ? 'Document re-uploaded' : 'New document uploaded' }}</h1>
        <p>Action required &mdash; waiting for your review</p>
    </div>

    <div class="content">
        <div class="ref">
            <strong>{{ $driver->name }}</strong>
            &nbsp;&bull;&nbsp; {{ optional($document->uploaded_at)->format('d M Y H:i') }}
            &nbsp;&bull;&nbsp; <span class="pill {{ $isReplacement ? 'pill-replace' : '' }}">{{ $isReplacement ? 'Replacement' : 'First upload' }}</span>
        </div>

        <div class="section-title">Document</div>
        <table class="detail-table">
            <tr><th>Type</th><td>{{ $document->definition()['label'] ?? $document->type }}</td></tr>
            <tr><th>File</th><td>{{ $document->original_name }} ({{ $document->fileTypeLabel() }}, {{ $document->humanSize() }})</td></tr>
            <tr><th>Status</th><td>{{ $document->statusLabel() }}</td></tr>
        </table>

        <div class="section-title">Driver</div>
        <table class="detail-table">
            <tr><th>Name</th><td>{{ $driver->name }}</td></tr>
            <tr><th>Phone</th><td><a href="tel:{{ $driver->phone }}">{{ $driver->phone }}</a></td></tr>
            <tr><th>Email</th><td><a href="mailto:{{ $driver->email }}">{{ $driver->email }}</a></td></tr>
        </table>

        <div class="btn-row">
            <a href="{{ route('admin.dv.show', $driver) }}#doc-{{ $document->type }}" class="btn">Review this document</a>
        </div>
    </div>

    <div class="footer">
        BN Taxi Anytime &mdash; automated driver verification notice
    </div>
</div>
</body>
</html>
