<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Message;
use App\Models\Place;
use App\Models\Tour;
use App\Models\Transaction;
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
        //Lấy tất cả thông tin địa điểm nếu có chuyến đi
        $place = Place::whereHas('tours')->get();
        // Lấy thông tin 6 chuyến đi gần nhất được tạo sắp xếp theo thời gian tạo
        $tour = DB::table('tours')->inRandomOrder()->orderBy('created_at')->take(6)->get();
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
        $category = Category::whereHas('blogs')->get();
        $blog = DB::table('blogs')->where('slug', '=', $slug)->first();
        $new_blog = Blog::all()->take(6);
        return view('page/blog_details', compact('blog', 'category', 'new_blog'));
    }

    // xem tour và chi tiết tour (đặt vé)
    public function tour(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $tour = DB::table('tours')->inRandomOrder()->paginate(12);
        return view('page/tour', compact('tour'));
    }

    public function tour_detail($slug): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {

        $place = Place::all();
        $place = Place::whereHas('tours')->get();
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

    public function place($slug): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $place = Place::all()->where('slug', '=', $slug)->first();
        $tour = $place->tours()->paginate(12);
        return view('page/place', compact('tour', 'place'));
    }

    // liên hệ
    public function contact(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('page/contact');
    }

    public function tracuu(\Illuminate\Http\Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $ma = $request->input('madatve');
        // Lấy thông tin đặt vé
        $ketqua = Booking::where('booking_number', $ma)->first();
        // Kiểm tra xem có thông tin đặt vé không
        if ($ketqua) {
            // Lấy thông tin thanh toán
            $thanhtoan = Transaction::where('order_code', $ma)->first();
            // Lấy thông tin tour liên quan đến đặt vé
            $tour = $ketqua->tour;
            // Bây giờ bạn có thể sử dụng $ketqua, $thanhtoan, và $tour theo nhu cầu của bạn
            return view('page/tracuu', compact('ketqua', 'thanhtoan', 'tour'));
        } else {
            $ketqua = Deposit::where('deposit_number', $ma)->first();
            // Lấy thông tin thanh toán
            $thanhtoan = Transaction::where('order_code', $ma)->first();
            // Lấy thông tin tour liên quan đến đặt vé
            $tour = $ketqua->tour;
            // Bây giờ bạn có thể sử dụng $ketqua, $thanhtoan, và $tour theo nhu cầu của bạn
            return view('page/tracuu', compact('ketqua', 'thanhtoan', 'tour'));
        }
    }

    public function lienhe(\Illuminate\Http\Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $content = $request->input('message');

        $messgae = Message::create([
            'customer_name' => $name,
            'customer_email' => $email,
            'message' => $content
        ]);
        if ($messgae) {
            return redirect()->back()->with('message', 'Cảm ơn bạn đã liên hệ với chúng tôi');
        }
    }
}
