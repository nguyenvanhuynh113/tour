<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ĐẶT VÉ DU LỊCH</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            padding: 20px;
            margin: 0 auto;
            max-width: 600px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .card-header {
            background-color: #dc3545;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            padding: 20px 0;
            border-radius: 10px 10px 0 0;
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .card-footer {
            text-align: center;
            font-size: 14px;
            color: #868e96;
            padding: 10px 0;
            border-radius: 0 0 10px 10px;
        }

        .btn {
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header text-center text-uppercase">THÔNG TIN ĐẶT VÉ</div>
        <div class="card-body">
            <h4 class="card-title">Cảm ơn bạn đã sử dụng dịch vụ của VietTravel. Dưới đây là thông tin đơn hàng của
                bạn.</h4>
            <ul class="list-group">
                <li class="list-group-item">ĐƠN HÀNG SỐ: <strong>{{$booking->booking_number}}</strong></li>
                <li class="list-group-item">TỔNG THANH TOÁN: <strong>{{$booking->total_prices}}</strong></li>
                <li class="list-group-item">NGÀY TẠO ĐƠN: {{$booking->created_at}}</li>
                <li class="list-group-item">NGÀY KHỞI HÀNH: {{$booking->departure_date}}</li>
                @if($booking->status === 'success')
                    <li class="list-group-item text-success">Trạng thái: {{$booking->status}}</li>
                @else
                    <li class="list-group-item text-danger">Trạng thái: {{$booking->status}}</li>
                @endif
            </ul>
            <div class="card-text mt-3">
                <h5 class="font-weight-bold">THÔNG TIN KHÁCH HÀNG:</h5>
                <p>Tên: {{$booking->customer_name}}</p>
                <p>Email: {{$booking->email}}</p>
                <p>Số điện thoại: {{$booking->phone_number}}</p>
            </div>
        </div>
        <div class="card-footer">Cảm ơn bạn. VietTravel</div>
    </div>
    <div class="row mt-4 justify-content-center">
        <a href="{{\Illuminate\Support\Facades\URL::to('/')}}" class="btn">Xem chi tiết</a>
    </div>
</div>
</body>
</html>
