@component('mail::message')
    # Thanh toán thành công

    Mã Giao dịch: **{{ $transaction->transaction_no}}** đã được thanh toán thành công.

    Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.

    Thông tin thanh toán :
    - Tổng tiền thanh toán :{{$transaction->amount}}
    - Ngân hàng : {{$transaction->bank_code}}
    - Phương thức thanh toán : {{$transaction->card_type}}
    - Nội dung: {{$transaction->order_info}}

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
