<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
\Illuminate\Support\Facades\Auth::routes();

// bài viết
Route::get('/bai-viet', [\App\Http\Controllers\HomeController::class, 'blog'])
    ->name('bai-viet');
Route::get('/chi-tiet-bai-viet/{slug}', [\App\Http\Controllers\HomeController::class, 'blog_detail'])
    ->name('chi-tiet-bao-viet');
Route::get('danh-muc-bai-viet/{slug}', [\App\Http\Controllers\HomeController::class, 'category'])
    ->name('danh-muc-bai-viet');
// tour
Route::get('/chuyen-di', [\App\Http\Controllers\HomeController::class, 'tour'])
    ->name('chuyen-di');
Route::get('/chi-tiet-chuyen-di/{slug}', [\App\Http\Controllers\HomeController::class, 'tour_detail'])
    ->name('chi-tiet-chuyen-di');
Route::get('/dia-diem-du-lich/{slug}', [\App\Http\Controllers\HomeController::class, 'place'])
    ->name('dia-diem-du-lich');
// các trang khác
Route::get('/lien-he', [\App\Http\Controllers\HomeController::class, 'contact'])
    ->name('lien-he');
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/lien-he', function () {
    return view('page/contact');
});
Route::get('thanh-cong', function () {
    return view('page/success_page');
});
// tìm kiếm
Route::post('/tim-kiem', [\App\Http\Controllers\SearchController::class, 'search'])->name('tim-kiem');
// goi y
Route::get('goi-y-chuyen-di', [\App\Http\Controllers\SearchController::class, 'Tour_Suggestions'])->name('goi-y-chuyen-di');
Route::get('goi-y-bai-viet', [\App\Http\Controllers\SearchController::class, 'Blog_Suggestions'])->name('goi-y-bai-viet');
// thanh toán online bằng VN PAY
Route::post('/thanh-toan', [\App\Http\Controllers\PaymentController::class, 'payment'])->name('thanh-toan');
Route::get('/thanh-toan/ket-qua-giao-dich', [\App\Http\Controllers\PaymentController::class, 'response']);
