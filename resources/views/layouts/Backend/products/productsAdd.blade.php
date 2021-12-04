@extends('layouts.Backend.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
       <div class="card">
            <div class="card-body">
                  <a class="btn btn-info py-2 my-3" href="{{ route('products.view') }}">View Products
                  </a>
                  <!---- From start ---->
                  <form class="form" id="myForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="row">
                        <!---- From Two Colum Start ---->
                                  <div class="col-lg-6">
                                       <div class="form-group">
                                          <label>Company Name</label>
                                          <select name="supplier_id" class="form-control select2">
                                            <option value="">
                                            *Select Company*
                                            </option>
                                            @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" @if($supplier->id == old('supplier_id')) selected @endif>
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
                                            <option value="{{ $unit->id }}" @if($unit->id == old('unit_id')) selected @endif>
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
                                          <label>Product Category</label>
                                          <select name="category_id" class="form-control select2">
                                            <option value="">
                                            *Select Categories*
                                            </option>
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @if($category->id == old('category_id')) selected @endif>
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
                                  <input type="hidden" id="checkCode" value="0">
                                  <div class="col-lg-6">
                                        <div class="form-group">
                                          <label>Product Code</label>
                                           <input type="text" name="code" id="code" class="form-control @error('code') Invalid @enderror form-control-sm" value="{{ $lastCode }}" >
                                           @error('code')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                                  <div class="col-lg-6">
                                        <div class="form-group validate">
                                          <label>Product Description</label>
                                           <input type="text" name="product_name" class="form-control @error('product_name') Invalid @enderror form-control-sm" value="{{ old('product_name') }}" >
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
    var ref = $(this);  
    var code = ref.val(); 
    $.ajax({
        url: "checkCodeExists",
        data: {
           '_token': token,
           'code'  : code
        },
        type: 'POST',
        success: function(response) {
           if(response == 1){
             $('#checkCode').val(1);
             $.notify("Product Code Already Exists",{globalPosition:'top right',className:'error'});
             return false;
           }else{
              $('#checkCode').val(0);
           }
        }
    });
  });
});


  function submitForm(){
    var checkCode = $('#checkCode').val();
    if (checkCode == 1) {
        $.notify("Product Code Already Exists",{globalPosition:'top right',className:'error'});
    }else{
      $('#myForm').submit();
    }
  }
</script>
@endsection