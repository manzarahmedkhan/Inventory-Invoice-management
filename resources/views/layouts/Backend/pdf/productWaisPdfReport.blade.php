<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
</head>
<body>
	<h2 style="text-align:center; color: #4e73df; padding-bottom: 5px; margin-left: 20px;" class="text-primary"><strong>Product Detail Report</strong></h2>
	
    <hr style="padding-bottom: 0px;">
    <h3 style="color: black; padding-bottom: 0">
	  <strong>Description:- {{ $product['name'] }} </strong>
	</h3>
	<table border="1" width="100%" style="text-align: center;">
		<thead>
			<tr>
               <th>Item Code</th>
               <th>Category</th>
               <th>Description</th>
               <th>Stock</th>
            </tr>
		</thead>
	    <tbody>
            <tr>
                <td>{{ $product->code }}</td>
                <td>{{ $product['category']['name'] }}</td>
                <td>{{ $product->name }}</td>
                <td>
                {{ $product->quantity }}
                {{ $product['unit']['name'] }}
                </td>
            </tr>
        </tbody>
	</table>
@php
	$date = new DateTime('now', new DateTimezone('Asia/Riyadh'));
	if(env('DATETIMEZONE')){
		$date = new DateTime('now', new DateTimezone(env('DATETIMEZONE')));
	} 
@endphp
<br>
<strong>
	Date/Time :- {{ $date->format('d-m-Y H:i A') }}
</strong>
<hr>
<table width="100%">
	<tbody>
		<tr>
			<td style="text-align: left;">Shop Signature</td>
			<td style="text-align: right;">Owner Signature</td>
		</tr>
	</tbody>
</table>
</body>
</html>