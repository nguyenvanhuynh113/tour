<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arizonia&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css">
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.timepicker.css')}}">
    <link rel="stylesheet" href="{{asset('css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand"
               href="{{\Illuminate\Support\Facades\URL::to('/')}}">TRAVEL<span>VinTour</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                    aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="{{\Illuminate\Support\Facades\URL::to('/')}}"
                                                   class="nav-link">Trang chủ</a></li>
                    <li class="nav-item"><a href="{{\Illuminate\Support\Facades\URL::to('chuyen-di')}}"
                                            class="nav-link">Tour</a></li>
                    <li class="nav-item"><a href="{{\Illuminate\Support\Facades\URL::to('bai-viet')}}"
                                            class="nav-link">Bài viết</a>
                    </li>
                    <li class="nav-item"><a href="{{\Illuminate\Support\Facades\URL::to('/lien-he')}}" class="nav-link">Liên
                            hệ</a></li>
                    <li class="nav-item"><a href="{{\Illuminate\Support\Facades\URL::to('tra-cuu')}}"
                                            class="nav-link">Tra cứu</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Đăng kí') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <!-- Nút mở modal -->
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                   data-bs-target="#paymentHistoryModal"><i class="fa fa-credit-card"></i>
                                    Thanh toán
                                </a>
                                <a class="dropdown-item" href="{{\Illuminate\Support\Facades\URL::to('/logout')}}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                        class="fa fa-sign-out"></i>
                                    {{ __('Đăng xuất') }}
                                </a>
                                <form id="logout-form" action="{{route('logout')}}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->
    <main>
        @guest
        @else
            @php
                $booking=\App\Models\Booking::all()->where('email','=',auth()->user()->email)->sortByDesc('created_at');
                 $total=0;
                 foreach ($booking as $item) {
                          $total=$total+$item->total_prices;
                     }
            @endphp
            <div class="modal fade" id="paymentHistoryModal" tabindex="-1"
                 aria-labelledby="paymentHistoryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title mx-3" id="paymentHistoryModalLabel" style="color: #e34807">Lịch sử
                                đặt vé</h6>
                            <span class="modal-title">SL đơn hàng : {{count($booking)}} đơn</span>
                            <h6 class="modal-title mx-3">Tổng ĐH: <strong>{{number_format($total,0,',','.')}} đ</strong>
                            </h6>
                            <a data-bs-dismiss="modal" class="mx-2" aria-label="Close"><i
                                    class="fa fa-close"></i></a>
                        </div>
                        <div class="modal-body">
                            @if(count($booking)>0)
                                <div class="row">
                                    @foreach($booking as $item)
                                        @php
                                            $tour=\Illuminate\Support\Facades\DB::table('tours')->where('id','=',$item->id_tour)->first()
                                        @endphp
                                        <div class="col-12 mb-3">
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <img src="http://127.0.0.1:8000/storage/{{$tour->image}}"
                                                             class="img-fluid rounded-start" alt="Product Image"
                                                             style="height: 120px;width:250px;object-fit: cover;border-radius: 0">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="card-body">
                                                            <h6 class="card-title"><a
                                                                    href="{{\Illuminate\Support\Facades\URL::to('chi-tiet-chuyen-di/'.$tour->slug)}}">{{$tour->title}}</a>
                                                            </h6>
                                                            <p class=" card-text">Mã HĐ:
                                                                <strong>{{$item->booking_number}}</strong>
                                                                <span
                                                                    class="mx-5"> Số lượng vé: <strong>{{$item->person}}</strong></span>
                                                                <span class="card-text">Thanh toán:
                                                                <strong> {{number_format($item->total_prices,0,',','.')}}
                                                                    đ</strong>
                                                            </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <!-- Dữ liệu từ bảng sản phẩm sẽ được hiển thị dưới dạng card -->
                                </div>
                            @else
                                <h5 class="modal-title mb-3">Không có thông tin</h5>
                            @endif

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                Đóng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endguest


        @yield('content')
    </main> <!-- Modal -->
    @include('layout.footer')
    @include('layout.script')
</div>
</body>
</html>
