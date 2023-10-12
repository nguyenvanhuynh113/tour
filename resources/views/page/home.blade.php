@extends('layout.app')
@section('content')
    <div class="hero-wrap js-fullheight" style="background-image: url('/images/bg_5.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
                <div class="col-md-7 ftco-animate">
                    <span class="subheading">Chào mừng bạn đến với VietTravel</span>
                    <h1 class="mb-4">Khám phá những địa điểm yêu thích của bạn vói chúng tôi.</h1>
                    <p class="caps">Du lịch đến mọi nơi trên thế giới.</p>
                </div>
            </div>
        </div>
    </div>
    <section class="ftco-section ftco-no-pb ftco-no-pt">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ftco-search d-flex justify-content-center">
                        <div class="row">
                            <div class="col-md-12 nav-link-wrap">
                                <div class="nav nav-pills text-center" id="v-pills-tab" role="tablist"
                                     aria-orientation="vertical">
                                    <a class="nav-link active mr-md-1" id="v-pills-1-tab" data-toggle="pill"
                                       href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">Tìm
                                        kiếm chuyến đi</a>
                                </div>
                            </div>
                            <div class="col-md-12 tab-wrap">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-1" role="tabpanel"
                                         aria-labelledby="v-pills-nextgen-tab">
                                        <form action="#" class="search-property-1">
                                            <div class="row no-gutters">
                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4 border-0">
                                                        <label for="#">Địa điểm</label>
                                                        <div class="form-field">
                                                            <div class="icon"><span class="fa fa-search"></span></div>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Tìm kiếm địa điểm">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4">
                                                        <label for="#">Ngày bắt đầu</label>
                                                        <div class="form-field">
                                                            <div class="icon"><span class="fa fa-calendar"></span></div>
                                                            <input type="text" class="form-control checkin_date"
                                                                   placeholder="Ngày khởi hành">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4">
                                                        <label for="#">Ngày kết thúc</label>
                                                        <div class="form-field">
                                                            <div class="icon"><span class="fa fa-calendar"></span></div>
                                                            <input type="text" class="form-control checkout_date"
                                                                   placeholder='Ngày kết thúc'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4">
                                                        <label for="#">Giá</label>
                                                        <div class="form-field">
                                                            <div class="select-wrap">
                                                                <div class="icon"><span
                                                                        class="fa fa-chevron-down"></span></div>
                                                                <select name="" id="" class="form-control">
                                                                    <option value="">$100</option>
                                                                    <option value="">$10,000</option>
                                                                    <option value="">$50,000</option>
                                                                    <option value="">$100,000</option>
                                                                    <option value="">$200,000</option>
                                                                    <option value="">$300,000</option>
                                                                    <option value="">$400,000</option>
                                                                    <option value="">$500,000</option>
                                                                    <option value="">$600,000</option>
                                                                    <option value="">$700,000</option>
                                                                    <option value="">$800,000</option>
                                                                    <option value="">$900,000</option>
                                                                    <option value="">$1,000,000</option>
                                                                    <option value="">$2,000,000</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md d-flex">
                                                    <div class="form-group d-flex w-100 border-0">
                                                        <div class="form-field w-100 align-items-center d-flex">
                                                            <input type="submit" value="Tìm kiếm "
                                                                   class="align-self-stretch form-control btn btn-primary">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="ftco-section img ftco-select-destination" style="background-image: url(images/bg_3.jpg);">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Địa điểm nổi bật của chúng tôi</span>
                    <h2 class="mb-4">Chọn nơi mà bạn muốn đến</h2>
                </div>
            </div>
        </div>
        <div class="container container-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="carousel-destination owl-carousel ftco-animate">
                        @foreach($place as $item)
                            <div class="item">
                                <div class="project-destination">
                                    <a href="{{\Illuminate\Support\Facades\URL::to('dia-diem-du-lich/'.$item->slug)}}"
                                       class="img"
                                       style="background-image: url('http://127.0.0.1:8000/storage/{{$item->image}}');">
                                        <div class="text">
                                            <h3>{{$item->name}}</h3>
                                            <span>{{count($item->tours)}} tour</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Những chuyến đi mới nhất</span>
                    <h2 class="mb-4">Mới cập nhật</h2>
                </div>
            </div>
            <div class="row">
                @foreach($tour as $item)
                    <div class="col-md-4 ftco-animate">
                        <div class="project-wrap">
                            <a href="{{\Illuminate\Support\Facades\URL::to('chi-tiet-chuyen-di/'.$item->slug)}}"
                               class="img"
                               style="background-image: url('http://127.0.0.1:8000/storage/{{$item->image}}');">
                                <span class="price">{{number_format($item->normal_prices,0,',','.')}}/người</span>
                            </a>
                            <div class="text p-4">
                                <span class="days">{{$item->total_date_tour}} ngày</span>
                                <h4>
                                    <a href="{{\Illuminate\Support\Facades\URL::to('chi-tiet-chuyen-di/'.$item->slug)}}">{{$item->title}}</a>
                                </h4>
                                <p class="location"><span class="fa fa-map-marker"></span> {{$item->des_address}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-about img" style="background-image: url(images/bg_4.jpg);">
        <div class="overlay"></div>
        <div class="container py-md-5">
            <div class="row py-md-5">
                <div class="col-md d-flex align-items-center justify-content-center">
                </div>
            </div>
    </section>

    <section class="ftco-section ftco-about ftco-no-pt img">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-12 about-intro">
                    <div class="row">
                        <div class="col-md-6 d-flex align-items-stretch">
                            <div class="img d-flex w-100 align-items-center justify-content-center"
                                 style="background-image:url(images/about-1.jpg);">
                            </div>
                        </div>
                        <div class="col-md-6 pl-md-5 py-5">
                            <div class="row justify-content-start pb-3">
                                <div class="col-md-12 heading-section ftco-animate">
                                    <span class="subheading">About Us</span>
                                    <h2 class="mb-4">Hãy tận hưởng chuyến đi đáng nhớ và an toàn với chúng tôi.</h2>
                                    <p>Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                                        right at the coast of the Semantics, a large language ocean.</p>
                                    <p><a href="#" class="btn btn-primary">Đặt chỗ ngay</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Bài viết của chúng tôi</span>
                    <h2 class="mb-4">Bài viết gần đây</h2>
                </div>
            </div>
            <div class="row d-flex">
                @foreach($blog as $item)
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="blog-entry justify-content-end">
                            <a href="{{\Illuminate\Support\Facades\URL::to('chi-tiet-bai-viet/'.$item->slug)}}"
                               class="block-20"
                               style="background-image: url('http://127.0.0.1:8000/storage/{{$item->image}}');">
                            </a>
                            <div class="text">
                                @php
                                    //Lấy ngày tháng năm chuyển đổi sang tiếng việt
                                        $created_at = $item->created_at; // Chuỗi ngày tháng và giờ
                                        $timestamp = strtotime($created_at); // Chuyển đổi thành timestamp
                                        // Tách ngày thành định dạng mảng [năm, tháng, ngày]
                                        $date = getdate($timestamp);
                                        $year = $date['year'];
                                        $month = $date['mon'];
                                        $day = $date['mday'];
                                        $monthNamesVietnamese = [
                                        '', 'Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu',
                                        'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai'
                                        ];
                                        // Lấy tên tháng tiếng Việt từ số tháng
                                        $monthNameVietnamese = $monthNamesVietnamese[$month];
                                @endphp
                                <div class="d-flex align-items-center mb-4 topp">
                                    <div class="one">
                                        <span class="day">{{$day}}</span>
                                    </div>
                                    <div class="two">
                                        <span class="yr">{{$year}}</span>
                                        <span class="mos">{{$monthNameVietnamese}}</span>
                                    </div>
                                </div>
                                <h5 class="heading" style="font-size: 16px"><a
                                        href="{{\Illuminate\Support\Facades\URL::to('chi-tiet-bai-viet/'.$item->slug)}}">{{\Illuminate\Support\Str::limit($item->title,50)}}</a>
                                </h5>
                                <!-- <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p> -->
                                <p><a href="{{\Illuminate\Support\Facades\URL::to('chi-tiet-bai-viet/'.$item->slug)}}"
                                      class="btn btn-primary">Xem thêm</a></p>
                            </div>
                        </div>
                    </div>
                @endforeach
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
                        <p class="mb-0"><a href="{{\Illuminate\Support\Facades\URL::to('/lien-he')}}" class="btn btn-primary px-4 py-3">Liên hệ ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

