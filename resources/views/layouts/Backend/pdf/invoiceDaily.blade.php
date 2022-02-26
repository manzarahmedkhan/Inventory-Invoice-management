<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
</head>
<body>
	<h2 style="text-align:center; color: #4e73df; padding-bottom: 5px; margin-left: 20px;" class="text-primary"><strong>Invoice Report</strong></h2>
	
    <hr style="padding-bottom: 0px;">
    <h4 style="color: black; padding-bottom: 0">
	  <strong>Date:-
	   ( {{ date('d-m-Y', strtotime($stime)) }} - {{ date('d-m-Y', strtotime($etime)) }} ) 
	</strong>
	</h4>
<table border="1" width="100%" style="text-align: center;">
	<thead>
		<tr>
			<td>Date</td>
			<td width="30%">Customer Name-Mobile</td>
			<td>Invoice No</td>
			<td>Comment</td>
			<td>Amount</td>
		</tr>
	</thead>
	<tbody>
		@php 
		$subTotal = '0';
		@endphp
		@foreach($invoices as $invoice)
		<tr>
			<td>{{ date('d-m-Y',strtotime($invoice->date)) }}</td>
			<td>
				@php
				$customerMobile = $invoice->payment->customer->mobile ?? $invoice->customer_mobile;
				@endphp
				{{ $invoice->payment->customer->name ?? $invoice->customer_name }}@if($customerMobile){{'-'.$customerMobile }}@endif 
			</td>
			<td align="right">{{ $invoice->invoice_no }}</td>
			<td>{{ $invoice->description ?? $invoice->comments }}</td>
			@php
			$totalAmount = $invoice->payment->total_amount ?? $invoice->total_amount;
			@endphp
			<td align="right">{{ number_format($totalAmount,2) }}</td>
		</tr>
		@php
		$subTotal += $totalAmount;
		@endphp
		@endforeach
		<tr>
			<td style="text-align: right; color:green;" colspan="4">Sub Total:-</td>
			<td style="color:green;">{{ number_format($subTotal,2) }}</td>
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