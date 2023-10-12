<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Place;
use App\Models\Tour;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    //trang chủ
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        //Lấy tất cả thông tin địa điểm của cấc tour du lịch
        $place = Place::whereHas('tours')->get();

        // Lấy thông tin 6 chuyến đi gần nhất được tạo sắp xếp theo thời gian tạo
        $tour = DB::table('tours')->orderBy('created_at')->take(6)->get();
        //Lấy thông tin 3 chuyến đi gần nhất được tạo sắp xếp theo thời gian tạo
        $blog = DB::table('blogs')->orderByDesc('created_at')->take(4)->get();
        //Đổ dữ liệu lên trang home
        return view('page/home', compact('place', 'tour', 'blog'));
    }

    //xem bài viết và chi tiết bài viết
    public function blog(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $blog = DB::table('blogs')->orderByDesc('created_at')->paginate(12);
        return view('page/blog', compact('blog'));
    }

    public function blog_detail($slug): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $category = Category::all();
        $blog = DB::table('blogs')->where('slug', '=', $slug)->first();
        $new_blog = Blog::all()->take(4);
        return view('page/blog_details', compact('blog', 'category', 'new_blog'));
    }

    // xem tour và chi tiết tour (đặt vé)
    public function tour(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $tour = DB::table('tours')->paginate(12);
        return view('page/tour', compact('tour'));
    }

    public function tour_detail($slug): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $place = Place::all();
        $tour = Tour::all()->where('slug', '=', $slug)->first();
        return view('page/tour_details', compact('tour', 'place'));
    }

    // xem bài viết theo danh mục và xem chuyến đi theo địa điểm
    public function category($slug)
    {
        $cat = Category::all()->where('slug', '=', $slug)->first();
        $category = Category::all();
        $blog = $cat->blogs()->paginate(12);
        return view('page/blog', compact('blog', 'category'));
    }

    public function place($slug)
    {
        $place = Place::all()->where('slug', '=', $slug)->first();
        $tour = $place->tours()->paginate(12);
        return view('page/place', compact('tour', 'place'));
    }
}
