<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
</head>
<body>
	<h2 style="text-align:center; color: #4e73df; padding-bottom: 5px; margin-left: 20px;" class="text-primary"><strong>All Product stock List</strong></h2>
	<!-- <h5 style="text-align: center; color: black; padding-bottom: 0">
	  <strong>Shop Owner Mobile:- 01871848137</strong>
	</h5> -->
    <hr style="padding-bottom: 0px;">
    <!-- <h3 style="color: black; padding-bottom: 0">
	  <strong>All Product stock List</strong>
	</h3> -->
	<table border="1" width="100%" style="text-align: center;">
		<thead>
			<tr>
               <th>SL.</th>
               <th>Supplier</th>
               <th>Item Code</th>
               <th>Category</th>
               <th>Description</th>
               <th>In (Stock)</th>
               <th>Out (Stock)</th>
               <th>Current (Stock)</th>
            </tr>
		</thead>
	    <tbody>
            @foreach($stocks as $key => $stock)
            @php 
            $purchase_stock = App\Model\purchase::where('category_id', $stock->category_id)->where('product_id',$stock->id)->where('status', '1')->sum('buying_qty');
            $selling_stock  = App\Model\invoiceDetail::where('category_id',$stock->category_id)->where('product_id', $stock->id)->where('status', '1')->sum('selling_qty');
            @endphp
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $stock['supplier']['name'] }}</td>
                <td>{{ $stock->code }}</td>
                <td>{{ $stock->category->name }}</td>
                <td>{{ $stock->name }}</td>
                <td>
                	{{ $purchase_stock }}
                	{{ $stock['unit']['name'] }}
                </td>
                <td>
                	{{ $selling_stock }}
                	{{ $stock['unit']['name'] }}
                </td>
                <td>
                {{ $stock->quantity }}
                {{ $stock['unit']['name'] }}
                </td>
            </tr>
            @endforeach
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
</body>
</html>