@extends('layouts.Backend.master')
@section('content')
<div class="row">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <a class="btn btn-info py-2 my-3" href="{{ route('products.view') }}">View Products
            </a>
            <div class="row">
               <!---- From Two Colum Start ---->
               <div class="col-sm-6">
                  <h1 class="m-0 text-dark">Upload Excel File</h1>
               </div>
            </div>
            <section class="content">
               <div class="container-fluid">
                  <!-- SELECT2 EXAMPLE -->
                  <div class="card card-default">
                     <div class="card-body">
                        <form class="form-horizontal" action="{{ route('products.uploadExcel') }}" method="post" enctype="multipart/form-data">
                           @csrf
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>File</label>
                                    <input type="file" class="form-control" name="attachment" id="attachment" required>
                                 </div>
                                 <div class="err" style="color: red"></div>
                              </div>
                              <div class="col-6">
                                 <input type="submit" value="Upload" class="btn btn-success float-right" onclick="checkfile()">
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </section>
            <!---- From Two Colum Start ---->
            <!-- </div> //End row  -->
            <!-- </form> -->
            <!---- From start ----> 
         </div>
      </div>
   </div>
</div>
@endsection