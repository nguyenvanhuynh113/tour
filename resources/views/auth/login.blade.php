@extends('layout.app')
@section('content')
    <section class="hero-wrap hero-wrap-2"
             style="background-image: url('/images/bg_1.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
                <div class="col-md-6">
                    <div class="login-container card" style="max-width: 600px;height: auto;padding: 30px">
                        <h2 class="text-center mb-3">{{ __('ĐĂNG NHẬP') }}</h2>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('Địa chỉ email') }}</label>
                                <input id="email" type="email" placeholder="Nhập địa chỉ email của bạn"
                                       class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('Mật khẩu') }}</label>
                                <input id="password" type="password"
                                       placeholder="Mật khẩu"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">{{ __('Lưu đăng nhập') }}</label>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Đăng nhập') }}</button>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Quên mật khẩu?') }}
                                </a>
                            @endif
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
