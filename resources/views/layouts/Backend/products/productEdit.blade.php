@extends('layouts.Backend.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
       <div class="card">
            <div class="card-body">
                  <a class="btn btn-info py-2 my-3" href="{{ route('products.view') }}">View Products
                  </a>
                  <!---- From start ---->
                  <form class="form" id="myForm" action="{{ route('products.update', $products->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="row">
                        <!---- From Two Colum Start ---->
                                  <div class="col-lg-6">
                                       <div class="form-group">
                                          <label>Supplier Name</label>
                                          <select name="supplier_id" id="supplier_id" class="form-control select2">
                                            <option value="">
                                            *Select Supplier*
                                            </option>
                                            @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                              {{ ($products->supplier_id == $supplier->id)?'selected':'' }}>
                                              {{ $supplier->name }}
                                            </option>
                                            @endforeach
                                          </select>
                                           @error('supplier_id')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                                 <div class="col-lg-6">
                                       <div class="form-group">
                                          <label>Product Unit</label>
                                          <select name="unit_id" class="form-control select2">
                                            <option value="">
                                            *Select Unit*
                                            </option>
                                            @foreach($units as $unit)
                                            <option value="{{ $unit->id }}"
                                              {{ ($products->unit_id == $unit->id)?'selected':'' }}>
                                              {{ $unit->name }}
                                            </option>
                                            @endforeach
                                          </select>
                                           @error('unit_id')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                        <!---- From Two Colum Start ---->

                        <!---- From Two Colum Start ---->
                                  <div class="col-lg-6">
                                       <div class="form-group">
                                          <label>Category</label>
                                          <select name="category_id" class="form-control select2">
                                            <option value="">
                                            *Select Categories*
                                            </option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                              {{ ($products->category_id == $category->id)?'selected':'' }}>
                                              {{ $category->name }}
                                            </option>
                                            @endforeach
                                          </select>
                                           @error('category_id')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                                  <div class="col-lg-6">
                                        <div class="form-group">
                                          <label>Item Code</label>
                                          <input type="hidden" name="previous_code" id="previous_code" value="{{$products->code}}">
                                           <input type="text" name="code" id="code" class="form-control form-control-sm @error('code') Invalid @enderror" value="{{ $products->code }}">
                                           @error('code')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                                  <div class="col-lg-6">
                                        <div class="form-group">
                                          <label>Description</label>
                                           <input type="text" name="product_name" class="form-control form-control-sm @error('product_name') Invalid @enderror" value="{{ $products->name }}">
                                           @error('product_name')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                        <!---- From Two Colum Start ---->
                    </div><!--End row -->
                      <!-- Submit Button start -->
                      <div class="form-group">
                         <input type="button" name="send" class="form-control btn btn-info btn-block" value="Submit" onclick="submitForm()">
                      </div>
                     <!-- Submit Button end -->  
                  </form>
                  <!---- From start ----> 
            </div>
       </div>          
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function(){  
  $(document).on('keyup', '#code', function (evtobj) {
    if (!(evtobj.altKey || evtobj.ctrlKey || evtobj.shiftKey)){
       if (evtobj.keyCode == 16) {return false;}
       if (evtobj.keyCode == 17) {return false;}
       // $("body").append(evtobj.keyCode + " ");
    }
    var token = $('[name="_token"]').val();
    var supplier_id = $('[name="supplier_id"]').val();
    var previous_code = $('#previous_code').val();
    var ref = $(this);  
    var code = ref.val(); 
    $.ajax({
        url: "{{ route('products.checkCodeExists') }}",
        data: {
           '_token': token,
           'code'  : code,
           'supplier_id'  : supplier_id,
           'previous_code':previous_code
        },
        type: 'GET',
        success: function(response) {
           if(response == 1){
             $.notify("Item Code Already Exists for this Supplier",{globalPosition:'top right',className:'error'});
             return false;
           }else{
              return true;
           }
        }
    });
  });
});


  function submitForm(){
    var token = $('[name="_token"]').val();
    var supplier_id = $('[name="supplier_id"]').val();
    var previous_code = $('#previous_code').val();
    var code = $('#code').val();
    $.ajax({
        url: "{{ route('products.checkCodeExists') }}",
        data: {
           '_token': token,
           'code'  : code,
           'supplier_id'  : supplier_id,
           'previous_code' : previous_code
        },
        type: 'GET',
        success: function(response) {
           if(response == 1){
             $.notify("Item Code Already Exists for this Supplier",{globalPosition:'top right',className:'error'});
             return false;
           }else{
              $('#myForm').submit();
           }
        }
    });
  }
</script>
@endsection