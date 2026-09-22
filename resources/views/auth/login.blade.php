@extends('layouts.app')

@section('content')

<div class="bnl-page">

    <div class="bnl-card">

        <div class="bnl-brand">
            <img src="{{ url('goods/images/logo.png') }}" alt="BN Taxi Anytime" onerror="this.style.display='none'">
        </div>

        <h1 class="bnl-title">Admin Portal</h1>
        <p class="bnl-subtitle">Sign in to manage bookings, drivers and payments</p>

        @if(session('error'))
            <div class="bnl-alert" role="alert">
                <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M12 2 1 21h22L12 2Zm0 6a1 1 0 0 1 1 1v5a1 1 0 1 1-2 0V9a1 1 0 0 1 1-1Zm0 9.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any() && !session('error'))
            <div class="bnl-alert" role="alert">
                <svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true"><path fill="currentColor" d="M12 2 1 21h22L12 2Zm0 6a1 1 0 0 1 1 1v5a1 1 0 1 1-2 0V9a1 1 0 0 1 1-1Zm0 9.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5Z"/></svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="bnl-form" novalidate>
            @csrf
            <input type="hidden" name="type" value="1">

            <label class="bnl-label" for="email">Email address</label>
            <div class="bnl-field {{ $errors->has('email') ? 'is-invalid' : '' }}">
                <svg class="bnl-ico" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Zm0 2v.4l8 5 8-5V6H4Zm16 2.7-7.5 4.7a1 1 0 0 1-1 0L4 8.7V18h16V8.7Z"/></svg>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       placeholder="you@bntaxianytime.com" autocomplete="email" autofocus required>
            </div>
            @error('email')<div class="bnl-err">{{ $message }}</div>@enderror

            <label class="bnl-label" for="password">Password</label>
            <div class="bnl-field {{ $errors->has('password') ? 'is-invalid' : '' }}">
                <svg class="bnl-ico" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M12 1a5 5 0 0 0-5 5v3H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-9a2 2 0 0 0-2-2h-1V6a5 5 0 0 0-5-5Zm3 8H9V6a3 3 0 1 1 6 0v3Zm-3 4a1.75 1.75 0 0 1 1 3.19V19a1 1 0 1 1-2 0v-1.81A1.75 1.75 0 0 1 12 13Z"/></svg>
                <input id="password" type="password" name="password"
                       placeholder="Enter your password" autocomplete="current-password" required>
                <button type="button" class="bnl-toggle" id="bnlToggle" aria-label="Show password">
                    <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M12 5c-5 0-9.27 3.11-11 7 1.73 3.89 6 7 11 7s9.27-3.11 11-7c-1.73-3.89-6-7-11-7Zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10Zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg>
                </button>
            </div>
            @error('password')<div class="bnl-err">{{ $message }}</div>@enderror

            <button type="submit" class="bnl-submit">
                Sign in
                <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><path fill="currentColor" d="M13 5l7 7-7 7-1.4-1.4 4.6-4.6H4v-2h12.2l-4.6-4.6L13 5Z"/></svg>
            </button>
        </form>

        <p class="bnl-foot">
            <svg viewBox="0 0 24 24" width="13" height="13" aria-hidden="true"><path fill="currentColor" d="M12 1 3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4Zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8Z"/></svg>
            Authorised access only. All activity is logged.
        </p>

    </div>

    <p class="bnl-copy">&copy; {{ date('Y') }} BN Taxi Anytime</p>

</div>

<style>
    /* ---- neutralise the default app layout chrome ---- */
    body { margin: 0; background: #0a1f44; }
    #app { width: auto !important; margin: 0 !important; background: transparent !important;
           padding: 0 !important; border-radius: 0 !important; box-shadow: none !important; min-height: 100vh; }
    #app > nav.navbar { display: none !important; }
    #app > main.py-4 { padding: 0 !important; }

    /* ---- page ---- */
    .bnl-page {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 16px;
        font-family: "Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        color: #172b4d;
        background:
            radial-gradient(1100px 520px at 15% -10%, rgba(56,132,255,.55), transparent 60%),
            radial-gradient(900px 500px at 110% 110%, rgba(9,50,120,.65), transparent 55%),
            linear-gradient(135deg, #0a1f44 0%, #0f2f6b 45%, #0a2350 100%);
    }

    /* subtle road-dash motif */
    .bnl-page::before {
        content: "";
        position: fixed;
        left: 0; right: 0; bottom: 0;
        height: 120px;
        background-image: repeating-linear-gradient(90deg, rgba(255,255,255,.14) 0 44px, transparent 44px 92px);
        -webkit-mask-image: linear-gradient(to top, #000, transparent);
                mask-image: linear-gradient(to top, #000, transparent);
        pointer-events: none;
    }

    /* ---- card ---- */
    .bnl-card {
        position: relative;
        width: 100%;
        max-width: 420px;
        background: #fff;
        border-radius: 20px;
        padding: 38px 34px 30px;
        box-shadow: 0 30px 70px -20px rgba(4, 15, 40, .55), 0 8px 24px rgba(4, 15, 40, .25);
    }
    .bnl-card::before {
        content: "";
        position: absolute; inset: 0 0 auto 0;
        height: 5px;
        border-radius: 20px 20px 0 0;
        background: linear-gradient(90deg, #0757d9, #3b82f6, #0757d9);
    }

    .bnl-brand { text-align: center; margin-bottom: 18px; }
    .bnl-brand img { height: 52px; width: auto; }

    .bnl-title {
        margin: 0;
        text-align: center;
        font-size: 22px;
        font-weight: 800;
        letter-spacing: -.2px;
        color: #0f2340;
    }
    .bnl-subtitle {
        margin: 6px 0 22px;
        text-align: center;
        font-size: 13px;
        color: #64748b;
    }

    /* ---- alert ---- */
    .bnl-alert {
        display: flex;
        align-items: center;
        gap: 9px;
        background: #fff1f1;
        border: 1px solid #f5c2c2;
        color: #b91c1c;
        border-radius: 10px;
        padding: 10px 13px;
        font-size: 12.5px;
        font-weight: 700;
        margin-bottom: 18px;
    }
    .bnl-alert svg { flex: 0 0 16px; }

    /* ---- form ---- */
    .bnl-form { display: block; }
    .bnl-label {
        display: block;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .4px;
        color: #475569;
        margin: 14px 0 7px;
    }
    .bnl-field {
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1.5px solid #d7dee8;
        border-radius: 11px;
        padding: 0 12px;
        background: #f8fafc;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .bnl-field:focus-within {
        border-color: #0757d9;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(7, 87, 217, .12);
    }
    .bnl-field.is-invalid {
        border-color: #dc2626;
        background: #fff;
    }
    .bnl-ico { color: #94a3b8; flex: 0 0 18px; }
    .bnl-field:focus-within .bnl-ico { color: #0757d9; }

    .bnl-field input {
        flex: 1 1 auto;
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        padding: 13px 0;
        font-size: 14px;
        font-family: inherit;
        color: #172b4d;
    }
    .bnl-field input::placeholder { color: #9aa7b8; }
    .bnl-field input:-webkit-autofill { -webkit-box-shadow: 0 0 0 40px #f8fafc inset; }

    .bnl-toggle {
        flex: 0 0 auto;
        border: 0;
        background: transparent;
        color: #94a3b8;
        cursor: pointer;
        padding: 6px;
        display: flex;
        border-radius: 7px;
    }
    .bnl-toggle:hover { color: #0757d9; background: #eef4ff; }
    .bnl-toggle.is-on { color: #0757d9; }

    .bnl-err {
        color: #dc2626;
        font-size: 11.5px;
        font-weight: 700;
        margin-top: 6px;
    }

    .bnl-submit {
        width: 100%;
        margin-top: 24px;
        border: 0;
        border-radius: 11px;
        padding: 14px 18px;
        background: linear-gradient(135deg, #0757d9, #063b91);
        color: #fff;
        font-size: 14.5px;
        font-weight: 800;
        font-family: inherit;
        letter-spacing: .2px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 12px 26px -10px rgba(7, 87, 217, .7);
        transition: transform .12s ease, box-shadow .15s ease, filter .15s ease;
    }
    .bnl-submit:hover { transform: translateY(-1px); filter: brightness(1.05); box-shadow: 0 16px 30px -10px rgba(7, 87, 217, .75); }
    .bnl-submit:active { transform: translateY(0); }

    .bnl-foot {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin: 22px 0 0;
        font-size: 11.5px;
        color: #94a3b8;
        font-weight: 600;
    }

    .bnl-copy {
        margin: 22px 0 0;
        font-size: 12px;
        color: rgba(255, 255, 255, .6);
        font-family: "Nunito", system-ui, sans-serif;
    }

    @media (max-width: 480px) {
        .bnl-card { padding: 30px 22px 26px; border-radius: 16px; }
        .bnl-title { font-size: 20px; }
    }
</style>

<script>
    (function () {
        var btn = document.getElementById('bnlToggle');
        var pw = document.getElementById('password');
        if (btn && pw) {
            btn.addEventListener('click', function () {
                var show = pw.type === 'password';
                pw.type = show ? 'text' : 'password';
                btn.classList.toggle('is-on', show);
                btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                pw.focus();
            });
        }
    })();
</script>
@endsection
