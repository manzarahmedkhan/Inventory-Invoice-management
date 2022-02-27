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
			<td width="14%">Date</td>
			<td>Customer Name-Mobile</td>
			<td width="10%">Invoice#</td>
			<td width="13%">Amount</td>
			<td width="11%">Vat(15%)</td>
			<td width="13%">Total</td>
		</tr>
	</thead>
	<tbody>
		@php 
		$bankTotal =0;
		$cashTotal =0;
		$subAmount = 0;
		$cashAmount = 0;
		$bankAmount = 0;
		$finalTotal = 0;
		$cashVat = 0;
		$bankVat = 0;
		$finalVat = 0;
		$finalAmount = 0;
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
			@php
			$totalAmount = $invoice->payment->total_amount ?? $invoice->total_amount;
			$vatAmount = $invoice->vat_amount ?? 0.00;
			$subAmount = $totalAmount - $vatAmount;
			@endphp
			<td>{{ $invoice->invoice_no }}</td>
			<td align="right">{{ number_format($subAmount,2) }}</td>
			<td align="right">{{ number_format($vatAmount,2) }}</td>
			<td align="right">{{ number_format($totalAmount,2) }}</td>
		</tr>
		@php
		$paymentMode = $invoice->payment_mode ?? null;
		if($paymentMode == "Bank"){
			$bankAmount += $subAmount;
			$bankVat += $vatAmount;
			$bankTotal += $totalAmount;
		}else{
			$cashAmount += $subAmount;
			$cashVat += $vatAmount;
			$cashTotal  += $totalAmount;
		}
		$finalAmount += $subAmount;
		$finalVat += $vatAmount;
		$finalTotal += $totalAmount;
		@endphp
		@endforeach
		<tr>
			<td style="text-align: right; color:blue;" colspan="3">Cash Total:-</td>
			<td style="text-align: right; color:blue;">{{ number_format($cashAmount,2) }}</td>
			<td style="text-align: right; color:blue;">{{ number_format($cashVat,2) }}</td>
			<td style="text-align: right; color:blue;">{{ number_format($cashTotal,2) }}</td>
		</tr>
		<tr>
			<td style="text-align: right; color:red;" colspan="3">Bank Total:-</td>
			<td style="text-align: right; color:red;">{{ number_format($bankAmount,2) }}</td>
			<td style="text-align: right; color:red;">{{ number_format($bankVat,2) }}</td>
			<td style="text-align: right; color:red;">{{ number_format($bankTotal,2) }}</td>
		</tr>
		<tr>
			<td style="text-align: right; color:green;" colspan="3">Total:-</td>
			<td style="text-align: right; color:green;">{{ number_format($finalTotal,2) }}</td>
			<td style="text-align: right; color:green;">{{ number_format($finalTotal,2) }}</td>
			<td style="text-align: right; color:green;">{{ number_format($finalTotal,2) }}</td>
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