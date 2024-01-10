<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    //Tìm kiếm trên trang chính ( nhiều điều kiện)
    public function search(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $place = $request->input('place');
        $checkInDate = $request->input('check_in_date');
        $min_prices = $request->input('min_prices');
        $max_prices = $request->input('max_prices');
        $type=$request->input('type');
        // Tìm các chuyến đi (tour) theo địa điểm (place)
        $tour = Tour::whereHas('place', function ($query) use ($place) {
            $query->where('name', 'like', "%$place%");
        });
        // Tìm các chuyến đi (tour) theo thể loại (type)
        $tour = Tour::whereHas('type', function ($query) use ($type, $place) {
            $query->where('name', 'like', "%$type%");
        });
        // Tìm các chuyến đi (tour) theo ngày khởi hành (departure_dates)
        if ($checkInDate) {
            $tour->whereHas('departure_dates', function ($query) use ($checkInDate) {
                $query->where('departure_date', '>=', $checkInDate);
            });
        }
        if ($min_prices && $max_prices){
            $tour->whereBetween('normal_prices', [$min_prices, $max_prices]);
        }
        // Tìm các chuyến đi (tour) theo giá
        if ($min_prices) {
            $tour->where('normal_prices', '>=', $min_prices);
        }
        if ($max_prices){
            $tour->where('normal_prices', '<=', $max_prices);
        }
        $tour = $tour->paginate(12);
        return view('page/tour', compact('tour'));

    }

    public function Blog_Suggestions(Request $request)
    {
        $keyword = $request->input('keyword');
        $suggestions = DB::table('blogs')->where('title', 'LIKE', "%$keyword%")->get();
        return response()->json($suggestions);
    }
    public function Tour_Suggestions(Request $request)
    {
        $keyword = $request->input('keyword');
        $suggestions = DB::table('tours')->where('title', 'LIKE', "%$keyword%")->get();
        return response()->json($suggestions);
    }

}
