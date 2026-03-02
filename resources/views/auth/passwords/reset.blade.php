@extends('layouts.app')

@section('content')
<style>
    .reset-password-page {
        min-height: calc(100vh - 72px);
        background:
            linear-gradient(145deg, rgba(15, 23, 42, 0.86), rgba(30, 41, 59, 0.84)),
            url("{{ asset('imgs/welcome-bg.svg') }}") center/cover no-repeat fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .reset-password-card {
        width: min(760px, 100%);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.22);
        background: rgba(15, 23, 42, 0.72);
        box-shadow: 0 24px 60px rgba(2, 6, 23, 0.4);
        backdrop-filter: blur(6px);
        overflow: hidden;
    }

    .reset-password-card .card-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        background: transparent;
        color: #f8fafc;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .reset-password-card .card-body {
        background: rgba(255, 255, 255, 0.96);
    }
</style>

<div class="reset-password-page">
    <div class="reset-password-card card">
        <div class="card-header">{{ __('Reset Password') }}</div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
  </form>
        </div>
    </div>
</div>
@endsection
