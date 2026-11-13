<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New driver application – {{ $driver->name }}</title>
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
        .btn-row { text-align: center; margin: 26px 0 6px; }
        .btn { display: inline-block; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; background: #0757d9; color: #fff; }
        .checklist { margin: 0; padding-left: 18px; font-size: 13px; color: #444; }
        .checklist li { margin-bottom: 4px; }
        .footer { background-color: #f8f9fa; text-align: center; padding: 16px; font-size: 11px; color: #888; border-top: 1px solid #eee; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>New driver application</h1>
        <p>Action required &mdash; documents are waiting to be verified</p>
    </div>

    <div class="content">
        <div class="ref">
            <strong>{{ $driver->name }}</strong> registered
            &nbsp;&bull;&nbsp; {{ optional($driver->created_at)->format('d M Y H:i') ?? now()->format('d M Y H:i') }}
            &nbsp;&bull;&nbsp; <span class="pill">Pending verification</span>
        </div>

        <div class="section-title">Driver</div>
        <table class="detail-table">
            <tr><th>Name</th><td>{{ $driver->name }}</td></tr>
            <tr><th>Phone</th><td><a href="tel:{{ $driver->phone }}">{{ $driver->phone }}</a></td></tr>
            <tr><th>Email</th><td><a href="mailto:{{ $driver->email }}">{{ $driver->email }}</a></td></tr>
            <tr><th>Address</th><td>{{ $driver->address }}@if($driver->postcode), {{ $driver->postcode }}@endif</td></tr>
        </table>

        <div class="section-title">Vehicle</div>
        <table class="detail-table">
            <tr><th>Make &amp; model</th><td>{{ $driver->make }} {{ $driver->model }}</td></tr>
            <tr><th>Registration</th><td>{{ $driver->vehicleregnumber }}</td></tr>
        </table>

        <div class="section-title">Next</div>
        <ul class="checklist">
            <li>The driver still needs to upload their licence, insurance, inspection and V5C documents.</li>
            <li>You'll get a separate email each time one is uploaded, so you can review it as it comes in.</li>
            <li>Their account stays inactive until you approve the application from the review screen.</li>
        </ul>

        <div class="btn-row">
            <a href="{{ route('admin.dv.show', $driver) }}" class="btn">Review application</a>
        </div>
    </div>

    <div class="footer">
        BN Taxi Anytime &mdash; automated driver verification notice
    </div>
</div>
</body>
</html>
