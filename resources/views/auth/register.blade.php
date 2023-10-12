@extends('layout.app')
@section('content')
    <section class="hero-wrap hero-wrap-2"
             style="background-image: url('/images/bg_1.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
                <div class="col-md-8 card px-5"
                     style="max-height: 800px;max-width: 600px;margin-top: 40px;
                     padding-bottom: 30px;padding-top: 30px;">
                    <h2 class="text-center my-3">{{ __('ĐĂNG KÍ') }}</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Tên đăng nhập') }}</label>
                            <input id="name" type="text"
                                   placeholder="Nhập tên đăng nhập"
                                   class="form-control @error('name') is-invalid @enderror" name="name"
                                   value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Địa chỉ email') }}</label>
                            <input id="email" type="email"
                                   placeholder="Nhập địa chỉ email"
                                   class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('Mật khẩu') }}</label>
                            <input id="password" type="password"
                                   placeholder="Mật khẩu tối thiểu 8 kí tự"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">{{ __('Xác nhận mật khẩu') }}</label>

                            <input id="password-confirm" type="password" class="form-control"
                                   placeholder="Xác nhận mật khẩu"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div>
                                <button type="submit" class="btn btn-primary px-5 py-2">
                                    {{ __('Đăng kí') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
