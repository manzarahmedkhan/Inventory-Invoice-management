@extends('layouts.Backend.master')
@push('ajax')
<!-- Extra HTML for If exist Event -->
  <script id="document-template" type="text/x-handlebars-template">
    <tr class="delete_add_more_item" id="delete_add_more_item">
      <input type="hidden" name="date" value="@{{date}}">
      <input type="hidden" name="invoice_no" value="@{{invoice_no}}">
      <input type="hidden" name="vat_percent" value="@{{vat_percent}}">
      <td>
        <input type="hidden" name="product_code[]" value="@{{product_code}}">
        @{{product_code}}
      </td>
      <td>
        <input type="hidden" name="product_name[]" value="@{{product_name}}">
        @{{product_name}}
      </td>
      <td>
        <input type="number" min="0" class="form-control form-control-sm text-right selling_qty" name="selling_qty[]"  value="1">
      </td> 
      <td>
        <input type="number" class="form-control form-control-sm text-right unit_price" name="unit_price[]" min="0" value="">
      </td>
      <td>
        <input class="form-control form-control-sm text-right selling_price" name="selling_price[]"  value="0" readonly>
      </td>
      <td><i class="btn btn-danger btn-sm fa fa-window-close removeeventmore"></i></td>
    </tr>
  </script>
<script type="text/javascript">
  $(document).ready(function(){
    var vat_percent = 0;
     $(document).on('click','.addMore', function(){
        var date = $('#date').val();
        var invoice_no = $('#invoice_no').val();
        var product_code  = $('#product_code').val();
        var product_name  = $('#product_description').val();
         // validation
        if(date==''){
          $.notify("Date is required", {globalPosition: 'top right',className: 'error'});
          return false;
        }
        if(product_code==''){
          $.notify("Item Code is required", {globalPosition: 'top right',className: 'error'});
          return false;
        }
        var source   = $('#document-template').html();
        var template = Handlebars.compile(source);
        var data     = {
          date:date,
          invoice_no:invoice_no,
          product_code:product_code,
          product_name:product_name,
          vat_percent:vat_percent
        };
        var html = template(data);
        $('#addRow').append(html);
         });
        // Remove Handlebar
        $(document).on('click', '.removeeventmore', function(event){
            $(this).closest(".delete_add_more_item").remove();
            totalAmountPrice();
        });
        // Handlebar Multificaion
        $(document).on('keyup click', '.unit_price,.selling_qty', function(e){
           if ($(this).val() < 0) {  
               $(this).closest("tr").find("input.unit_price").val('');
               $('.unit_price').trigger('keyup');
               return false;
           }
           var unit_price = $(this).closest("tr").find("input.unit_price").val();
           var selling_qty = $(this).closest("tr").find("input.selling_qty").val();
           var total = unit_price*selling_qty;
           $(this).closest("tr").find("input.selling_price").val(total.toFixed(2));
           // Discount
           $('#discount_amount').trigger('keyup');   
        });
        // Discount Script
        $(document).on('keyup','#discount_amount', function(){
          totalAmountPrice();
        });
        //calculate sum of amount in invoice
        function totalAmountPrice(){
          var sum = 0;
          // sum
          $('.selling_price').each(function(){
             var value = $(this).val();
             if(!isNaN(value) && value.length != 0) {
             sum += parseFloat(value);             
          }
          });
        // Discount and Vat
        var discount_amount = parseFloat($('#discount_amount').val());
        if(!isNaN(discount_amount) && discount_amount.length != 0) {
          sum -= parseFloat(discount_amount);
        }
          var vat = parseFloat((sum*vat_percent)/100);
          var sum = parseFloat(sum + vat);
          $('#vat_amount').val(vat.toFixed(2));
          $('#estimated_amount').val(sum.toFixed(2));
      }
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){

    //get supplier and product details by Item Code
    $(document).on('keyup','#product_code',function(evtobj){
      if (!(evtobj.altKey || evtobj.ctrlKey || evtobj.shiftKey)){
         if (evtobj.keyCode == 16) {return false;}
         if (evtobj.keyCode == 17) {return false;}
         // $("body").append(evtobj.keyCode + " ");
      }
      var selected = "";
      $('.supplier_input').val('');
      $('#category_name').val('');
      $('#product_description').val('');
      $('#stock').val('');
      var code = $(this).val();
      $.ajax({
        url:"{{ route('get.supplier') }}",
        type:"GET",
        data:{code:code},
        success:function(data){
          var dataCount = Object.keys(data).length;
          var html = '<option value="">Select Supplier</option>';
          $.each(data,function(key,v){
            if(dataCount == 1){
              var selected = "selected";
              $('.supplier_input').val(v.supplier.name);
              $('#stock').val(v.quantity);
              $('.supplier_input').show();
              $('.supplier_select').hide();
            }else{
              $('.supplier_select').show();
              $('.supplier_input').hide();
            }
            html +='<option value="'+v.supplier.id+'" product_id="'+v.id+'" product_name="'+v.name+'" category_id="'+v.category.id+'" category_name="'+v.category.name+'" stock="'+v.quantity+'" '+selected+'>'+v.supplier.name+'</option>';
          $('#category_name').val(v.category.name);
          $('#product_description').val(v.name);
          });
          $('#supplier_id').html(html);
        }
       });
    });

    $(document).on('change','#supplier_id',function(){
      var category_name = $(this).find('option:selected').attr('category_name');
      var product_description = $(this).find('option:selected').attr('product_name');
      var stock = $(this).find('option:selected').attr('stock');
      $('#category_name').val(category_name);
      $('#product_description').val(product_description);
      $('#stock').val(stock);
    });

    // Paid Status //
     $(document).on('change','#paid_status', function(){
        var paid_status = $(this).val();
        if(paid_status == 'Partical_paid') {
           $('.paid_amount').show();
        } else{
          $('.paid_amount').hide();
        }
     });
     // New Customer //
     $(document).on('change','#customer', function(){
        var customer = $(this).val();
        if(customer == '0') {
          $('.newCustomer').show();
        } else{
          $('.newCustomer').hide();
        }
     });
  });
</script>
@endpush
@section('content')
<div class="row">
    <div class="col-lg-12">
       <div class="card">
            <div class="card-body">
                  <a class="btn btn-info py-2 mb-4" href="{{ route('manualBills.print.list') }}">View Invoice
                  </a>
                  <!---- From start ---->
                      <div class="row">
                        <!---- From Colum Start ---->
                                  <div class="col-lg-2">
                                      <div class="form-group">
                                        <label>Invoice No.</label>
                                        <input type="text" name="invoice_no" id="invoice_no" class="form-control form-control-sm" readonly style="background-color: #D8FDBA;" value="{{ sprintf("%05d", $invoiceData) }}">
                                      </div> 
                                  </div>

                                  <div class="col-lg-2">
                                      <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" name="date" id="date" class="form-control form-control-sm" value="{{date('Y-m-d')}}">
                                      </div> 
                                  </div>
                                  <div class="col-lg-2">
                                        <div class="form-group">
                                          <label>Item Code</label>
                                          <input type="text" name="product_code" id="product_code" class="form-control form-control-sm">
                                          </select>   
                                       </div> 
                                  </div>
                                <div class="col-lg-5">
                                  <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" name="product_description" id="product_description" class="form-control form-control-sm">
                                    </select>   
                                 </div> 
                                </div>
                                <div class="col-lg-1">
                                  <div class="form-group">
                                    <a name="addMore" id="addMore" class="btn btn-primary mt-4 text-white addMore">
                                      ADD
                                    </a>
                                  </div> 
                                </div>

                    </div><!--End row -->
            </div>
       </div> 
       <!------ Show Purchase Filed Value start ------>
        <div class="card my-4">
          <div class="card-body">
            <form method="post" action="{{ route('manualBills.store') }}" id="myForm">
               @csrf
               <table class="table-sm table-bordered" width="100%">
                    <thead>
                      <tr>
                        <th width="12%">Item Code</th>
                        <!-- <th>Category</th> -->
                        <th>Description</th>
                        <th width="7%">Pcs/Kg</th>
                        <th width="10%">Unit Price</th>
                        <th width="15%">Total Price</th>
                        <th width="">Action</th>
                      </tr>
                    </thead>
                    <tbody id="addRow" class="addRow">
                      
                    </tbody>
                    <tbody>
                      <tr>
                        <td colspan="4">Discount Amount</td>
                        <td>
                          <input type="number" name="discount_amount" id="discount_amount" class="form-control text-right" placeholder="Write Discount Amount">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4">VAT Amount</td>
                        <td>
                          <input type="text" name="vat_amount" value="0" id="vat_amount" class="form-control form-control-sm text-right vat_amount" readonly style="background-color: #D8FDBA">
                        </td>
                      </tr>
                    </tbody>
                    <tbody>
                      <tr>
                        <td colspan="4"></td>
                        <td>
                          <input type="text" name="estimated_amount" value="0" id="estimated_amount" class="form-control form-control-sm text-right estimated_amount" readonly style="background-color: #D8FDBA">
                        </td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                  <br>
                <!---- Description Field start ---->
                <div class="form-row">
                  <div class="col-lg-12">
                    <textarea class="form-control" rows="3" placeholder="Write Something About Invoice" name="description" id="description"></textarea>
                  </div>
                </div>
                <!---- Description Field End ---->
                <br>
                <!---- Three Colum Field start ---->
                <div class="form-row">
                  <!-- Paind Status Filed Start -->
                  <div class="col-lg-5">
                   <div class="form-group">
                     <label><strong>Paid Status</strong></label>
                     <select name="paid_status" class="form-control form-control-sm" id="paid_status">
                       <option value="">*Select Paid status*</option>
                       <option value="full_paid" selected>Full Paid</option>
                       <!-- <option value="full_due">Full Due</option> -->
                       <!-- <option id="Partical_paid" value="Partical_paid">Partical Paid</option> -->
                     </select>
                     <!--- After Partical Paid --->
                     <br>
                     <input type="text" name="paid_amount" class="form-control paid_amount" placeholder="Write Partical Amount" style="display: none;"> 
                   </div>
                  </div>
                  <!-- Paind Status Filed Start -->

                 <!-- Customer Filed Start -->
                  <div class="col-lg-7">
                   <div class="form-group">
                      <label><strong>Customer Details</strong></label>
                       <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" value="CASH">
                       <br>
                       <input type="number" name="customer_mobile" class="form-control" placeholder="Customer Mobile">
                     <!--- After New Customer End ---> 
                   </div>
                  </div>
                 <!-- Customer Filed End -->
                </div><!-- end row -->
                <!---- Three Colum End ---->

                <br>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="storeButton">Invoice Store</button>
                  </div>
            </form>
          </div>
        </div>
       <!------ Show Purchase Filed Value start ------>         
    </div>
</div>
@endsection
