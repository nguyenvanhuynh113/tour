<?php

namespace App\Http\Controllers;

use App\Filament\Resources\BookingResource;
use App\Filament\Resources\OderResource;
use App\Mail\PaymentSuccess;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $children = $request->children;
        $kids = $request->kids;
        // Thông tin chuyến đi
        $tour = DB::table('tours')
            ->join('departure_dates', 'tours.id', '=', 'departure_dates.id_tour')
            ->select('tours.id', 'departure_dates.prices')  // Lấy tất cả cột từ cả hai bảng
            ->where('tours.slug', '=', $slug)
            ->where('departure_dates.departure_date', '=', $date)
            ->first();
        // Tính tổng số tiền cần thanh toán ( Số lượng vé x giá theo ngày khởi hành -- tính theo loại khách hàng)
        $adults_prices = ($adults * $tour->prices); // người lớn không giảm
        $children_prices = (($children * $tour->prices) * 0.75); // trẻ em giảm 25%
        $kids_prices = (($kids * $tour->prices) * 0.25); // em bé giảm 75%
        //
        $total_oder =$kids_prices+$adults_prices+$children_prices;
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
        // Email khách hàng
        $vnp_Inv_Email = $email;
        // Tài khoản và mật khẩu của SANBOX VN-PAY (Demo Test)
        $vnp_TmnCode = "N64WNFSX";//Mã website tại VN-PAY
        $vnp_HashSecret = "EEIZYGHTNYAXGDCRYNQTDEAYGFIZQJSN";//Chuỗi kí tự bí mật
        // Cấu hình thông tin thanh toán đặt vé
        $vnp_TxnRef = $orderCode; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toán đặt vé TOUR - VietTravel';// Thông tin đơn hàng
        $vnp_Amount = $total_oder * 100; // Tổng tiền cần thanh toán
        $vnp_Locale = 'vn'; // việt nam
        $vnp_OrderType = 'payment';
        // tạo mảng chứa thông tin thanh toán VN-PAY
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_Inv_Email" => $vnp_Inv_Email,
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        ksort($inputData);
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

        $vnp_Url = $vnp_Url . "?" . $query;

        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
        , 'message' => 'Đặt hàng thành công! Kiểm tra email để xem hóa đơn đặt hàng'
        , 'data' => $vnp_Url);
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
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
            'status' => 'chưa thanh toán',
            'id_tour' => $tour->id,
        ]);
        $user = User::all()->where('email', 'LIKE', '@admin.com');
        // xử lý khi tạo thông tin đươn hàng thành công
        if ($booking) {
            // cập nhật số lượng vé
            DB::table('departure_dates')
                ->where('id_tour', $tour->id)  // Sử dụng where để tìm theo id_tour
                ->where('departure_date', $date)  // Sử dụng where để tìm theo ngày khởi hành
                ->decrement('quantity', $adults);  // Giảm "quantity" đi số lượng người lớn
            // tạo thông báo đơn hàng mới
            Notification::make()
                ->title('Đơn hàng mới')
                ->icon('heroicon-o-shopping-bag')
                ->body("**{$name} đã đặt {$booking->person} vé. Mã ĐH: {$orderCode}**")
                ->actions([
                    \Filament\Notifications\Actions\Action::make('Xem chi tiết')
                        ->url(BookingResource::getUrl('edit', ['record' => $booking])),
                ])
                ->sendToDatabase(User::all());
            // Gởi mail thông báo thanh toán thành công cho người dùng
            Mail::to($email)->send(new PaymentSuccess($booking));
        }
        return redirect($vnp_Url);
    }

    public function response(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        // Xử lý khi thanh toán thành công
        if ($request->vnp_ResponseCode === "00") {
            // Cập nhật trạng thái đơn hàng nếu thanh toán thành công
            DB::table('bookings')->where('booking_number', '=', $request->vnp_TxnRef)
                ->update(['status' => 'thanh toán thành công']);
            // Lưu thông tin giao dịch vào bảng transactions
            $transaction = new Transaction();
            $transaction->order_code = $request->vnp_TxnRef;
            $transaction->transaction_no = $request->vnp_TransactionNo;
            $transaction->bank_code = $request->vnp_BankCode;
            $transaction->amount = $request->vnp_Amount / 100; // Chuyển về đơn vị tiền tệ
            $transaction->card_type = $request->vnp_CardType;
            $transaction->order_info = $request->vnp_OrderInfo;
            $transaction->status = $request->vnp_ResponseCode === '00' ? 1 : 0;
            if (Auth::check()) {
                $transaction->id_user = auth()->user()->id; // Lưu thông tin giao dịch vào người dùng
            }
            $transaction->save();
            return redirect('/thanh-cong');
        } else {
            // Xử lý khi thanh toán thất bại
            return redirect('/thanh-cong');
        }

    }
}
