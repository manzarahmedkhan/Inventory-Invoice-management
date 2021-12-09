<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Invoice</title>
	<style type="text/css">
		body {
			font-family: 'XB Riyaz', sans-serif;
			margin: 0;
			padding: 0;
			width: 100%;
		}
		#footer {
		  position: fixed;
		  width: 100%;
		  bottom: 0;
		  left: 0;
		  right: 0;
		  text-align: center;
		}

		#footer p {
		  border-top: 2px solid #555555;
		  margin-top:10px;
		}
	</style>
</head>
<body>
<h1 style="text-align:center; color: #4e73df;margin:-20px auto 0;padding: 0;display: block;position: relative;" class="text-primary">
	<strong>{{Auth::user()->arabic_shopName}}</strong>
</h1>
<h4 style="text-align:center; color: green; margin:0px auto 0; padding: 0;" class="text-primary">
	<strong>{{Auth::user()->shopName}}</strong>
</h4>

<table width="100%" class="table" style="text-align: center;">
    <tbody class="text-center">
			<tr>
			   <td align="left">
				    <span style="font-size: 15px;">
				    	{{Auth::user()->description}} <br>
				    	{{Auth::user()->CR_no}}	
				    </span>
			    </td>
			    <td align="right">
				    <span style="font-size: 15px;">
				    	{{Auth::user()->arabic_description}} <br>
				    	{{Auth::user()->arabic_CR_no}}	
				    </span>
			    </td>
			</tr>
	</tbody>
</table>

<table width="100%" class="table" style="text-align: center;">
    <tbody class="text-center">
			<tr>
			   <td align="left">
				    <span style="font-size: 17px;">
				    	Invoice No : <strong>{{ sprintf("%05d", $invoice->invoice_no)  }}</strong>
				    </span>
			    </td>
			    <td align="right">
		    	 <span style="font-size: 15px;text-align:right;">
		    		@php
						$date = new DateTime('now', new DateTimezone('Asia/Riyadh'));
						if(env('DATETIMEZONE')){
							$date = new DateTime('now', new DateTimezone(env('DATETIMEZONE')));
						} 
					@endphp
		    		Date/Time : {{ date('d-m-Y',strtotime($invoice->date)).$date->format(' H:i A') }}
				 </span>
		    	</td>
			</tr>
	</tbody>
</table>
<hr>
<!-- <table width="100%">
	<tbody>
		<tr>
			<td width="100%" style="text-align: center; color: black;  padding: 10px 0px; font-size: 20px;"><h4><strong>Customer Information:-</strong></h4></td>
		</tr>
	</tbody>
</table> -->
<table width="100%">
	<tbody>
	  <tr>
	  <td colspan="4">	
		<span style="font-size: 15px;">
		 Customer Name : <strong>{{ $invoice->customer_name }} </strong>
		</span>
	  </td>
	  	@if($invoice->customer_mobile)
		<td colspan="4">
		<span style="font-size: 15px;">
		 Mobile : {{ $invoice->customer_mobile }}
		</span>
	    </td>
	    @endif
	  </tr>
	</tbody>
</table>
<hr>
<table width="100%" border="1" style="text-align: center;border-color: #DDD;">
	<thead style="background:#cdced2;">
        <tr>
           <th width="6%">Sr.#</th>
           <!-- <th>Category Name</th> -->
           <th width="12%">Item Code</th>
           <th>Description</th>
           <th width="8%">Qty.</th>
           <th width="12%">Unit Price</th>
           <th width="15%">Total Price</th>
        </tr>
    </thead>
    <tbody>
    	@php 
    	$subTotal = '0';
    	@endphp
    @foreach($invoice->fakeBillsDetails as $key => $invoiceDetal)
      <tr>
    	<td>{{ $key+1 }}</td>
    	<td>{{ $invoiceDetal->code }}</td>
    	<td align="left">{{ $invoiceDetal->name }}</td>
    	<td>{{ $invoiceDetal->quantity }}</td>
    	<td align="right">{{ number_format($invoiceDetal->unit_price,2) }}</td>
    	<td align="right">{{ number_format($invoiceDetal->selling_price,2) }}</td>
      </tr>
      @php
      $subTotal += $invoiceDetal->selling_price;
      @endphp
    @endforeach
    <tr>
    	<td colspan="6" style="text-align: center;color: red;">Nothing Follows</td>
    </tr>
    <tr>
    	<td colspan="6" height="25"></td>
    </tr>
    <tr>
    	<td colspan="6" height="25"></td>
    </tr>
    <tr>
    	<td colspan="5" style="text-align: right;">Sub Total:-</td>
    	<td align="right">{{ number_format($subTotal,2) }}</td>
    </tr>
    <tr>
    	<td colspan="5" style="text-align: right;">Discount Amount:-</td>
    	<td align="right">-{{ isset($invoice->discount_amount) > 0 ? number_format($invoice->discount_amount,2) : 0.00 }}</td>
    </tr>
    <tr>
    	<td colspan="5" style="text-align: right;">VAT Amount:-</td>
    	<td align="right">{{ number_format($invoice->vat_amount,2) }}</td>
    </tr>
    <tr>
    	<td colspan="5" style="text-align: right;">Grand Total:-</td>
    	<td align="right">{{ number_format($invoice->total_amount,2) }}</td>
    </tr>
    </tbody>
</table>
<!-- <br>
<strong>
	Date/Time :- {{ $date->format('d-m-Y H:i A') }}
</strong> -->
<!-- <hr> -->
<div id="footer">
	<table width="100%">
	<tbody>
		<tr>
			<td style="text-align: left;">Receiver Signature
				<br><br><br><br>
				<hr style="text-align: left; color: black;" width="60%">
			</td>
			<td style="text-align: right;">Salesman Signature
				<br><br><br><br>
				<hr style="text-align: right;color: black;" width="50%">
			</td>
		</tr>
	</tbody>
</table>
  	<hr style="margin:0 !important">
  	<span style="font-size: 16px;color: #4e73df">
  	  {{ Auth::user()->arabic_address}} @if(!empty(Auth::user()->arabic_number))| {{Auth::user()->arabic_number}} @endif @if(!empty(Auth::user()->arabic_number_2))| {{Auth::user()->arabic_number_2}} @endif @if(!empty(Auth::user()->arabic_number_3))| {{Auth::user()->arabic_number_3}}@endif
  	</span>
	<br>
	<span style="font-size: 15px;color: green">
		{{ Auth::user()->address}} @if(!empty(Auth::user()->number))| {{Auth::user()->number}} @endif @if(!empty(Auth::user()->number_2))| {{Auth::user()->number_2}} @endif @if(!empty(Auth::user()->number_3))| {{Auth::user()->number_3}}@endif
	</span>	
	<br><br>
</div>
</body>
</html>