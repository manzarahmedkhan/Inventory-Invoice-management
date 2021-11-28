<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Invoice</title>
	<style type="text/css">
		body {
			font-family: 'XB Riyaz', sans-serif;
		}
	</style>
</head>
<body>
<h2 style="text-align:center; color: #4e73df; padding-bottom: 5px; margin-left: 20px;" class="text-primary">
	<strong>{{Auth::user()->shopName}}</strong>
</h2>
<h4 style="text-align:center; color: green; padding-bottom: 5px; margin-left: 20px;" class="text-primary">
	<strong>{{Auth::user()->arabic_shopName}}</strong>
</h4>
<table width="100%" class="table" style="text-align: center;">
    <tbody class="text-center">
			<tr>
			   <td>
				    <h4 class="text-dark"><strong>Invoice No:- {{ $invoice->invoice_no }}</strong></h4>
			    </td>
			    <td>
					<h5 class="text-dark">
						<strong><span style="color:red">|</span> Mobile No:- {{ Auth::user()->number }}</strong>
					</h5>
			    </td>
			    <td>
			    	<h5 class="text-dark">
					 <strong><span style="color:red">|</span> Address:- {{ Auth::user()->address }}</strong>
					</h5>
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
	  <td colspan="6">	
		<h5 class="text-dark">
		 <strong>Customer Name:- {{ $invoice->payment->customer->name }} </strong>
		</h5>
	  </td>
	  	@if($invoice->payment->customer->mobile)
		<td colspan="6"><h5 class="text-dark">
		 <strong>Mobile:- {{ $invoice->payment->customer->mobile }}</strong>
		</h5>
	    </td>
	    @endif
		<!-- <td><h5 class="text-dark">
		 <strong>Email:- {{ $invoice->payment->customer->email }}</strong>
		</h5>
	    </td>
		<td><h5 class="text-dark">
		 <strong>Address:- {{ $invoice->payment->customer->address }}</strong>
		</h5>
	    </td> -->
	  </tr>
	</tbody>
</table>
<hr>
<table width="100%" border="1" style="text-align: center;">
	<thead style="background:#cdced2;">
        <tr>
           <th width="10%">SR NO.</th>
           <!-- <th>Category Name</th> -->
           <th width="30%">Product Name</th>
           <th width="20%">Quantity</th>
           <th width="20%">Unit Price</th>
           <th width="20%">Total Price</th>
        </tr>
    </thead>
    <tbody>
    	@php 
    	$subTotal = '0';
    	@endphp
    @foreach($invoice->invoiceDetails as $key => $invoiceDetal)
      <tr>
    	<td>{{ $key+1 }}</td>
    	<!-- <td>{{ $invoiceDetal->category->name }}</td> -->
    	<td>{{ $invoiceDetal->product->name }}</td>
    	<td>{{ $invoiceDetal->selling_qty }}</td>
    	<td>{{ $invoiceDetal->unit_price }}</td>
    	<td>{{ $invoiceDetal->selling_price }}</td>
      </tr>
      @php
      $subTotal += $invoiceDetal->selling_price;
      @endphp
    @endforeach
    <tr>
    	<td colspan="4" style="text-align: right;">Sub Total:-</td>
    	<td>{{ $subTotal }}</td>
    </tr>
    <tr>
    	<td colspan="4" style="text-align: right;">Discount Amount:-</td>
    	<td>{{ $invoice->payment->discount_amount }}</td>
    </tr>
    <tr>
    	<td colspan="4" style="text-align: right;">VAT Amount:-</td>
    	<td>{{ $invoice->payment->vat_amount }}</td>
    </tr>
    <!-- <tr>
    	<td colspan="4" style="text-align: right;">Paid Amount:-</td>
    	<td>{{ $invoice->payment->paid_amount }}</td>
    </tr> -->
   <!--  <tr>
    	<td colspan="4" style="text-align: right;">Due Amount:-</td>
    	<td>{{ $invoice->payment->due_amount }}</td>
    </tr> -->
    <tr>
    	<td colspan="4" style="text-align: right;">Grant Total:-</td>
    	<td>{{ $invoice->payment->total_amount }}</td>
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
	Printing Time:- {{ $date->format('F j, Y, g:i a') }}
</strong>
<hr>
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
</body>
</html>