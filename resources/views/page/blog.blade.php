@extends('layout.app')
@section('content')
    <section class="hero-wrap hero-wrap-2"
             style="background-image: url('/images/bg_1.jpg')">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{\Illuminate\Support\Facades\URL::to('/')}}">Trang chủ
                                <i class="fa fa-chevron-right"></i></a></span> <span>Bài viết<i
                                class="fa fa-chevron-right"></i></span></p>
                    <h1 class="mb-0 bread">Bài viết</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section">
        <div class="container">
            <div class="row d-flex">
                @foreach($blog as $item)
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="blog-entry justify-content-end">
                            <a href="#" class="block-20"
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
            {{-- phân trang--}}
            <div class="row mt-5">
                <div class="col text-center">
                    <div class="block-27">
                        <ul class="pagination">
                            <!-- Nút Previous -->
                            @if ($blog->onFirstPage())
                                <li class="disabled"><span>&laquo;</span></li>
                            @else
                                <li><a href="{{ $blog->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                            @endif

                            <!-- Hiển thị các trang -->
                            @for ($i = 1; $i <= $blog->lastPage(); $i++)
                                <li class="{{ ($blog->currentPage() == $i) ? 'active' : '' }}">
                        <span>
                            @if ($blog->currentPage() == $i)
                                {{ $i }}
                            @else
                                <a href="{{ $blog->url($i) }}">{{ $i }}</a>
                            @endif
                        </span>
                                </li>
                            @endfor

                            <!-- Nút Next -->
                            @if ($blog->hasMorePages())
                                <li><a href="{{ $blog->nextPageUrl() }}" rel="next">&raquo;</a></li>
                            @else
                                <li class="disabled"><span>&raquo;</span></li>
                            @endif
                        </ul>
                    </div>
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
                        <p class="mb-0"><a href="#" class="btn btn-primary px-4 py-3">Liên hệ ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
