<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class Overview extends BaseWidget
{
    protected function getCards(): array
    {
        // Khởi tạo giá trị vào mãng để vẽ chart
        $data_user = [];
        $data_oder = [];
        $data_blog = [];
        $data_tour = [];
        // Lấy thời điểm đầu và cuối của tháng hiện tại
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        // Lặp qua từng ngày trong tháng
        $currentDate = $firstDayOfMonth;
        while ($currentDate <= $lastDayOfMonth) {
            // Lấy số lượng người dùng mới tạo trong ngày
            $newUsersCount = User::whereDate('created_at', $currentDate)->count();
            // Lấy số lượng đơn hàng mới trong ngày
            $newbookingCount = Booking::whereDate('created_at', $currentDate)->count();
            // Lấy số lượng bài viết mới trong ngày
            $newBlogCount = Blog::whereDate('created_at', $currentDate)->count();
            // Lấy số lượng chuyến đi tạo mới mới trong ngày
            $newTourCount = Tour::whereDate('created_at', $currentDate)->count();
            // Gắn số lượng người dùng mới vào mảng
            $data_user[$currentDate->format('Y-m-d')] = $newUsersCount;
            // Gắn số lượng đặt vé mới vào mảng
            $data_oder[$currentDate->format('Y-m-d')] = $newbookingCount;
            // Gắn số lượng bài viết mới vào mảng
            $data_blog[$currentDate->format('Y-m-d')] = $newBlogCount;
            // Gắn số lượng chuyến đi mới vào mảng
            $data_tour[$currentDate->format('Y-m-d')] = $newTourCount;
            // Chuyển sang ngày tiếp theo
            $currentDate->addDay();
        }
        // Tổng Doanh thu từ bán vé
        $totalPrices = Booking::all()->sortByDesc('created_at')->sum('total_prices');
        // Hàm chuyển đổi số sang dạng có "k" thay thế dấu phân cách hàng nghìn
        function formatTotalPrices($totalPrices)
        {
            $formattedValue = $totalPrices / 1000000; // Chia cho 1 triệu
            return number_format($formattedValue, 1, ',', '.') . ' triệu'; // Định dạng và thêm ký tự "triệu"
        }
        // Gọi hàm để format số lượng
        $formattedTotalPrices = formatTotalPrices($totalPrices);
        return [
            Card::make('Tài khoản mới trong tháng', User::all()
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count())
                ->description('Tổng: ' . User::all()->count() . ' tài khoản')
                ->chart($data_user)
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('warning'),
            Card::make('Đơn hàng mới trong tháng', Booking::all()
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                ->count())
                ->description('Doanh thu: ' . $formattedTotalPrices . ' vnđ')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($data_oder)
                ->color('success'),
            // Lấy thời điểm đầu và cuối của tháng hiện tại
            Card::make('Bài viết mới trong tháng', Blog::all()
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count())
                ->description('Tổng: ' . Blog::all()->count() . ' bài viết ')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($data_blog)
                ->color('success'),
            Card::make('Chuyến đi mới trong tháng', Tour::all()
                ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                ->count())
                ->description('Tổng: ' . Tour::all()->count() . ' chuyến đi')
                ->descriptionIcon('heroicon-s-trending-up')
                ->chart($data_tour)
                ->color('success'),
        ];
    }
}
