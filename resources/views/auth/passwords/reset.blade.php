@extends('layout.app')

@section('content')
    <section class="hero-wrap hero-wrap-2"
             style="background-image: url('/images/bg_1.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
                <div class="col-md-8 card " style="height: auto;max-width: 800px;padding: 40px">
                    <h2 class="text-uppercase text-center mb-3 mt-2">Đặt lại mật khẩu</h2>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label for="email">{{ __('Địa chỉ email') }}</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror" name="email"
                                   value="{{ $email ?? old('email') }}" required autocomplete="email"
                                   autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Mật khẩu mới') }}</label>
                            <input id="password" type="password"
                                   placeholder="Nhập mật khẩu mới của bạn"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   required autocomplete="new-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="password-confirm">{{ __('Xác nhận lại mật khẩu') }}</label>
                            <input id="password-confirm" type="password" class="form-control"
                                   placeholder="Xác nhận mật khẩu"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Cập nhật mật khẩu') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
