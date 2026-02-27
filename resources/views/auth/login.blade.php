@extends('layouts.app')

@section('content')
<style>
    .login-page {
        min-height: calc(100vh - 72px);
        background:
            linear-gradient(145deg, rgba(15, 23, 42, 0.86), rgba(30, 41, 59, 0.84)),
            url("{{ asset('imgs/welcome-bg.svg') }}") center/cover no-repeat fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

               .login-card {
        width: min(960px, 100%);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.22);
        background: rgba(15, 23, 42, 0.72);
        box-shadow: 0 24px 60px rgba(2, 6, 23, 0.4);
        backdrop-filter: blur(6px);
        overflow: hidden;
    }

                       .login-header {
        text-align: center;
        padding: 2rem 1rem 1rem;
        color: #f8fafc;
    }

                        .login-logo {
        width: clamp(96px, 18vw, 148px);
        aspect-ratio: 1 / 1;
        object-fit: contain;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.7);
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 10px 30px rgba(2, 6, 23, 0.35);
        margin-bottom: 1rem;
    }

    .login-header h2 {
        margin: 0;
        font-size: clamp(1.4rem, 3.5vw, 2rem);
        font-weight: 800;
    }

    .login-header p {
        margin: .35rem 0 0;
        color: #cbd5e1;
    }

    .login-body {
        padding: 1.4rem 1.2rem 2rem;
        max-width: 760px;
        margin: 0 auto;
    }

    .login-form-wrap {
        background: rgba(255, 255, 255, 0.96);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .login-form-wrap .form-label {
        font-weight: 700;
        color: #1e293b;
    }

    .login-form-wrap .form-check-label {
        color: #334155;
    }

    .login-btn {
        background: linear-gradient(120deg, #2563eb, #7c3aed);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: .65rem 1.2rem;
        border-radius: 10px;
        box-shadow: 0 10px 24px rgba(37, 99, 235, 0.3);
    }

    .login-btn:hover {
        color: #fff;
        filter: brightness(1.03);
    }

    @media (max-width: 767px) {
        .login-form-wrap {
            padding: 1.2rem;
        }
    }
</style>

<div class="login-page">
    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('imgs/school-logo.jpg') }}" alt="Mapandan Catholic School Logo" class="login-logo">
            <h2>Welcome Back</h2>
            <p>Mapandan Catholic School Learning Management System</p>
        </div>

        <div class="login-body container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <div class="login-form-wrap">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email address">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                                
                           <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label> 

                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                     <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                           <div class="d-flex flex-wrap align-items-center gap-2">
                                <button type="submit" class="btn login-btn">

                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                          </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
