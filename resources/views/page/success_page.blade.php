@extends('layout.app')

@section('content')
    <section class="hero-wrap hero-wrap-2"
             style="background-image: url('/images/bg_1.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="card">
                        <div class="checkmark-icon">
                            <i class="checkmark">✓</i>
                        </div>
                        <h4 class="text-dark">THANH TOÁN THÀNH CÔNG</h4>
                        <p class="text-dark">Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi</p>
                        <p class="text-dark my-3"> VietTravel</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<style>
    body {
        background-color: #f5f5f5;
        font-family: 'Nunito Sans', 'Helvetica Neue', sans-serif;
    }

    .hero-wrap {
        position: relative;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        height: 100vh;
        display: flex;
        align-items: center;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .card {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .checkmark-icon {
        border-radius: 50%;
        height: 200px;
        width: 200px;
        background: #eaf8e1;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }

    .checkmark {
        color: rgb(6, 147, 6);
        font-size: 100px;
    }

    .text-dark {
        color: #150c0c;
        font-size: 24px;
        margin: 0;
    }
</style>
