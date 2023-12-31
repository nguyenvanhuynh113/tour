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
    {{-- Tìm kiếm --}}
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
                                        {{-- Form tim kiem trang chu--}}
                                        <form action="{{route('tim-kiem')}}" class="search-property-1" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row no-gutters">
                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4 border-0">
                                                        <label for="#">Điểm đến <span
                                                                class="fa fa-map-marker"></span></label>
                                                        <div class="form-field">
                                                            <div class="select-wrap">
                                                                <select class="form-control" name="place">
                                                                    <option value="">Hãy chọn điểm đến</option>
                                                                    @php $place_name=\Illuminate\Support\Facades\DB::table('places')->orderByDesc('name')->get(); @endphp
                                                                    @foreach($place_name as $item)
                                                                        <option
                                                                            value="{{$item->name}}">{{ ucwords($item->name) }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4">
                                                        <label for="#">Ngày Khởi Hành <span
                                                                class="fa fa-calendar"></span></label>
                                                        <div class="form-field">
                                                            <input type="text" class="form-control checkin_date"
                                                                   name="check_in_date"
                                                                   placeholder="Ngày khởi hành">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4">
                                                        <label for="#">Giá thấp nhất <span
                                                                class="fa fa-money"></span></label>
                                                        <div class="form-field">
                                                            <div class="select-wrap">
                                                                <input type="number" class="form-control" name="min_prices"
                                                                       placeholder="Nhập giá tối thiểu">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md d-flex">
                                                    <div class="form-group p-4">
                                                        <label for="#">Giá tối đa <span
                                                                class="fa fa-money"></span></label>
                                                        <div class="form-field">
                                                            <div class="select-wrap">
                                                                <input type="number" class="form-control" name="max_prices"
                                                                       placeholder="Nhập giá tối đa">
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
        </div>
    </section>
    <section class="ftco-section">
        <div class="container">
            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                @if(count($tour)<1)
                    <div class="col-md-12">
                        <h5 class="text-center">Không có chuyến đi nào được tìm thấy</h5>
                    </div>
                @endif
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
                                <h6>
                                    <a href="{{\Illuminate\Support\Facades\URL::to('chi-tiet-chuyen-di/'.$item->slug)}}"
                                       style="font-size: 16px">{{\Illuminate\Support\Str::limit($item->title,50)}}</a>
                                </h6>
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
                        <p class="mb-0"><a href="{{\Illuminate\Support\Facades\URL::to('/lien-he')}}"
                                           class="btn btn-primary px-4 py-3">Liên hệ ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
