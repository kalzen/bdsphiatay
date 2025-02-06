<table style="width:100%" border="1">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Sản phẩm</th>
			<th scope="col">Giá</th>
			<th scope="col">SL</th>
			<th scope="col">Thành tiền</th>
		</tr>
	</thead>
	<tbody>
        @foreach($order as $cart)
		<tr>
			<th scope="row">{{$loop->index+1}}</th>
			<td>{{$cart['name']}}</td>
			<td>{{$cart['price']}}</td>
			<td>{{$cart['quantity']}}</td>
			<td>{{$cart['sub_total']}}</td>
		</tr>
        @endforeach
	</tbody>
</table>

<p><b>Họ tên:</b> {{$user['name']}}</p>
<p><b>Số điện thoại:</b> {{$user['mobile']}}</p>
<p><b>Nơi nhận hàng:</b> {{$user['address']}}</p>
<p><b>Tổng thanh toán:</b>{{number_format(collect($order)->pluck('sub_total')->sum(),0)}} VNĐ</p>
