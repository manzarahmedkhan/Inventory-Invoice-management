<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
</head>
<body>
	<h2 style="text-align:center; color: #4e73df; padding-bottom: 5px;" class="text-primary"><strong>{{ Auth::user()->shopName }}</strong></h2>
	<!-- <h5 style="text-align: center; color: black; padding-bottom: 0">
	  <strong>{{ Auth::user()->shopName }}</strong>
	</h5>
	<h5 style="text-align: center; color: black; padding-bottom: 0">
	  <strong></strong>
	</h5> -->
    <hr style="padding-bottom: 0px;">
    <h4 style="color: black; padding-bottom: 0">
	  <strong>Daily Invoice Report:-
	   ( {{ date('d-m-Y', strtotime($sdate)) }} - {{ date('d-m-Y', strtotime($edate)) }} ) 
	</strong>
	</h4>
<table border="1" width="100%" style="text-align: center;">
	<thead>
		<tr>
			<td>SL.</td>
			<td>Supplier Name</td>
			<td>Category Name</td>
			<td>Product Name</td>
			<td>Buying Quantity</td>
			<td>Unit Price</td>
			<td>Buying Price</td>
		</tr>
	</thead>
	<tbody>
		@php
		$subTotal = '0';
		@endphp
		@foreach($purchases as $key => $purchase)
		<tr>
			<td>{{ $key+1 }}</td>
			<td>{{ $purchase->supplier->name }}</td>
			<td>{{ $purchase->category->name }}</td>
			<td>{{ $purchase->product->name }}</td>
			<td>{{ $purchase->buying_qty }}</td>
			<td>{{ $purchase->unit_price }}</td>
			<td>{{ $purchase->buying_price }}</td>
		</tr>
		@php
		$subTotal += $purchase->buying_price;
		@endphp
		@endforeach
		<tr>
			<td style="text-align: right; color:green;" colspan="6">Sub Total:-</td>
			<td style="color:green;">{{ $subTotal }}</td>
		</tr>
	</tbody>
</table>
<!-- <hr>
<table width="100%">
	<tbody>
		<tr>
			<td style="text-align: left;">Receiver Signature</td>
			<td style="text-align: right;">Seller Signature</td>
		</tr>
	</tbody>
</table> -->
</body>
</html>