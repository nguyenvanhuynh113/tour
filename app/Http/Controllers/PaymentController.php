<?php

namespace App\Http\Controllers;

use App\Filament\Resources\BookingResource;
use App\Mail\PaymentSuccess;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    // Thanh toán đặt vé bằng VN-PAY / Demo thanh toán bằng ngân hàng NCB
    public function payment(Request $request)
    {
        // Lấy thông tin đặt vé của khách hàng
        $slug = $request->slug;
        $name = $request->name;
        $email = $request->email;
        $date = $request->check_in_date;
        $phone = $request->phone;
        $adults = $request->adults;

        // Thông tin chuyến đi
        $tour = DB::table('tours')
            ->join('departure_dates', 'tours.id', '=', 'departure_dates.id_tour')
            ->select('tours.*', 'departure_dates.*')  // Lấy tất cả cột từ cả hai bảng
            ->where('tours.slug', '=', $slug)
            ->where('departure_dates.departure_date', '=', $date)
            ->first();
        // Tính tổng số tiền cần thanh toán ( Số lượng vé x giá theo ngày khởi hành )
        $total_oder = ($adults * $tour->prices);
        // Tạo CODE đơn hàng tự động
        $randomNumber = mt_rand(999, 10000);
        $orderCode = "OD-" . $randomNumber;
        // Cấu hình VN-PAY
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // URL giao diện thanh toán VN-PAY
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        // URL trả về khi thanh toán thành công
        $vnp_Returnurl = "http://127.0.0.1:8000/thanh-toan/ket-qua-giao-dich";
        // Tài khoản và mật khẩu của SANBOX VN-PAY (Demo Test)
        $vnp_TmnCode = "N64WNFSX";//Mã website tại VN-PAY
        $vnp_HashSecret = "EEIZYGHTNYAXGDCRYNQTDEAYGFIZQJSN"; //Chuỗi kí tự bí mật
        // Cấu hình thông tin thanh toán đặt vé
        $vnp_TxnRef = $orderCode; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đặt vé TOUR - VietTravel'; // Thông tin đơn hàng
        $vnp_Amount = $total_oder * 100; // Tổng tiền cần thanh toán
        $vnp_Locale = 'vn'; // việt nam
        $vnp_OrderType = 'payment';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        // tạo mảng chứa thông tin thanh toán VN-PAY
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        // Kiểm tra mã ngân hàng tồn tại hay không ? : chọn phương thức thanh toán
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        // Sắp xếp các giá trị INPUT
        ksort($inputData);
        //
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        //
        $vnp_Url = $vnp_Url . "?" . $query;
        //
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        // lưu thông tin đặt vé của người dùng
        $booking = Booking::create([
            'booking_number' => $orderCode, // mã đặt vé
            'customer_name' => $name, // tên khách hàng
            'email' => $email, // địa chỉ email
            'phone_number' => $phone,
            'departure_date' => $date,
            'person' => $adults,
            'total_prices' => $total_oder,
            'id_tour' => $tour->id,
        ]);
        // xử lý khi tạo thông tin đươn hàng thành công
        if ($booking) {
            // thông tin người dùng có vài trò QUẢN TRỊ VIÊN
            $users = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['Admin', 'Super Admin']);
            })->get();
            // tạo thông báo đơn hàng mới
            Notification::make()
                ->title('New order')
                ->icon('heroicon-o-shopping-bag')
                ->body("**{$name} đã thanh toán {$orderCode}**")
                ->actions([
                    Action::make('View')
                        ->url(BookingResource::getUrl('edit', ['record' => $booking])),
                ])
                ->sendToDatabase($users);
        }
        return redirect()->away($vnp_Url);
    }

    public function response(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        // Xử lý khi thanh toán thành công
        if ($request->vnp_ResponseCode === "00") {
            // Lưu thông tin giao dịch vào bảng transactions
            $transaction = new Transaction();
            $transaction->transaction_no = $request->vnp_TransactionNo;
            $transaction->bank_code = $request->vnp_BankCode;
            $transaction->amount = $request->vnp_Amount / 100; // Chuyển về đơn vị tiền tệ
            $transaction->card_type = $request->vnp_CardType;
            $transaction->order_info = $request->vnp_OrderInfo;
            $transaction->status = $request->vnp_ResponseCode === '00' ? 1 : 0;
            $transaction->id_user = auth()->user()->id; // Lưu thông tin giao dịch vào người dùng
            $transaction->save();
            // Gởi mail thông báo thanh toán thành công cho người dùng
            Mail::to(auth()->user()->email)->send(new PaymentSuccess($transaction));
            //
            return redirect('/chuyen-di')->with('message', 'Thanh toán giao dịch thành công.');
        } else {
            // Xử lý khi thanh toán thất bại
            return redirect('/chuyen-di')->with('error', 'Lỗi giao dịch! Vui lòng thử lại sau.');
        }

    }
}
