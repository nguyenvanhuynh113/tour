@extends('layout.app')
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_1.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{\Illuminate\Support\Facades\URL::to('/')}}">Trang chủ <i
                                    class="fa fa-chevron-right"></i></a></span> <span>Tour<i
                                class="fa fa-chevron-right"></i></span></p>
                    <h1 class="mb-0 bread">Chuyến đi</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-no-pb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-wrap-1 ftco-animate">
                        <form action="#" class="search-property-1" method="post">
                            @csrf
                            <div class="row no-gutters">
                                <div class="col-lg d-flex">
                                    <div class="form-group p-4 border-0">
                                        <label for="#">Địa điểm</label>
                                        <div class="form-field">
                                            <div class="icon"><span class="fa fa-search"></span></div>
                                            <input type="text" class="form-control" name="place"
                                                   placeholder="Tìm kiếm nơi bạn muốn đến">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg d-flex">
                                    <div class="form-group p-4">
                                        <label for="#">Ngày đi</label>
                                        <div class="form-field">
                                            <div class="icon"><span class="fa fa-calendar"></span></div>
                                            <input type="text" class="form-control checkin_date" name="check_in_date"
                                                   placeholder="Ngày đi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg d-flex">
                                    <div class="form-group p-4">
                                        <label for="#">Ngày về</label>
                                        <div class="form-field">
                                            <div class="icon"><span class="fa fa-calendar"></span></div>
                                            <input type="text" class="form-control checkout_date"
                                                   name="check_out_date"
                                                   placeholder="Ngày về">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg d-flex">
                                    <div class="form-group p-4">
                                        <label for="#">Giá</label>
                                        <div class="form-field">
                                            <div class="select-wrap">
                                                <div class="icon"><span class="fa fa-chevron-down"></span></div>
                                                <select name="tour_prices" id="" class="form-control">
                                                    <option value="">$5,000</option>
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
                                <div class="col-lg d-flex">
                                    <div class="form-group d-flex w-100 border-0">
                                        <div class="form-field w-100 align-items-center d-flex">
                                            <input type="submit" value="Tìm kiếm"
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
    </section>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                @foreach($tour as $item)
                    <div class="col-md-4 ftco-animate">
                        <div class="project-wrap">
                            <a href="{{\Illuminate\Support\Facades\URL::to('chi-tiet-chuyen-di/'.$item->slug)}}"
                               class="img"
                               style="background-image: url('http://127.0.0.1:8000/storage/{{$item->image}}');">
                                <span class="price">{{number_format($item->normal_prices,0,',','.')}} đ/người</span>
                            </a>
                            <div class="text p-4">
                                <span class="days">{{$item->total_date_tour}} ngày</span>
                                <h3><a href="{{\Illuminate\Support\Facades\URL::to('chi-tiet-chuyen-di/'.$item->slug)}}"
                                       style="font-size: 16px">{{$item->title}}</a></h3>
                                <p class="location"><span class="fa fa-map-marker"></span> {{$item->des_address}}
                                </p>
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
                            @if ($tour->onFirstPage())
                                <li class="disabled"><span>&laquo;</span></li>
                            @else
                                <li><a href="{{ $tour->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                            @endif

                            <!-- Hiển thị các trang -->
                            @for ($i = 1; $i <= $tour->lastPage(); $i++)
                                <li class="{{ ($tour->currentPage() == $i) ? 'active' : '' }}">
                        <span>
                            @if ($tour->currentPage() == $i)
                                {{ $i }}
                            @else
                                <a href="{{ $tour->url($i) }}">{{ $i }}</a>
                            @endif
                        </span>
                                </li>
                            @endfor

                            <!-- Nút Next -->
                            @if ($tour->hasMorePages())
                                <li><a href="{{ $tour->nextPageUrl() }}" rel="next">&raquo;</a></li>
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
