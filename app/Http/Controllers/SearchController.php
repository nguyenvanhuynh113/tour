<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //Tìm kiếm trên trang chính ( nhiều điều kiện)
    public function search(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $place = $request->input('place');
        $checkInDate = $request->input('check_in_date');
        $tourPrices = $request->input('tour_prices');
        // Tìm các chuyến đi (tour) theo địa điểm (place)
        $tour = Tour::whereHas('place', function ($query) use ($place) {
            $query->where('name', 'like', "%$place%");
        });
        // Tìm các chuyến đi (tour) theo ngày khởi hành (departure_dates)
        if ($checkInDate) {
            $tour->whereHas('departure_dates', function ($query) use ($checkInDate) {
                $query->where('departure_date', '>=', $checkInDate);
            });
        }
        // Tìm các chuyến đi (tour) theo giá
        if ($tourPrices) {
            $tour->where('normal_prices', '<=', $tourPrices);
        }

        $tour = $tour->paginate(12);
        return view('page/tour', compact('tour'));

    }

    public function search_blog(Request $request)
    {
        $key = $request->key;
        if (isset($key)) {

        } else {
            return view('page/blog_details');
        }
    }

    public function search_tour(Request $request)
    {
        $key = $request->key;
        if (isset($key)) {

        } else {
            return view('page/tour_details');
        }
    }

}
