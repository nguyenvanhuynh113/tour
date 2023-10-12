<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    //Tìm kiếm trên trang chính ( nhiều điều kiên)

    public function search(Request $request)
    {
        $place = $request->place;
        $check_in_date = $request->check_in_date;
        $check_out_date = $request->check_out_date;
        $price = $request->tour_prices;
    }

    public function search_blog($key)
    {

    }

    public function search_tour($key)
    {

    }

}
