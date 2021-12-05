@extends('layouts.Backend.master')
@push('ajax')
<!-- Extra HTML for If exist Event -->
  <script id="document-template" type="text/x-handlebars-template">
    <tr class="delete_add_more_item" id="delete_add_more_item">
      <input type="hidden" name="date[]" value="@{{date}}">
      <input type="hidden" name="purchase_no[]" value="@{{purchase_no}}">
      <input type="hidden" name="supplier_id[]" value="@{{supplier_id}}">
      <input type="hidden" name="vat_percent[]" value="@{{vat_percent}}">
      <td align="center">
        <input type="hidden" name="product_id[]" value="@{{product_id}}">
        @{{product_code}}
      </td>
      <td>
        <input type="hidden" name="category_id[]" value="@{{category_id}}">
        @{{category_name}}
      </td>
      <td>
        <input type="hidden" name="product_name[]" value="@{{product_name}}">
        @{{product_name}}
      </td>
      <td>
        <input type="number" min="1" class="form-control form-control-sm text-right buying_qty" name="buying_qty[]"  value="1">
      </td> 
      <td>
        <input type="number" class="form-control form-control-sm text-right unit_price" name="unit_price[]"  value="" min="0" step=".01">
      </td>
      <td>
        <input type="number" class="form-control form-control-sm text-right vat_amount" name="vat_amount[]"  value="" min="0" step=".01" readonly>
      </td>
      <td>
        <input type="text" name="description[]" class="form-control form-control-sm">
      </td>
      <td>
        <input class="form-control form-control-sm text-right buying_price" name="buying_price[]"  value="0" readonly>
      </td>
      <td><i class="btn btn-danger btn-sm fa fa-window-close removeeventmore"></i></td>
    </tr>
  </script>
  
  <!-- extra_add_exist_item -->
  <script type="text/javascript">
    $(document).ready(function () {
      //HandleBar Template
      var vat_percent = 15;
      $(document).on("click",".addeventmore", function () {
        var date          = $('#date').val();
        var purchase_no   = $('#purchase_no').val();
        var supplier_id   = $('#supplier_id').val();
        // var category_id   = $('#category_id').val();
        // var category_name = $('#category_id').find('option:selected').text();
        // var product_name  = $('#product_id').find('option:selected').text();
        var product_code  = $('#product_code').val();
        var category_id   = $('#supplier_id').find('option:selected').attr('category_id');
        var category_name = $('#supplier_id').find('option:selected').attr('category_name');
        var product_id    = $('#supplier_id').find('option:selected').attr('product_id');
        var product_name  = $('#supplier_id').find('option:selected').attr('product_name');
        // validation
        if(date==''){
          $.notify("Date is required", {globalPosition: 'top right',className: 'error'});
          return false;
        }
        if(purchase_no==''){
          $.notify("Purchase no is required", {globalPosition: 'top right',className: 'error'});
          return false;
        }
        if(product_code==''){
          $.notify("Item Code is required", {globalPosition: 'top right',className: 'error'});
          return false;
        }
        if(supplier_id==''){
          $.notify("Supplier is required", {globalPosition: 'top right',className: 'error'});
          return false;
        }
        // if(category_id==''){
        // $.notify("Category is required", {globalPosition: 'top right',className: 'error'});
        // return false;
        // }
        var source   = $("#document-template").html();
        var template = Handlebars.compile(source);
        var data= {
                  date:date,
                  purchase_no:purchase_no,
                  supplier_id:supplier_id,
                  category_id:category_id,
                  category_name:category_name,
                  product_id:product_id,
                  product_code:product_code,
                  product_name:product_name,
                  vat_percent:vat_percent
            };
        var html = template(data);
        $("#addRow").append(html);
      });
      // Remove Handlebar
      $(document).on("click", ".removeeventmore", function(event) {
        $(this).closest(".delete_add_more_item").remove();
        totalAmountPrice();     
      });
      // Handlebar Multificaion
      $(document).on('keyup','.unit_price,.buying_qty',function(evtobj){
        if (!(evtobj.altKey || evtobj.ctrlKey || evtobj.shiftKey)){
           if (evtobj.keyCode == 16) {return false;}
           if (evtobj.keyCode == 17) {return false;}
           // $("body").append(evtobj.keyCode + " ");
        }
        var unit_price = $(this).closest("tr").find("input.unit_price").val();
        var qty        = $(this).closest("tr").find("input.buying_qty").val();
        var total      = unit_price * qty;
        var vat = parseFloat((total*vat_percent)/100);
        var sum = parseFloat(total + vat);
        $(this).closest("tr").find("input.vat_amount").val(vat.toFixed(2));
        $(this).closest("tr").find("input.buying_price").val(sum.toFixed(2));
        totalAmountPrice();
      });
      //calculate sum of amount in invoice
      function totalAmountPrice(){
        var sum=0;
        $(".buying_price").each(function(){
          var value = $(this).val();              
          if(!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);             
          }
        });
        $('#estimated_amount').val(sum.toFixed(2));
      }
    });
  </script>
<!---- Ajax Request By Supplier --->
<script type="text/javascript">
  $(function(){
    // $(document).on('change','#supplier_id',function(){
    //    var supplier_id = $(this).val();
    //    $.ajax({
    //     url:"{{ route('get.category') }}",
    //     type:"GET",
    //     data:{supplier_id:supplier_id},
    //     success:function(data){
    //       var html = '<option value="">Select Category</option>';
    //       $.each(data,function(key,v){
    //         html +='<option value="'+v.category_id+'">'+v.category.name+'</option>';
    //       });
    //       $('#category_id').html(html);
    //     }
    //    });
    // });

    //get supplier and product details by product code
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
              $('.supplier_input').show();
              $('.supplier_select').hide();
            }else{
              $('.supplier_select').show();
              $('.supplier_input').hide();
            }
            html +='<option value="'+v.supplier.id+'" product_id="'+v.id+'" product_name="'+v.name+'" category_id="'+v.category.id+'" category_name="'+v.category.name+'"'+selected+'>'+v.supplier.name+'</option>';
          $('#category_name').val(v.category.name);
          $('#product_description').val(v.name);
          });
          $('#supplier_id').html(html);
        }
       });
    });

    $(document).on('keyup','#purchase_no',function(evtobj){
      if (!(evtobj.altKey || evtobj.ctrlKey || evtobj.shiftKey)){
         if (evtobj.keyCode == 16) {return false;}
         if (evtobj.keyCode == 17) {return false;}
         // $("body").append(evtobj.keyCode + " ");
      }
      var supplier_id = $('#supplier_id').val();
      var purchase_no = $(this).val();
      $.ajax({
        url:"{{ route('purchase.checkPurchaseNo') }}",
        type:"GET",
         data:{
                purchase_no:purchase_no,
                supplier_id:supplier_id
              },
        success:function(response){
            if(response == 1){
             $.notify("Product Number Already Exists for this Supplier",{globalPosition:'top right',className:'error'});
             return false;
           }else{
              return true;
           }
          }
       });
    });

    $(document).on('change','#supplier_id',function(){
      var category_name = $(this).find('option:selected').attr('category_name');
      var product_description = $(this).find('option:selected').attr('product_name');
      var supplier_id = $(this).val();
      var purchase_no = $('#purchase_no').val();
      $('#category_name').val(category_name);
      $('#product_description').val(product_description);
      $.ajax({
          url:"{{ route('purchase.checkPurchaseNo') }}",
          type:"GET",
          data:{
                purchase_no:purchase_no,
                supplier_id:supplier_id
              },
          success:function(response){
            if(response == 1){
             $.notify("Product Number Already Exists for this Supplier",{globalPosition:'top right',className:'error'});
             return false;
           }else{
              return true;
           }
          }
       });
    });
    //get product details by supplier
    // $(document).on('change','#supplier_id',function(){
    //    var supplier_id = $(this).val();
    //    $.ajax({
    //     url:"{{ route('get.productCode') }}",
    //     type:"GET",
    //     data:{supplier_id:supplier_id},
    //     success:function(data){
    //       var html = '<option value="">Select Product Code</option>';
    //       $.each(data,function(key,v){
    //         html +='<option value="'+v.id+'" product_name="'+v.name+'" category_id="'+v.category_id+'" category_name="'+v.category.name+'">'+v.code+'</option>';
    //       });
    //       $('#product_id').html(html);
    //     }
    //    });
    // });

  });
</script>
<!---- Ajax Request By Category --->
<script type="text/javascript">
  $(function(){
    $(document).on('change','#category_id',function(){
       var category_id = $(this).val();
       $.ajax({
        url:"{{ route('get.product') }}",
        type:"GET",
        data:{category_id,category_id},
        success:function(data){
          var html = '<option value="">Select Products</option>';
          $.each(data,function(key,v){
             html+='<option value="'+v.id+'">'+v.name+'</option>';
          });
          $('#product_id').html(html);
        }
       });
    });
  });
</script>
@endpush
@section('content')
<div class="row">
    <div class="col-lg-12">
       <div class="card">
            <div class="card-body">
                  <a class="btn btn-info py-2 my-3" href="{{ route('purchase.view') }}">View Purchase
                  </a>
                  <!---- From start ---->
                      <div class="row">
                        <!---- From Two Colum Start ---->
                                  <div class="col-lg-3">
                                       <div class="form-group">
                                          <label>Date</label>
                                          <input type="date" name="date" id="date" class="form-control form-control-sm" value="{{date('Y-m-d')}}">
                                       </div> 
                                  </div>
                                 <div class="col-lg-3">
                                       <div class="form-group">
                                          <label>Purchase No.</label>
                                          <input type="text" name="purchase_no" id="purchase_no" class="form-control form-control-sm">
                                       </div> 
                                  </div>
                        <!---- From Two Colum Start ---->

                        <!---- From Two Colum Start ---->
                                  <div class="col-lg-3">
                                        <div class="form-group">
                                          <label>Item Code</label>
                                          <input type="text" name="product_code" id="product_code" class="form-control form-control-sm">
                                          </select>   
                                       </div> 
                                  </div>
                                  <div class="col-lg-3">
                                       <div class="form-group">
                                          <label>Supplier Name</label>
                                          <input type="text" name="supplier_input" id="supplier_input" class="form-control form-control-sm supplier_input" readonly="" style="display: none;" >
                                          <span class="supplier_select">
                                          <select name="supplier_id" class="form-control select2" id="supplier_id">
                                            <option value="">
                                            *Select Supplier* 
                                          </select> 
                                          </span>
                                           @error('supplier_id')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                                  <div class="col-lg-3">
                                        <div class="form-group">
                                          <label>Category</label>
                                          <input type="text" name="category_name" id="category_name" class="form-control form-control-sm" readonly="">
                                          </select>   
                                       </div> 
                                  </div>
                                  <div class="col-lg-3">
                                        <div class="form-group">
                                          <label>Description</label>
                                          <input type="text" name="product_description" id="product_description" class="form-control form-control-sm" readonly="">
                                          </select>   
                                       </div> 
                                  </div>
                                  <!-- <div class="col-lg-3">
                                  </div> -->
                                 <!--  <div class="col-lg-6">
                                        <div class="form-group">
                                          <label>Category</label>
                                          <select name="category_id" class="form-control select2" id="category_id">
                                            <option value="">
                                            *Select Category* 
                                          </select>   
                                       </div> 
                                  </div> -->
                        <!---- From Two Colum Start ---->

                                 <div class="col-lg-3">
                                        <div class="form-group">
                                          <a id="Add_more" style="margin-top: 27px;" class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i>Add More</a>
                                       </div> 
                                 </div>

                    </div><!--End row -->
            </div>
       </div> 
       <!------ Show Purchase Filed Value start ------>
        <div class="card my-4">
          <div class="card-body">
            <form method="post" action="{{ route('purchase.store') }}" id="myForm">
               @csrf
               <table class="table-sm table-bordered" width="100%">
                    <thead>
                      <tr>
                        <th>Item Code</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th width="7%">Pcs/Kg</th>
                        <th width="10%">Unit Price</th>
                        <th width="10%">VAT (15%)</th>
                        <th>Comment</th>
                        <th width="10%">Total Price</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody id="addRow" class="addRow">
                      
                    </tbody>
                    <tbody>
                        <td colspan="7"></td>
                        <td>
                          <input type="text" name="estimated_amount" value="0" id="estimated_amount" class="form-control form-control-sm text-right estimated_amount" readonly style="background-color: #D8FDBA">
                        </td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                  <br>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="storeButton">Purchase Store</button>
                  </div>
            </form>
          </div>
        </div>
       <!------ Show Purchase Filed Value start ------>         
    </div>
</div>
@endsection
