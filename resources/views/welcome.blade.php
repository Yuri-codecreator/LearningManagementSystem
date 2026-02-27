<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Learning Management System</title>

    <link rel="shortcut icon" href="{{ asset('favicon_io/favicon.ico') }}">
    <link rel="shortcut icon" sizes="16x16" href="{{ asset('favicon_io/favicon-16x16.png') }}">
    <link rel="shortcut icon" sizes="32x32" href="{{ asset('favicon_io/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" href="{{ asset('favicon_io/android-chrome-192x192.png') }}" sizes="192x192">
    <link rel="icon" href="{{ asset('favicon_io/android-chrome-512x512.png') }}" sizes="512x512">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            color-scheme: light;
            --primary: #2563eb;
            --secondary: #7c3aed;
            --text: #e2e8f0;
            --muted: #cbd5e1;
            --panel: rgba(15, 23, 42, 0.72);
            --panel-border: rgba(255, 255, 255, 0.24);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Nunito', sans-serif;
            color: var(--text);
            background:
                linear-gradient(145deg, rgba(15, 23, 42, 0.86), rgba(30, 41, 59, 0.84)),
                url("{{ asset('imgs/welcome-bg.svg') }}") center/cover no-repeat fixed;
            display: grid;
            place-items: center;
            padding: 1.25rem;
        }

        .hero {
            width: min(920px, 100%);
            border: 1px solid var(--panel-border);
            background: var(--panel);
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(2, 6, 23, 0.38);
            backdrop-filter: blur(6px);
            padding: clamp(1.5rem, 4vw, 3.5rem);
            text-align: center;
        }

        .logo-wrap {
            margin-bottom: 1rem;
        }

        .logo {
            width: clamp(130px, 22vw, 220px);
            aspect-ratio: 1/1;
            object-fit: contain;
            border-radius: 999px;
            border: 4px solid rgba(255, 255, 255, 0.72);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.35);
        }

        h1 {
            font-size: clamp(2rem, 6vw, 3.5rem);
            line-height: 1.1;
            margin: 0.75rem 0 .85rem;
            color: #f8fafc;
        }

        p {
            max-width: 640px;
            margin: 0 auto;
            font-size: clamp(1rem, 2vw, 1.15rem);
            color: var(--muted);
        }

        .actions {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: .85rem;
        }

        .btn {
            display: inline-block;
            padding: .8rem 1.4rem;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
        }

        .btn-primary {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: #fff;
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .meta {
            margin-top: 2rem;
            color: #94a3b8;
            font-size: .9rem;
        }
    </style>
</head>
<body>
    <main class="hero">
        <div class="logo-wrap">
            <img src="{{ asset('imgs/school-logo.jpg') }}" alt="Mapandan Catholic School Logo" class="logo">
        </div>

        <h1>Welcome to Your Learning Management System</h1>

        <p>
            Manage classes, assignments, attendance, and progress in one beautiful place.
            Designed to keep students, teachers, and administrators connected and productive.
        </p>

        <div class="actions">
            @if (Route::has('login'))
               @auth
                    <a href="{{ url('/home') }}" class="btn btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login to Continue</a>
                @endauth
            @endif

         
        </div>

          
    </body>
      </main>
</body>
</html>
