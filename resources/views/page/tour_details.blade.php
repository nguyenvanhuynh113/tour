@extends('layout.app')
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('/images/bg_1.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Trang chủ <i
                                    class="fa fa-chevron-right"></i></a></span> <span class="mr-2"><a
                                href="{{\Illuminate\Support\Facades\URL::to('/')}}">Tour <i
                                    class="fa fa-chevron-right"></i></a></span></p>
                    <h1 class="mb-0 bread">{{$tour->title}}</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row">
                <style>
                    .col-lg-8 img {
                        max-width: 100%; /* Hình ảnh không vượt quá chiều rộng của col-lg-8 */
                        height: auto; /* Đảm bảo tỷ lệ khung hình được bảo toàn */
                    }
                </style>
                <div class="col-lg-8 ftco-animate py-md-5 mt-md-5">
                    <h2 class="mb-3">{{$tour->title}}</h2>
                    <p>{!! $tour->information !!}</p>
                </div> <!-- .col-md-8 -->
                <div class="col-lg-4 sidebar ftco-animate bg-light py-md-5">
                    <div class="row shadow-sm">
                        <div class="sidebar-box pt-md-5">
                            <form action="#" class="search-form">
                                <div class="form-group">
                                    <span class="icon fa fa-search"></span>
                                    <input type="text" class="form-control" placeholder="Tìm kiếm chuyến đi">
                                </div>
                            </form>
                        </div>
                        <div class="sidebar-box ftco-animate">
                            <div class="categories">
                                <h3>Địa điểm</h3>
                                @foreach($place as $item)
                                    @php $count=count($item->tours)  @endphp
                                    <li>
                                        <a href="{{\Illuminate\Support\Facades\URL::to('dia-diem-du-lich/'.$item->slug)}}">{{$item->name}}
                                            <span>({{$count}})</span></a></li>
                                @endforeach
                            </div>
                        </div>
                        <div class="sidebar-box pt-md-12 ftco-animate justify-content-center text-center">
                            <button type="button" class="btn btn-primary px-4 py-3" data-toggle="modal"
                                    data-target="#bookingModal">
                                Đặt vé ngay
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- .section -->
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
    @php $departure_dates=$tour->departure_dates; @endphp
    {{--modal đặt vé tour du lịch--}}
    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Đặt vé</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="bookingForm" action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="tour_date">Ngày đi</label>
                            <div class="btn-group" role="group" aria-label="Ngày đi">
                                @foreach($departure_dates as $date)
                                    <button type="button" class="btn btn-outline-success mx-2"
                                            onclick="selectTourDate('{{ $date->departure_date }}')">
                                        {{ (new DateTime($date->departure_date))->format('d-m') }}
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" id="selected_tour_date" name="tour_date" required>
                        </div>

                        <script>
                            function selectTourDate(date) {
                                document.getElementById('selected_tour_date').value = date;
                            }
                        </script>
                        <div class="form-group">
                            <label for="name">Họ và tên:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="adults">Người lớn:</label>
                                <input type="number" class="form-control" id="adults" name="adults" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label for="children">Trẻ em:</label>
                                <input type="number" class="form-control" id="children" name="children" min="0"
                                       required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" form="bookingForm" class="btn btn-primary">Xác nhận đặt vé</button>
                </div>
            </div>
        </div>
    </div>

@endsection
