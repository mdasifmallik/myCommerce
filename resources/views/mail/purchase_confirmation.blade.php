<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Confirmation Mail</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <h1 class="text-center">Product Bought Successfully!</h1>

            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($final_order_details as $final_order)
                    <tr>
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td>{{ $final_order->product->product_name }}</td>
                        <td>{{ $final_order->product->product_price }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td scope="row">#</td>
                        <td>Sub Total</td>
                        <td>{{ $final_order_info->sub_total }}</td>
                    </tr>
                    @if($final_order_info->coupon_name)
                    <tr>
                        <td scope="row">#</td>
                        <td>Coupon</td>
                        <td>{{ $final_order_info->coupon_name }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td scope="row">#</td>
                        <td>Total</td>
                        <td>{{ $final_order_info->total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
</body>

</html>
