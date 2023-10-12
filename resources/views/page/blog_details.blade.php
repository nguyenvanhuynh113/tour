@extends('layout.app')
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('/images/bg_1.jpg');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{\Illuminate\Support\Facades\URL::to('/')}}">Trang chủ<i
                                    class="fa fa-chevron-right"></i></a></span> <span>Bài viết <i
                                class="fa fa-chevron-right"></i></span></p>
                    <h1 class="mb-0 bread">{{$blog->title}}</h1>
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
                    <h2 class="mb-3">{{$blog->title}}</h2>
                    <p>{!! $blog->content !!}</p>

                    @php $author_name=\Illuminate\Support\Facades\DB::table('users')->where('id','=',$blog->id_publisher)->first() @endphp
                    <div class="about-author d-flex p-4 bg-light">
                        <div class="bio mr-5">
                            <img src="/images/person_1.jpg" alt="Image placeholder" class="img-fluid mb-4">
                        </div>
                        <div class="desc">
                            <h3>{{$author_name->name}}</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus itaque, autem
                                necessitatibus voluptate quod mollitia delectus aut, sunt placeat nam vero culpa
                                sapiente consectetur similique, inventore eos fugit cupiditate numquam!</p>
                        </div>
                    </div>
                </div> <!-- .col-md-8 -->
                <div class="col-lg-4 sidebar ftco-animate bg-light py-md-5">
                    <div class="sidebar-box pt-md-5">
                        <form action="#" class="search-form">
                            <div class="form-group">
                                <span class="icon fa fa-search"></span>
                                <input type="text" class="form-control" placeholder="Tìm kiếm bài viết">
                            </div>
                        </form>
                    </div>
                    <div class="sidebar-box ftco-animate">
                        <div class="categories">
                            <h3>Danh mục bài viết</h3>
                            @foreach($category as $item)
                                @php $count=count($item->blogs)  @endphp
                                <li>
                                    <a href="{{\Illuminate\Support\Facades\URL::to('danh-muc-bai-viet/'.$item->slug)}}">{{$item->name}}
                                        <span>({{$count}})</span></a></li>
                            @endforeach
                        </div>
                    </div>

                    <div class="sidebar-box ftco-animate">
                        <h3>Bài viết mới cập nhật</h3>
                        @foreach($new_blog as $item)
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
                            <div class="block-21 mb-4 d-flex">
                                <a class="blog-img mr-4"
                                   style="background-image: url('http://127.0.0.1:8000/storage/{{$item->image}}');"></a>
                                <div class="text">
                                    <h3 class="heading"><a href="#">{{$item->title}}</a></h3>
                                    <div class="meta">
                                        <div><a href="#"><span
                                                    class="fa fa-calendar"></span> {{$day}} {{$monthNameVietnamese}}
                                                {{$year}}</a>
                                        </div>
                                        <div><a href="#"><span class="fa fa-user"></span> {{$item->user->name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
@endsection
