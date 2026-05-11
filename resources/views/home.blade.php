{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            color: #222;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            width: 100%;
            max-width: 600px;
            background: #fff;
            border-radius: 12px;
            padding: 48px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .icon {
            font-size: 64px;
            margin-bottom: 24px;
        }

        h1 {
            margin: 0 0 16px;
            font-size: 36px;
        }

        p {
            margin: 0 0 32px;
            line-height: 1.7;
            color: #666;
            font-size: 16px;
        }

        .button {
            display: inline-block;
            padding: 14px 28px;
            background: #111827;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.2s;
        }

        .button:hover {
            background: #374151;
        }

        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #999;
        }

        @media (max-width: 640px) {
            .card {
                padding: 32px 24px;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    @php
        /*
        |--------------------------------------------------------------------------
        | Frontend Maintenance Mode
        |--------------------------------------------------------------------------
        |
        | true  = show maintenance page
        | false = show homepage
        |
        */
        $maintenance = true;
    @endphp

    @if($maintenance)

        {{-- MAINTENANCE PAGE --}}
        <div class="container">
            <div class="card">

                <div class="icon">
                    🚧
                </div>

                <h1>Website Under Maintenance</h1>

                <p>
                    We are currently performing scheduled maintenance.
                    Please check back again later.
                </p>

                <a href="/admin" class="button">
                    Admin Login
                </a>

                <div class="footer">
                    © {{ date('Y') }} {{ config('app.name') }}
                </div>

            </div>
        </div>

    @else

        {{-- NORMAL HOMEPAGE --}}
        <div class="container">
            <div class="card">

                <h1>Welcome</h1>

                <p>
                    Welcome to {{ config('app.name') }}.
                    Your website is running successfully.
                </p>

                <a href="/admin" class="button">
                    Go to Admin Panel
                </a>

            </div>
        </div>

    @endif

</body>
</html>