<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact enquiry</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background:#f4f6f9; margin:0; padding:0; color:#222; }
        .container { max-width:600px; margin:24px auto; background:#fff; border-radius:10px; overflow:hidden; box-shadow:0 4px 15px rgba(0,0,0,.06); }
        .header { background:#0b3c5d; color:#fff; padding:22px 20px; }
        .header h1 { margin:0; font-size:18px; }
        .content { padding:24px 22px; }
        table { width:100%; border-collapse:collapse; }
        th { text-align:left; width:32%; padding:10px; background:#f8f9fa; border-bottom:1px solid #eee; font-size:13px; vertical-align:top; }
        td { padding:10px; border-bottom:1px solid #eee; font-size:13px; vertical-align:top; }
        .msg { white-space:pre-wrap; }
        .footer { background:#f8f9fa; text-align:center; padding:14px; font-size:11px; color:#888; border-top:1px solid #eee; }
    </style>
</head>
<body>
<div class="container">
    <div class="header"><h1>New contact enquiry &mdash; BN Taxi Anytime</h1></div>
    <div class="content">
        <table>
            <tr><th>Name</th><td>{{ $data['name'] ?? '' }}</td></tr>
            <tr><th>Email</th><td><a href="mailto:{{ $data['email'] ?? '' }}">{{ $data['email'] ?? '' }}</a></td></tr>
            @if(!empty($data['phone']))
                <tr><th>Phone</th><td><a href="tel:{{ $data['phone'] }}">{{ $data['phone'] }}</a></td></tr>
            @endif
            <tr><th>Message</th><td class="msg">{{ $data['message'] ?? '' }}</td></tr>
            <tr><th>Submitted</th><td>{{ $data['submitted_at'] ?? now()->format('d M Y H:i') }}</td></tr>
            @if(!empty($data['ip']))
                <tr><th>IP address</th><td>{{ $data['ip'] }}</td></tr>
            @endif
        </table>
    </div>
    <div class="footer">Reply directly to this email to respond to {{ $data['name'] ?? 'the sender' }}.</div>
</div>
</body>
</html>
