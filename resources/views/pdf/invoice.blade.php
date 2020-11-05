<h1>Your Invoice!</h1>
<p>Order ID: {{ $order_info->id }}</p>
<p>Sub Total: {{ $order_info->sub_total }}</p>
<p>Coupon: {{ $order_info->coupon_name }}</p>
<p>Discount Amount: {{ $order_info->discount_amount }}</p>
<p>Total: {{ $order_info->total }}</p>
