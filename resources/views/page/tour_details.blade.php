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
                            <div class="sidebar-box pt-md-5">
                                <form action="#" class="search-form">
                                    <div class="form-group"><span class="icon fa fa-search"></span>
                                        <input type="text" class="form-control"
                                               placeholder="Nhập chuyến đi cần tìm kiếm"
                                               id="key">
                                    </div>
                                    <div id="result"></div>
                                </form>
                            </div>
                        </div>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function () {
                                $("#key").on("input", function () {
                                    var keyword = $(this).val();
                                    if (keyword.length >= 3) {
                                        $.ajax({
                                            type: "GET",
                                            url: "/goi-y-chuyen-di",
                                            data: {
                                                keyword: keyword
                                            },
                                            success: function (data) {
                                                // Xóa kết quả trước đó
                                                $("#result").empty();
                                                // Duyệt qua dữ liệu JSON và hiển thị hình ảnh và tiêu đề
                                                $.each(data, function (index, item) {
                                                    var resultItem = '<div class="resultItem row mt-2 shadow-sm">';
                                                    resultItem += '<div class="col-md-12"><a href="' + item.slug + '">' + item.title + '</a></div>';
                                                    resultItem += '</div>';
                                                    $("#result").append(resultItem);
                                                });
                                            }
                                        });
                                    } else {
                                        $("#result").empty();
                                    }
                                });
                            });
                        </script>
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
                            <button type="button" class="btn btn-primary mx-2 my-3 px-4 py-3" data-toggle="modal"
                                    data-target="#bookingModal">
                                Đặt vé ngay
                            </button>

                            <button type="button" class="btn btn-primary mx-2 my-3 px-4 py-3" data-toggle="modal"
                                    data-target="#depositModal">
                                Đăng ký giữ chỗ
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
                        <p class="mb-0"><a href="{{\Illuminate\Support\Facades\URL::to('lien-he')}}"
                                           class="btn btn-primary px-4 py-3">Liên hệ ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Lay lich trinh cua tour --}}
    @php $departure_dates=$tour->departure_dates; @endphp

    {{--modal đặt vé tour du lịch--}}
    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Đặt
                        vé {{\Illuminate\Support\Str::limit($tour->title,50)}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deposit_bookingForm" action="{{route('thanh-toan')}}" method="POST">
                        <input type="text" name="slug" hidden value="{{$tour->slug}}">
                        @csrf
                        @if(count($departure_dates)<1)
                            <div class="form-group">
                                <span> Tour chưa có lịch trình nào. Chúng tôi sẽ cập nhật lịch trình sớm nhất.</span>
                            </div>
                        @else
                            @guest
                                <style>
                                    label {
                                        color: #070707;
                                    }
                                </style>
                                <div class="form-group mx-3">
                                    <label for="selected_date">Chọn ngày khởi hành:</label>
                                    <div class="form-field">
                                        <div class="btn-group" role="group">
                                            @foreach($departure_dates as $date)
                                                @if($date->quantity>0)
                                                    <button type="button"
                                                            class="btn btn-primary mx-2 my-2 rounded-pill py-2 px-2"
                                                            onclick="selectDateDeposit('{{ $date->departure_date }}', {{ $date->quantity }},{{$date->prices}})">
                                                        {{ (new DateTime($date->departure_date))->format('d-m-Y') }}
                                                    </button>
                                                @else
                                                    <button type="button"
                                                            class="btn btn-primary mx-2 my-2 rounded-pill py-2 px-2"
                                                            disabled
                                                            onclick="selectDateDeposit('{{ $date->departure_date }}', {{ $date->quantity }},{{$date->prices}})">
                                                        {{ (new DateTime($date->departure_date))->format('d-m-Y') }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="check_in_date" id="deposit_selected_date" value="">
                                    </div>
                                    <div class="form-group mx-3 my-3">
                                        <label class="mb-2">Thông tin vé:</label>
                                        <div class="row shadow-sm container">
                                            <div class="col-md-4">
                                                <small>Ngày : <strong id="deposit_check_date"></strong></small>
                                            </div>
                                            <div class="col-md-4"><small>Còn :
                                                    <strong style="color: #e34807"
                                                            id="deposit_remaining_tickets"></strong></small></div>
                                            <div class="col-md-4"><small>Giá vé: <strong style="color: #e34807"
                                                                                         id="deposit_tour_prices"></strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function selectDateDeposit(date, quantity, prices) {
                                            const formattedPrice = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(prices);
                                            document.getElementById('deposit_check_date').style.color = '#e34807';
                                            document.getElementById('deposit_selected_date').value = date;
                                            document.getElementById('deposit_tour_prices').innerText = formattedPrice
                                            document.getElementById('deposit_remaining_tickets').innerText = quantity + ' vé';
                                            document.getElementById('deposit_check_date').innerHTML = date;
                                            document.getElementById('deposit_adults').setAttribute('max', quantity);
                                            document.getElementById('deposit_children').setAttribute('max', quantity);
                                            document.getElementById('deposit_kids').setAttribute('max', quantity);
                                            const adultsInput = parseInt(document.getElementById('deposit_adults').value, 10) || 0;
                                            const childrenInput = parseInt(document.getElementById('deposit_children').value, 10) || 0;
                                            const kidsInput = parseInt(document.getElementById('deposit_kids').value, 10) || 0;
                                            const coupon = parseInt(document.getElementById('deposit_coupon').value, 10) || 0;
                                            const totalQuantity = adultsInput + childrenInput + kidsInput;
                                            if (totalQuantity <= 0) {
                                                document.getElementById('deposit_quantity').style.color = 'red';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé không hợp lệ';
                                                document.getElementById('deposit_submitForm').setAttribute('disabled', 'true');
                                            } else if (totalQuantity > quantity) {
                                                document.getElementById('deposit_quantity').style.color = 'red';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé vượt quá số lượng còn lại';
                                                document.getElementById('deposit_submitForm').setAttribute('disabled', 'true');
                                            } else {
                                                document.getElementById('deposit_quantity').style.color = 'green';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé hợp lệ';
                                                document.getElementById('deposit_submitForm').removeAttribute('disabled');
                                            }
                                            const kid = (kidsInput * prices) * 0.25;
                                            const adults = adultsInput * prices;
                                            const child = (childrenInput * prices) * 0.75;
                                            const sub_total = kid + adults + child;
                                            const discount = sub_total * (coupon / 100);
                                            const total = (sub_total - discount);
                                            document.getElementById('deposit_kids_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(kid);
                                            document.getElementById('deposit_adults_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(adults);
                                            document.getElementById('deposit_children_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(child);
                                            document.getElementById('deposit_subtotal').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(sub_total);
                                            document.getElementById('deposit_coupon_value').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(discount);
                                            document.getElementById('deposit_total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(total);

                                            // Truyền giá trị quantity vào hàm checkQuantity
                                            document.getElementById('deposit_adults').addEventListener('input', function () {
                                                checkQuantityDeposit(quantity, prices);
                                            });
                                            document.getElementById('deposit_children').addEventListener('input', function () {
                                                checkQuantityDeposit(quantity, prices);
                                            });
                                            document.getElementById('deposit_kids').addEventListener('input', function () {
                                                checkQuantityDeposit(quantity, prices);
                                            });
                                        }

                                        function checkQuantityDeposit(quantity, prices) {
                                            const adultsInput = parseInt(document.getElementById('deposit_adults').value, 10) || 0;
                                            const childrenInput = parseInt(document.getElementById('deposit_children').value, 10) || 0;
                                            const kidsInput = parseInt(document.getElementById('deposit_kids').value, 10) || 0;
                                            const coupon = parseInt(document.getElementById('deposit_coupon').value, 10) || 0;
                                            const totalQuantity = adultsInput + childrenInput + kidsInput;
                                            if (totalQuantity <= 0) {
                                                document.getElementById('deposit_quantity').style.color = 'red';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé không hợp lệ';
                                                document.getElementById('deposit_submitForm').setAttribute('disabled', 'true');
                                            } else if (totalQuantity > quantity) {
                                                document.getElementById('deposit_quantity').style.color = 'red';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé vượt quá số lượng còn lại';
                                                document.getElementById('deposit_submitForm').setAttribute('disabled', 'true');
                                            } else {
                                                document.getElementById('deposit_quantity').style.color = 'green';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé hợp lệ';
                                                document.getElementById('deposit_submitForm').removeAttribute('disabled');
                                            }
                                            const kid = (kidsInput * prices) * 0.25;
                                            const adults = (adultsInput * prices);
                                            const child = (childrenInput * prices) * 0.75;
                                            const sub_total = kid + adults + child;
                                            const discount = sub_total * (coupon / 100);
                                            const total = (sub_total - discount);
                                            document.getElementById('deposit_kids_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(kid);
                                            document.getElementById('deposit_adults_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(adults);
                                            document.getElementById('deposit_children_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(child);
                                            document.getElementById('deposit_subtotal').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(sub_total);
                                            document.getElementById('deposit_coupon_value').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(discount);
                                            document.getElementById('deposit_total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(total);
                                        }
                                    </script>
                                </div>
                                <div class="form-group mx-3 my-3">
                                    <label>Thông tin khách hàng: </label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <small>Địa chỉ email</small>
                                            <input type="email" class="form-control" id="deposit_email" name="email"
                                                   placeholder="VD: nguyenvana@gmail.com" required>
                                        </div>
                                        <div class="col-md-6">
                                            <small>Tên khách hàng</small>
                                            <input type="text" class="form-control" id="deposit_name" name="name"
                                                   placeholder="VD:nguyễn văn a" required>
                                        </div>
                                        <div class="col-md-6">
                                            <small>Số điện thoại</small>
                                            <input type="tel" class="form-control" id="deposit_phone" name="phone"
                                                   required>
                                            <small id="deposit_phoneHelp" class="form-text">Nhập sđt
                                                theo
                                                định dạng: 0xxxxxxxxx.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-5 mx-3 shadow">
                                    @php
                                        $today = \Carbon\Carbon::now() ;// Lấy ngày hiện tại
                                        $coupon = $tour->coupons;
                                        $max_coupon = $coupon->filter(function ($item) use ($today) {
                                            return $item->coupon_end_date >= $today;
                                        })->sortByDesc('discount_value')->first();
                                    @endphp
                                    @if($max_coupon)
                                        <div class="col-md-10">
                                            <small> Đã áp dụng mã giảm
                                                giá: <strong
                                                    style="color: #069306"> {{$max_coupon->coupon_code}}</strong>
                                                Giảm {{$max_coupon->discount_value}}
                                                % cho mọi đơn hàng.</small>
                                            <input type="hidden" id="deposit_coupon" name="discount_value"
                                                   value="{{$max_coupon->discount_value}}">
                                        </div>
                                    @else
                                        <input type="hidden" id="deposit_coupon" name="discount_value"
                                               value="0">
                                    @endif
                                </div>
                                <div class="form-group mx-3 my-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Người lớn (>18
                                                tuổi): </small>
                                            <input type="number" class="form-control" id="deposit_adults" name="adults"
                                                   max="{{$tour->quantity}}"
                                                   min="1"
                                                   value="1" required>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Trẻ nhỏ (10-17 tuổi): </small>
                                            <input type="number" class="form-control" id="deposit_children"
                                                   name="children"
                                                   max="{{$tour->quantity}}"
                                                   min="0" value="0" required>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Trẻ em (0-9 tuổi): </small>
                                            <input type="number" class="form-control" id="deposit_kids" name="kids"
                                                   min="0"
                                                   max="{{$tour->quantity}}"
                                                   value="0" required>
                                        </div>
                                    </div>
                                    <small id="deposit_quantity"></small>
                                </div>
                                <div class="row justify-content-start align-content-lg-start">
                                    <div class="col-md-12 mx-5 my-3">
                                        <div class="row my-2"><small>Giá vé trẻ em (Giảm 25%) : <strong
                                                    id="deposit_children_prices"
                                                    class="mx-2"
                                                    style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-2"><small>Giá vé em bé (Giảm 75%) : <strong
                                                    id="deposit_kids_prices"
                                                    class="mx-2"
                                                    style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-2"><small>Giá vé người lớn : <strong
                                                    id="deposit_adults_prices"
                                                    class="mx-2"
                                                    style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-3 shadow-sm mr-5">
                                            <div class="col-md-6"><small>Tổng giá vé : <strong
                                                        id="deposit_subtotal" style="color: #e34807"></strong></small>
                                            </div>
                                            <div class="col-md-6"><small>Giảm giá: <strong
                                                        id="deposit_coupon_value"
                                                        style="color: #e34807"></strong></small></div>
                                        </div>
                                        <div class="row my-4">
                                            <div class="col-md-12">
                                                <h5>Tổng thanh toán : <strong
                                                        id="deposit_total"
                                                        class="mx-2"
                                                        style="color: #e34807"></strong></h5>
                                                <small>Thanh toán 100% giá trị đơn hàng qua ví điện tử VNPAY.</small>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @else
                                @php
                                    $user=\Illuminate\Support\Facades\Auth::user();
                                @endphp
                                <style>
                                    label {
                                        color: #070707;
                                    }
                                </style>
                                <div class="form-group mx-3">
                                    <label for="selected_date">Chọn ngày khởi hành:</label>
                                    <div class="form-field">
                                        <div class="btn-group" role="group">
                                            @foreach($departure_dates as $date)
                                                @if($date->quantity>0)
                                                    <button type="button"
                                                            class="btn btn-primary mx-2 my-2 rounded-pill py-2 px-2"
                                                            onclick="selectDateDeposit('{{ $date->departure_date }}', {{ $date->quantity }},{{$date->prices}})">
                                                        {{ (new DateTime($date->departure_date))->format('d-m-Y') }}
                                                    </button>
                                                @else
                                                    <button type="button"
                                                            class="btn btn-primary mx-2 my-2 rounded-pill py-2 px-2"
                                                            disabled
                                                            onclick="selectDateDeposit('{{ $date->departure_date }}', {{ $date->quantity }},{{$date->prices}})">
                                                        {{ (new DateTime($date->departure_date))->format('d-m-Y') }}
                                                    </button>
                                                @endif
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="check_in_date" id="deposit_selected_date" value="">
                                    </div>
                                    <div class="form-group mx-3 my-3">
                                        <label class="mb-2">Thông tin vé:</label>
                                        <div class="row shadow-sm container">
                                            <div class="col-md-4">
                                                <small>Ngày : <strong id="deposit_check_date"></strong></small>
                                            </div>
                                            <div class="col-md-4"><small>Còn :
                                                    <strong style="color: #e34807"
                                                            id="deposit_remaining_tickets"></strong></small></div>
                                            <div class="col-md-4"><small>Giá vé: <strong style="color: #e34807"
                                                                                         id="deposit_tour_prices"></strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function selectDateDeposit(date, quantity, prices) {
                                            const formattedPrice = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(prices);
                                            document.getElementById('deposit_check_date').style.color = '#e34807';
                                            document.getElementById('deposit_selected_date').value = date;
                                            document.getElementById('deposit_tour_prices').innerText = formattedPrice
                                            document.getElementById('deposit_remaining_tickets').innerText = quantity + ' vé';
                                            document.getElementById('deposit_check_date').innerHTML = date;
                                            document.getElementById('deposit_adults').setAttribute('max', quantity);
                                            document.getElementById('deposit_children').setAttribute('max', quantity);
                                            document.getElementById('deposit_kids').setAttribute('max', quantity);
                                            const adultsInput = parseInt(document.getElementById('deposit_adults').value, 10) || 0;
                                            const childrenInput = parseInt(document.getElementById('deposit_children').value, 10) || 0;
                                            const kidsInput = parseInt(document.getElementById('deposit_kids').value, 10) || 0;
                                            const coupon = parseInt(document.getElementById('deposit_coupon').value, 10) || 0;
                                            const totalQuantity = adultsInput + childrenInput + kidsInput;
                                            if (totalQuantity <= 0) {
                                                document.getElementById('deposit_quantity').style.color = 'red';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé không hợp lệ';
                                                document.getElementById('deposit_submitForm').setAttribute('disabled', 'true');
                                            } else if (totalQuantity > quantity) {
                                                document.getElementById('deposit_quantity').style.color = 'red';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé vượt quá số lượng còn lại';
                                                document.getElementById('deposit_submitForm').setAttribute('disabled', 'true');
                                            } else {
                                                document.getElementById('deposit_quantity').style.color = 'green';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé hợp lệ';
                                                document.getElementById('deposit_submitForm').removeAttribute('disabled');
                                            }
                                            const kid = (kidsInput * prices) * 0.25;
                                            const adults = adultsInput * prices;
                                            const child = (childrenInput * prices) * 0.75;
                                            const sub_total = kid + adults + child;
                                            const discount = sub_total * (coupon / 100);
                                            const total = (sub_total - discount);
                                            document.getElementById('deposit_kids_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(kid);
                                            document.getElementById('deposit_adults_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(adults);
                                            document.getElementById('deposit_children_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(child);
                                            document.getElementById('deposit_subtotal').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(sub_total);
                                            document.getElementById('deposit_coupon_value').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(discount);
                                            document.getElementById('deposit_total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(total);

                                            // Truyền giá trị quantity vào hàm checkQuantity
                                            document.getElementById('deposit_adults').addEventListener('input', function () {
                                                checkQuantityDeposit(quantity, prices);
                                            });
                                            document.getElementById('deposit_children').addEventListener('input', function () {
                                                checkQuantityDeposit(quantity, prices);
                                            });
                                            document.getElementById('deposit_kids').addEventListener('input', function () {
                                                checkQuantityDeposit(quantity, prices);
                                            });
                                        }

                                        function checkQuantityDeposit(quantity, prices) {
                                            const adultsInput = parseInt(document.getElementById('deposit_adults').value, 10) || 0;
                                            const childrenInput = parseInt(document.getElementById('deposit_children').value, 10) || 0;
                                            const kidsInput = parseInt(document.getElementById('deposit_kids').value, 10) || 0;
                                            const coupon = parseInt(document.getElementById('deposit_coupon').value, 10) || 0;
                                            const totalQuantity = adultsInput + childrenInput + kidsInput;
                                            if (totalQuantity <= 0) {
                                                document.getElementById('deposit_quantity').style.color = 'red';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé không hợp lệ';
                                                document.getElementById('deposit_submitForm').setAttribute('disabled', 'true');
                                            } else if (totalQuantity > quantity) {
                                                document.getElementById('deposit_quantity').style.color = 'red';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé vượt quá số lượng còn lại';
                                                document.getElementById('deposit_submitForm').setAttribute('disabled', 'true');
                                            } else {
                                                document.getElementById('deposit_quantity').style.color = 'green';
                                                document.getElementById('deposit_quantity').innerText = 'Số lượng vé hợp lệ';
                                                document.getElementById('deposit_submitForm').removeAttribute('disabled');
                                            }
                                            const kid = (kidsInput * prices) * 0.25;
                                            const adults = (adultsInput * prices);
                                            const child = (childrenInput * prices) * 0.75;
                                            const sub_total = kid + adults + child;
                                            const discount = sub_total * (coupon / 100);
                                            const total = (sub_total - discount);
                                            document.getElementById('deposit_kids_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(kid);
                                            document.getElementById('deposit_adults_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(adults);
                                            document.getElementById('deposit_children_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(child);
                                            document.getElementById('deposit_subtotal').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(sub_total);
                                            document.getElementById('deposit_coupon_value').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(discount);
                                            document.getElementById('deposit_total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(total);
                                        }
                                    </script>
                                </div>
                                <div class="form-group mx-3 my-3">
                                    <label>Thông tin khách hàng: </label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <small>Địa chỉ email</small>
                                            <input type="email" class="form-control" id="deposit_email" name="email"
                                                   value="{{$user->email}}"
                                                   placeholder="VD: nguyenvana@gmail.com" required>
                                        </div>
                                        <div class="col-md-6">
                                            <small>Tên khách hàng</small>
                                            <input type="text" class="form-control" id="deposit_name" name="name"
                                                   value="{{$user->name}}"
                                                   placeholder="VD:nguyễn văn a" required>
                                        </div>
                                        <div class="col-md-6">
                                            <small>Số điện thoại</small>
                                            <input type="tel" class="form-control" id="deposit_phone" name="phone"
                                                   required>
                                            <small id="deposit_phoneHelp" class="form-text">Nhập sđt
                                                theo
                                                định dạng: 0xxxxxxxxx.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-5 mx-3 shadow">
                                    @php
                                        $today = \Carbon\Carbon::now() ;// Lấy ngày hiện tại
                                        $coupon = $tour->coupons;
                                        $max_coupon = $coupon->filter(function ($item) use ($today) {
                                            return $item->coupon_end_date >= $today;
                                        })->sortByDesc('discount_value')->first();
                                    @endphp
                                    @if($max_coupon)
                                        <div class="col-md-10">
                                            <small> Đã áp dụng mã giảm
                                                giá: <strong
                                                    style="color: #069306"> {{$max_coupon->coupon_code}}</strong>
                                                Giảm {{$max_coupon->discount_value}}
                                                % cho mọi đơn hàng.</small>
                                            <input type="hidden" id="deposit_coupon" name="discount_value"
                                                   value="{{$max_coupon->discount_value}}">
                                        </div>
                                    @else
                                        <input type="hidden" id="deposit_coupon" name="discount_value"
                                               value="0">
                                    @endif
                                </div>
                                <div class="form-group mx-3 my-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Người lớn (>18
                                                tuổi): </small>
                                            <input type="number" class="form-control" id="deposit_adults" name="adults"
                                                   max="{{$tour->quantity}}"
                                                   min="1"
                                                   value="1" required>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Trẻ nhỏ (10-17 tuổi): </small>
                                            <input type="number" class="form-control" id="deposit_children"
                                                   name="children"
                                                   max="{{$tour->quantity}}"
                                                   min="0" value="0" required>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Trẻ em (0-9 tuổi): </small>
                                            <input type="number" class="form-control" id="deposit_kids" name="kids"
                                                   min="0"
                                                   max="{{$tour->quantity}}"
                                                   value="0" required>
                                        </div>
                                    </div>
                                    <small id="deposit_quantity"></small>
                                </div>
                                <div class="row justify-content-start align-content-lg-start">
                                    <div class="col-md-12 mx-5 my-3">
                                        <div class="row my-2"><small>Giá vé trẻ em (Giảm 25%) : <strong
                                                    id="deposit_children_prices"
                                                    class="mx-2"
                                                    style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-2"><small>Giá vé em bé (Giảm 75%) : <strong
                                                    id="deposit_kids_prices"
                                                    class="mx-2"
                                                    style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-2"><small>Giá vé người lớn : <strong
                                                    id="deposit_adults_prices"
                                                    class="mx-2"
                                                    style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-3 shadow-sm mr-5">
                                            <div class="col-md-6"><small>Tổng giá vé : <strong
                                                        id="deposit_subtotal" style="color: #e34807"></strong></small>
                                            </div>
                                            <div class="col-md-6"><small>Giảm giá: <strong
                                                        id="deposit_coupon_value"
                                                        style="color: #e34807"></strong></small></div>
                                        </div>
                                        <div class="row my-4">
                                            <div class="col-md-12">
                                                <h5>Tổng thanh toán : <strong
                                                        id="deposit_total"
                                                        class="mx-2"
                                                        style="color: #e34807"></strong></h5>
                                                <small>Thanh toán 100% giá trị đơn hàng qua ví điện tử VNPAY.</small>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endguest
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy thanh toán</button>
                    @if(count($departure_dates)>0)
                        <button type="submit" form="deposit_bookingForm" id="deposit_submitForm" class="btn btn-primary"
                                disabled>Xác
                            nhận thanh toán
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- modal đăng ký giữ chỗ--}}
    <div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel"> Đăng ký giữ
                        chỗ {{\Illuminate\Support\Str::limit($tour->title,30)}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="bookingForm" action="{{route('dang-ki-giu-cho')}}" method="POST">
                        <input type="text" name="slug" hidden value="{{$tour->slug}}">
                        @csrf
                        @if(count($departure_dates)<1)
                            <div class="form-group">
                                <span> Tour chưa có lịch trình nào. Chúng tôi sẽ cập nhật lịch trình sớm nhất.</span>
                            </div>
                        @else
                            @guest
                                <div class="form-group mx-3">
                                    <label for="selected_date">Chọn ngày khởi hành:</label>
                                    <div class="form-field">
                                        <div class="btn-group" role="group">
                                            @foreach($departure_dates as $date)
                                                @if($date->quantity>0)
                                                    <small>
                                                        <button type="button"
                                                                class="btn btn-primary mx-2 my-2 rounded-pill py-2 px-2"
                                                                onclick="selectDate('{{ $date->departure_date }}', {{ $date->quantity }},{{$date->prices}})">
                                                            {{ (new DateTime($date->departure_date))->format('d-m-Y') }}
                                                        </button>
                                                    </small>

                                                @else
                                                    <small>
                                                        <button type="button"
                                                                class="btn btn-primary mx-2 my-2 rounded-pill py-2 px-2"
                                                                disabled
                                                                onclick="selectDate('{{ $date->departure_date }}', {{ $date->quantity }},{{$date->prices}})">
                                                            {{ (new DateTime($date->departure_date))->format('d-m-Y') }}
                                                        </button>
                                                    </small>

                                                @endif
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="check_in_date" id="selected_date" value="">
                                    </div>
                                    <div class="form-group mx-3 my-3">
                                        <label class="mb-2">Thông tin vé:</label>
                                        <div class="row shadow-sm container">
                                            <div class="col-md-4">
                                                <small>Ngày : <strong id="check_date"></strong></small>
                                            </div>
                                            <div class="col-md-4"><small>Còn :
                                                    <strong style="color: #e34807"
                                                            id="remaining_tickets"></strong></small></div>
                                            <div class="col-md-4"><small>Giá vé: <strong style="color: #e34807"
                                                                                         id="tour_prices"></strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function selectDate(date, quantity, prices) {
                                            const formattedPrice = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(prices);
                                            document.getElementById('check_date').style.color = '#e34807';
                                            document.getElementById('selected_date').value = date;
                                            document.getElementById('tour_prices').innerText = formattedPrice
                                            document.getElementById('remaining_tickets').innerText = quantity + ' vé';
                                            document.getElementById('check_date').innerHTML = date;
                                            document.getElementById('adults').setAttribute('max', quantity);
                                            document.getElementById('children').setAttribute('max', quantity);
                                            document.getElementById('kids').setAttribute('max', quantity);
                                            var adultsInput = parseInt(document.getElementById('adults').value, 10) || 0;
                                            var childrenInput = parseInt(document.getElementById('children').value, 10) || 0;
                                            var kidsInput = parseInt(document.getElementById('kids').value, 10) || 0;
                                            var coupon = parseInt(document.getElementById('coupon').value, 10) || 0;
                                            var totalQuantity = adultsInput + childrenInput + kidsInput;
                                            if (totalQuantity <= 0) {
                                                document.getElementById('quantity').style.color = 'red';
                                                document.getElementById('quantity').innerText = 'Số lượng vé không hợp lệ';
                                                document.getElementById('submitForm').setAttribute('disabled', 'true');
                                            } else if (totalQuantity > quantity) {
                                                document.getElementById('quantity').style.color = 'red';
                                                document.getElementById('quantity').innerText = 'Số lượng vé vượt quá số lượng còn lại';
                                                document.getElementById('submitForm').setAttribute('disabled', 'true');
                                            } else {
                                                document.getElementById('quantity').style.color = 'green';
                                                document.getElementById('quantity').innerText = 'Số lượng vé hợp lệ';
                                                document.getElementById('submitForm').removeAttribute('disabled');
                                            }
                                            const kid = (kidsInput * prices) * 0.25;
                                            const adults = adultsInput * prices;
                                            const child = (childrenInput * prices) * 0.75;
                                            const sub_total = kid + adults + child;
                                            const discount = sub_total * (coupon / 100);
                                            const total = (sub_total - discount) * 0.2;
                                            const order_total = (sub_total - discount);
                                            document.getElementById('kids_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(kid);
                                            document.getElementById('adults_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(adults);
                                            document.getElementById('childrens_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(child);
                                            document.getElementById('subtotal').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(sub_total);
                                            document.getElementById('coupon_value').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(discount);
                                            document.getElementById('total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(total);
                                            document.getElementById('order_total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(order_total);
                                            // Truyền giá trị quantity vào hàm checkQuantity
                                            document.getElementById('adults').addEventListener('input', function () {
                                                checkQuantity(quantity, prices);
                                            });
                                            document.getElementById('children').addEventListener('input', function () {
                                                checkQuantity(quantity, prices);
                                            });
                                            document.getElementById('kids').addEventListener('input', function () {
                                                checkQuantity(quantity, prices);
                                            });
                                        }

                                        function checkQuantity(quantity, prices) {
                                            var adultsInput = parseInt(document.getElementById('adults').value, 10) || 0;
                                            var childrenInput = parseInt(document.getElementById('children').value, 10) || 0;
                                            var kidsInput = parseInt(document.getElementById('kids').value, 10) || 0;
                                            var coupon = parseInt(document.getElementById('coupon').value, 10) || 0;
                                            var totalQuantity = adultsInput + childrenInput + kidsInput;
                                            if (totalQuantity <= 0) {
                                                document.getElementById('quantity').style.color = 'red';
                                                document.getElementById('quantity').innerText = 'Số lượng vé không hợp lệ';
                                                document.getElementById('submitForm').setAttribute('disabled', 'true');
                                            } else if (totalQuantity > quantity) {
                                                document.getElementById('quantity').style.color = 'red';
                                                document.getElementById('quantity').innerText = 'Số lượng vé vượt quá số lượng còn lại';
                                                document.getElementById('submitForm').setAttribute('disabled', 'true');
                                            } else {
                                                document.getElementById('quantity').style.color = 'green';
                                                document.getElementById('quantity').innerText = 'Số lượng vé hợp lệ';
                                                document.getElementById('submitForm').removeAttribute('disabled');
                                            }
                                            const kid = (kidsInput * prices) * 0.25;
                                            const adults = adultsInput * prices;
                                            const child = (childrenInput * prices) * 0.75;
                                            const sub_total = kid + adults + child;
                                            const discount = sub_total * (coupon / 100);
                                            const total = (sub_total - discount) * 0.2;
                                            const order_total = (sub_total - discount);
                                            document.getElementById('kids_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(kid);
                                            document.getElementById('adults_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(adults);
                                            document.getElementById('childrens_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(child);
                                            document.getElementById('subtotal').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(sub_total);
                                            document.getElementById('coupon_value').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(discount);
                                            document.getElementById('total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(total);
                                            document.getElementById('order_total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(order_total);
                                        }
                                    </script>
                                </div>
                                <div class="form-group mx-3 my-3">
                                    <label>Thông tin khách hàng: </label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <small>Địa chỉ email</small>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   value=""
                                                   placeholder="VD: nguyenvana@gmail.com" required>
                                        </div>
                                        <div class="col-md-6">
                                            <small>Tên khách hàng</small>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value=""
                                                   placeholder="VD: nguyễn văn a" required>
                                        </div>
                                        <div class="col-md-6">
                                            <small>Số điện thoại</small>
                                            <input type="tel" class="form-control" id="phone" name="phone" required>
                                            <small id="phoneHelp" class="form-text">Nhập sđt theo định dạng :
                                                0xxxxxxxxx.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-4 mx-3 shadow">
                                    @php
                                        $today = \Carbon\Carbon::now() ;// Lấy ngày hiện tại
                                        $coupon = $tour->coupons;
                                        $max_coupon = $coupon->filter(function ($item) use ($today) {
                                            return $item->coupon_end_date >= $today;
                                        })->sortByDesc('discount_value')->first();
                                    @endphp
                                    @if($max_coupon)
                                        <div class="col-md-10">
                                            <small> Đã áp dụng mã giảm
                                                giá: <strong
                                                    style="color: #069306"> {{$max_coupon->coupon_code}}</strong>
                                                Giảm {{$max_coupon->discount_value}}
                                                % cho mọi đơn hàng.</small>
                                            <input type="hidden" id="coupon" name="discount_value"
                                                   value="{{$max_coupon->discount_value}}">
                                        </div>
                                    @else
                                        <input type="hidden" id="coupon" name="discount_value"
                                               value="0">
                                    @endif
                                </div>
                                <div class="form-group mx-3 my-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Người lớn (>18
                                                tuổi): </small>
                                            <input type="number" class="form-control" id="adults" name="adults"
                                                   max="{{$tour->quantity}}"
                                                   min="1"
                                                   value="1" required>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Trẻ nhỏ (10-17 tuổi): </small>
                                            <input type="number" class="form-control" id="children" name="children"
                                                   max="{{$tour->quantity}}"
                                                   min="0" value="0" required>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Trẻ em (0-9 tuổi): </small>
                                            <input type="number" class="form-control" id="kids" name="kids" min="0"
                                                   max="{{$tour->quantity}}"
                                                   value="0" required>
                                        </div>
                                    </div>
                                    <small id="quantity"></small>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mx-5 my-3">
                                        <div class="row my-2"><small>Giá vé trẻ em (Giảm 25%) : <strong
                                                    id="childrens_prices"
                                                    class="mx-2"
                                                    style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-2"><small>Giá vé em bé (Giảm 75%) : <strong id="kids_prices"
                                                                                                       class="mx-2"
                                                                                                       style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-2"><small>Giá vé người lớn : <strong id="adults_prices"
                                                                                                class="mx-2"
                                                                                                style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-3 mr-5 shadow-sm">
                                            <div class="col-md-4"><small>Tổng giá vé : <strong
                                                        id="subtotal" style="color: #e34807"></strong></small></div>
                                            <div class="col-md-4"><small>Giảm giá: <strong
                                                        id="coupon_value" style="color: #e34807"></strong></small></div>
                                            <div class="col-md-4"><small>Tổng hóa đơn: <strong
                                                        id="order_total" style="color: #e34807"></strong></small></div>
                                        </div>
                                        <div class="row my-5">
                                            <div class="col-md-10">
                                                <h5>Tổng thanh toán:<strong id="total"
                                                                            class="mx-2"
                                                                            style="color: #e34807"></strong><small> (Phí
                                                        đặt cọc)</small></h5>
                                                <small>Thanh toán 20% tổng giá trị
                                                    hóa đơn qua ví điện tử VNPAY.</small>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @else
                                @php
                                    $user=\Illuminate\Support\Facades\Auth::user();
                                @endphp
                                <style>
                                    label {
                                        color: #070707;
                                    }
                                </style>
                                <div class="form-group mx-3">
                                    <label for="selected_date">Chọn ngày khởi hành:</label>
                                    <div class="form-field">
                                        <div class="btn-group" role="group">
                                            @foreach($departure_dates as $date)
                                                @if($date->quantity>0)
                                                    <small>
                                                        <button type="button"
                                                                class="btn btn-primary mx-2 my-2 rounded-pill py-2 px-2"
                                                                onclick="selectDate('{{ $date->departure_date }}', {{ $date->quantity }},{{$date->prices}})">
                                                            {{ (new DateTime($date->departure_date))->format('d-m-Y') }}
                                                        </button>
                                                    </small>

                                                @else
                                                    <small>
                                                        <button type="button"
                                                                class="btn btn-primary mx-2 my-2 rounded-pill py-2 px-2"
                                                                disabled
                                                                onclick="selectDate('{{ $date->departure_date }}', {{ $date->quantity }},{{$date->prices}})">
                                                            {{ (new DateTime($date->departure_date))->format('d-m-Y') }}
                                                        </button>
                                                    </small>

                                                @endif
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="check_in_date" id="selected_date" value="">
                                    </div>
                                    <div class="form-group mx-3 my-3">
                                        <label class="mb-2">Thông tin vé:</label>
                                        <div class="row shadow-sm container">
                                            <div class="col-md-4">
                                                <small>Ngày : <strong id="check_date"></strong></small>
                                            </div>
                                            <div class="col-md-4"><small>Còn :
                                                    <strong style="color: #e34807"
                                                            id="remaining_tickets"></strong></small></div>
                                            <div class="col-md-4"><small>Giá vé: <strong style="color: #e34807"
                                                                                         id="tour_prices"></strong></small>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        function selectDate(date, quantity, prices) {
                                            const formattedPrice = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(prices);
                                            document.getElementById('check_date').style.color = '#e34807';
                                            document.getElementById('selected_date').value = date;
                                            document.getElementById('tour_prices').innerText = formattedPrice
                                            document.getElementById('remaining_tickets').innerText = quantity + ' vé';
                                            document.getElementById('check_date').innerHTML = date;
                                            document.getElementById('adults').setAttribute('max', quantity);
                                            document.getElementById('children').setAttribute('max', quantity);
                                            document.getElementById('kids').setAttribute('max', quantity);
                                            var adultsInput = parseInt(document.getElementById('adults').value, 10) || 0;
                                            var childrenInput = parseInt(document.getElementById('children').value, 10) || 0;
                                            var kidsInput = parseInt(document.getElementById('kids').value, 10) || 0;
                                            var coupon = parseInt(document.getElementById('coupon').value, 10) || 0;
                                            var totalQuantity = adultsInput + childrenInput + kidsInput;
                                            if (totalQuantity <= 0) {
                                                document.getElementById('quantity').style.color = 'red';
                                                document.getElementById('quantity').innerText = 'Số lượng vé không hợp lệ';
                                                document.getElementById('submitForm').setAttribute('disabled', 'true');
                                            } else if (totalQuantity > quantity) {
                                                document.getElementById('quantity').style.color = 'red';
                                                document.getElementById('quantity').innerText = 'Số lượng vé vượt quá số lượng còn lại';
                                                document.getElementById('submitForm').setAttribute('disabled', 'true');
                                            } else {
                                                document.getElementById('quantity').style.color = 'green';
                                                document.getElementById('quantity').innerText = 'Số lượng vé hợp lệ';
                                                document.getElementById('submitForm').removeAttribute('disabled');
                                            }
                                            const kid = (kidsInput * prices) * 0.25;
                                            const adults = adultsInput * prices;
                                            const child = (childrenInput * prices) * 0.75;
                                            const sub_total = kid + adults + child;
                                            const discount = sub_total * (coupon / 100);
                                            const total = (sub_total - discount) * 0.2;
                                            const order_total = (sub_total - discount);
                                            document.getElementById('kids_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(kid);
                                            document.getElementById('adults_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(adults);
                                            document.getElementById('childrens_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(child);
                                            document.getElementById('subtotal').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(sub_total);
                                            document.getElementById('coupon_value').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(discount);
                                            document.getElementById('total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(total);
                                            document.getElementById('order_total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(order_total);
                                            // Truyền giá trị quantity vào hàm checkQuantity
                                            document.getElementById('adults').addEventListener('input', function () {
                                                checkQuantity(quantity, prices);
                                            });
                                            document.getElementById('children').addEventListener('input', function () {
                                                checkQuantity(quantity, prices);
                                            });
                                            document.getElementById('kids').addEventListener('input', function () {
                                                checkQuantity(quantity, prices);
                                            });
                                        }

                                        function checkQuantity(quantity, prices) {
                                            var adultsInput = parseInt(document.getElementById('adults').value, 10) || 0;
                                            var childrenInput = parseInt(document.getElementById('children').value, 10) || 0;
                                            var kidsInput = parseInt(document.getElementById('kids').value, 10) || 0;
                                            var coupon = parseInt(document.getElementById('coupon').value, 10) || 0;
                                            var totalQuantity = adultsInput + childrenInput + kidsInput;
                                            if (totalQuantity <= 0) {
                                                document.getElementById('quantity').style.color = 'red';
                                                document.getElementById('quantity').innerText = 'Số lượng vé không hợp lệ';
                                                document.getElementById('submitForm').setAttribute('disabled', 'true');
                                            } else if (totalQuantity > quantity) {
                                                document.getElementById('quantity').style.color = 'red';
                                                document.getElementById('quantity').innerText = 'Số lượng vé vượt quá số lượng còn lại';
                                                document.getElementById('submitForm').setAttribute('disabled', 'true');
                                            } else {
                                                document.getElementById('quantity').style.color = 'green';
                                                document.getElementById('quantity').innerText = 'Số lượng vé hợp lệ';
                                                document.getElementById('submitForm').removeAttribute('disabled');
                                            }
                                            const kid = (kidsInput * prices) * 0.25;
                                            const adults = adultsInput * prices;
                                            const child = (childrenInput * prices) * 0.75;
                                            const sub_total = kid + adults + child;
                                            const discount = sub_total * (coupon / 100);
                                            const total = (sub_total - discount) * 0.2;
                                            const order_total = (sub_total - discount);
                                            document.getElementById('kids_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(kid);
                                            document.getElementById('adults_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(adults);
                                            document.getElementById('childrens_prices').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(child);
                                            document.getElementById('subtotal').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(sub_total);
                                            document.getElementById('coupon_value').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(discount);
                                            document.getElementById('total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(total);
                                            document.getElementById('order_total').innerText = new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(order_total);
                                        }
                                    </script>
                                </div>
                                <div class="form-group mx-3 my-3">
                                    <label>Thông tin khách hàng: </label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <small>Địa chỉ email</small>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   value="{{$user->email}}"
                                                   placeholder="VD: nguyenvana@gmail.com" required>
                                        </div>
                                        <div class="col-md-6">
                                            <small>Tên khách hàng</small>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   value="{{$user->name}}"
                                                   placeholder="VD: NGUYỄN VĂN A" required>
                                        </div>
                                        <div class="col-md-6">
                                            <small>Số điện thoại</small>
                                            <input type="tel" class="form-control" id="phone" name="phone" required>
                                            <small id="phoneHelp" class="form-text">Nhập sđt theo
                                                định dạng: 0xxxxxxxxx.</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-4 mx-3 shadow">
                                    @php
                                        $today = \Carbon\Carbon::now() ;// Lấy ngày hiện tại
                                        $coupon = $tour->coupons;
                                        $max_coupon = $coupon->filter(function ($item) use ($today) {
                                            return $item->coupon_end_date >= $today;
                                        })->sortByDesc('discount_value')->first();
                                    @endphp
                                    @if($max_coupon)
                                        <div class="col-md-10">
                                            <small> Đã áp dụng mã giảm
                                                giá: <strong
                                                    style="color: #069306"> {{$max_coupon->coupon_code}}</strong>
                                                Giảm {{$max_coupon->discount_value}}
                                                % cho mọi đơn hàng.</small>
                                            <input type="hidden" id="coupon" name="discount_value"
                                                   value="{{$max_coupon->discount_value}}">
                                        </div>
                                    @else
                                        <input type="hidden" id="coupon" name="discount_value"
                                               value="0">
                                    @endif
                                </div>
                                <div class="form-group mx-3 my-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Người lớn (>18
                                                tuổi): </small>
                                            <input type="number" class="form-control" id="adults" name="adults"
                                                   max="{{$tour->quantity}}"
                                                   min="1"
                                                   value="1" required>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Trẻ nhỏ (10-17 tuổi): </small>
                                            <input type="number" class="form-control" id="children" name="children"
                                                   max="{{$tour->quantity}}"
                                                   min="0" value="0" required>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="col-form-label text-center">Trẻ em (0-9 tuổi): </small>
                                            <input type="number" class="form-control" id="kids" name="kids" min="0"
                                                   max="{{$tour->quantity}}"
                                                   value="0" required>
                                        </div>
                                    </div>
                                    <small id="quantity"></small>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mx-5 my-3">
                                        <div class="row my-2"><small>Giá vé trẻ em (Giảm 25%) : <strong
                                                    id="childrens_prices"
                                                    class="mx-2"
                                                    style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-2"><small>Giá vé em bé (Giảm 75%) : <strong id="kids_prices"
                                                                                                       class="mx-2"
                                                                                                       style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-2"><small>Giá vé người lớn : <strong id="adults_prices"
                                                                                                class="mx-2"
                                                                                                style="color: #e34807"></strong></small>
                                        </div>
                                        <div class="row my-3 mr-5 shadow-sm">
                                            <div class="col-md-4"><small>Tổng giá vé : <strong
                                                        id="subtotal" style="color: #e34807"></strong></small></div>
                                            <div class="col-md-4"><small>Giảm giá: <strong
                                                        id="coupon_value" style="color: #e34807"></strong></small></div>
                                            <div class="col-md-4"><small>Tổng hóa đơn: <strong
                                                        id="order_total" style="color: #e34807"></strong></small></div>
                                        </div>
                                        <div class="row my-5">
                                            <div class="col-md-10">
                                                <h5>Tổng thanh toán:<strong id="total"
                                                                            class="mx-2"
                                                                            style="color: #e34807"></strong><small> (Phí
                                                        đặt cọc)</small></h5>
                                                <small>Thanh toán 20% tổng giá trị
                                                    hóa đơn qua ví điện tử VNPAY.</small>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            @endguest
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy thanh toán</button>
                    @if(count($departure_dates)>0)
                        <button type="submit" form="bookingForm" id="submitForm" class="btn btn-primary" disabled>Xác
                            nhận thanh toán
                        </button>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <script>
        document.getElementById('phone').addEventListener('input', function () {
            var phoneInput = this.value;
            // Loại bỏ các ký tự không phải số từ chuỗi
            var phoneNumber = phoneInput.replace(/\D/g, '');
            // Kiểm tra độ dài số điện thoại và định dạng
            var phonePattern = /^((\+84)|0)[3|5|7|8|9]\d{8}$/; // Định dạng số điện thoại +84xxxxxxxxx hoặc 0xxxxxxxxx
            // Kiểm tra định dạng số điện thoại
            var isPhoneNumberValid = phonePattern.test(phoneNumber);
            // Hiển thị thông báo lỗi nếu số điện thoại không hợp lệ
            var phoneHelp = document.getElementById('phoneHelp');
            var check_date = document.getElementById('check_date');
            var submitButton = document.getElementById('submitForm');
            var date = document.getElementById('selected_date').value;
            if (isPhoneNumberValid && date !== '') {
                // Số điện thoại và ngày hợp lệ
                submitButton.removeAttribute('disabled');
                phoneHelp.style.color = 'green';
                phoneHelp.innerHTML = 'Số điện thoại hợp lệ.';
                check_date.style.color = '#e34807';
                check_date.innerHTML = date;
            } else if (!isPhoneNumberValid) {
                // Số điện thoại không hợp lệ
                phoneHelp.style.color = 'red';
                phoneHelp.innerHTML = 'Vui lòng nhập số điện thoại hợp lệ.';
                submitButton.setAttribute('disabled', 'true');
            } else {
                // Ngày chưa được chọn
                check_date.style.color = 'red';
                check_date.innerHTML = 'Chọn ngày';
                submitButton.setAttribute('disabled', 'true');
            }
        });
    </script>
@endsection
