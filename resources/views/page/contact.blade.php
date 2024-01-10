@extends('layout.app')
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('/images/bg_1.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{\Illuminate\Support\Facades\URL::to('/')}}">Home <i
                                    class="fa fa-chevron-right"></i></a></span> <span>Liên hệ <i
                                class="fa fa-chevron-right"></i></span></p>
                    <h1 class="mb-0 bread">Liên hệ với chúng tôi</h1>
                </div>
            </div>
        </div>
    </section>
    @if(session()->has('message'))
        <div class="alert alert-success" id="messageAlert">
            {{ session()->get('message') }}
        </div>
    @endif
    <script>
        // Tự động ẩn thông báo sau 30 giây
        setTimeout(function () {
            document.getElementById('messageAlert').style.display = 'none';
        }, 10000);
    </script>
    <section class="ftco-section ftco-no-pb contact-section mb-4">
        <div class="container">
            <div class="row d-flex contact-info">
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-map-marker"></span>
                        </div>
                        <h3 class="mb-2">Address</h3>
                        <p>198 West 21th Street, Suite 721 New York NY 10016</p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-phone"></span>
                        </div>
                        <h3 class="mb-2">Contact Number</h3>
                        <p><a href="tel://1234567920">+ 1235 2355 98</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-paper-plane"></span>
                        </div>
                        <h3 class="mb-2">Email Address</h3>
                        <p><a href="mailto:info@yoursite.com">info@yoursite.com</a></p>
                    </div>
                </div>
                <div class="col-md-3 d-flex">
                    <div class="align-self-stretch box p-4 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-globe"></span>
                        </div>
                        <h3 class="mb-2">Website</h3>
                        <p><a href="#">yoursite.com</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section contact-section ftco-no-pt">
        <div class="container">

            <div class="row block-9">
                <div class="col-md-6 order-md-last d-flex">
                    <form action="{{route('lienhe')}}" class="bg-light p-5 contact-form" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="Tên của bạn">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" placeholder="Email của bạn">
                        </div>
                        <div class="form-group">
                            <textarea name="message" id="" cols="30" rows="7" class="form-control"
                                      placeholder="Nhập tin nhắn của bạn tại đây"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Gửi" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>

                </div>
                <div class="col-md-6 d-flex">
                    <div id="map" class="bg-white"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-intro ftco-section ftco-no-pt">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="img" style="background-image: url(/images/bg_2.jpg);">
                        <div class="overlay"></div>
                        <h2>Chúng tôi là VietTravel </h2>
                        <p>Liên hệ ngay với chúng tôi để nhận thông tin về chuyến đi mà bạn đang quan tâm.</p>
                        <p class="mb-0"><a href="{{\Illuminate\Support\Facades\URL::to('/lien-he')}}"
                                           class="btn btn-primary px-4 py-3">Liên hệ ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
