@extends('layouts.Backend.master')
@section('content')
<div class="row">
    <div class="col-lg-12">
       <div class="card">
            <div class="card-body">
                  <a class="btn btn-info py-2 my-3" href="{{ route('customer.view') }}">View Customers
                  </a>
                  <!---- From start ---->
                  <form class="form" action="{{ route('customer.update', $customerEdit->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                      <div class="row">
                        <!---- From Two Colum Start ---->
                                  <div class="col-lg-6">
                                       <div class="form-group">
                                          <label>Name</label>
                                           <input type="text" name="name" class="form-control @error('name') Invalid @enderror" value="{{ $customerEdit->name }}">
                                           @error('name')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                                  <div class="col-lg-6">
                                        <div class="form-group">
                                          <label>Mobile</label>
                                           <input type="number" name="mobile" class="form-control @error('mobile') Invalid @enderror" value="{{ $customerEdit->mobile }}">
                                           @error('mobile')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                        <!---- From Two Colum Start ---->

                        <!---- From Two Colum Start ---->
                                  <div class="col-lg-6">
                                       <div class="form-group">
                                          <label>Email</label>
                                           <input type="email" name="email" class="form-control @error('email') Invalid @enderror" value="{{ $customerEdit->email }}">
                                           @error('email')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                                  <div class="col-lg-6">
                                        <div class="form-group">
                                          <label>Address</label>
                                           <input type="text" name="address" class="form-control @error('address') Invalid @enderror" value="{{ $customerEdit->address }}">
                                           @error('address')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                                  <div class="col-lg-6">
                                        <div class="form-group">
                                          <label>Vat No</label>
                                           <input type="text" name="vat_no" class="form-control @error('vat_no') Invalid @enderror" value="{{ $customerEdit->vat_no }}">
                                           @error('vat_no')
                                           <strong class="alert alert-danger">{{ $message }}
                                           </strong>
                                          @enderror
                                       </div> 
                                  </div>
                        <!---- From Two Colum Start ---->
                    </div><!--End row -->
                      <!-- Submit Button start -->
                      <div class="form-group">
                         <input type="submit" name="submit" class="form-control btn btn-dark btn-block">
                      </div>
                     <!-- Submit Button end -->  
                  </form>
                  <!---- From start ----> 
            </div>
       </div>          
    </div>
</div>
@endsection