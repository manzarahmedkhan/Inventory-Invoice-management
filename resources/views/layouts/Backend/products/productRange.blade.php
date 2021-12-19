@extends('layouts.Backend.master')
@push('css')
<link href="{{ asset('assets/Backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
<style type="text/css">
.dataTables_filter {
   margin-top: -2rem;
}
.dataTables_length{
   margin-top: -2rem;
   text-align: center;
}
</style>
<div class="row">
   <div class="col-lg-12">
      <div class="card">
         <div class="card-body">
            <h4 class="py-2 mb-4 text-primary">Search Products With Code Range
            </h4>
            <!---- From start ---->
            <form>
               <div class="row">
                  <!---- From Colum Start ---->
                  <div class="col-lg-3">
                     <div class="form-group">
                        <label>From Code</label>
                        <input type="text" name="start_code" id="start_code" class="form-control form-control-sm">
                        @error('start_code')
                        <strong class="alert alert-danger">{{ $message }}
                        </strong>
                        @enderror
                     </div>
                  </div>
                  <div class="col-lg-3">
                     <div class="form-group">
                        <label>To Code</label>
                        <input type="text" name="end_code" id="end_code" class="form-control form-control-sm">
                        @error('end_code')
                        <strong class="alert alert-danger">{{ $message }}
                        </strong>
                        @enderror
                     </div>
                  </div>
                  <div class="col-lg-2">
                     <input type="button" name="submit" class="btn btn-primary mt-4" value="Search" onclick="fetchProductRange()">
                  </div>
               </div>
               <!--End row -->
            </form>
            <div class="table-responsive" style="display:none;">
               <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                  <thead>
                     <tr>
                        <!-- <th>SL.</th> -->
                        <th>Supplier Name</th>
                        <th>Code</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Stock</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('js')
<!-- Page level plugins -->
<script src="{{ asset('assets/Backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/Backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Excel pdf buttons -->
<script src="{{ asset('assets/Backend/vendor/datatables/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/Backend/vendor/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/Backend/vendor/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/Backend/vendor/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/Backend/vendor/datatables/buttons.html5.min.js') }}"></script>
<!-- Page level custom scripts -->
<script src="{{ asset('assets/Backend/js/demo/datatables-demo.js') }}"></script>
@endpush
@section('js')
<script type="text/javascript">
   var url = "{{ route('products.fetchProductRange') }}";
   function fetchProductRange(){
   $('.table-responsive').show();  
   var start_code = $('#start_code').val();
   var end_code   = $('#end_code').val();
   if(!start_code || !end_code){
       alert('From Code and To Code fields are required!');
       return false;
   }
     $('#dataTable1').DataTable({
       destroy: true,
       processing: true,
       serverSide: true,
       scrollX: true,
       dom: 'Bflrtip',
       buttons: [
         {
            extend: 'excel',
            className: "btn btn-success fas fa-file-excel",
            title:'Products Code From '+start_code+' - '+end_code,
            action:newexportaction,
            exportOptions: {
               columns: ':not(:last-child)',
               modifier: {
                  search: 'applied',
                  order: 'applied'  
               },
            }
         },
         {
            extend: 'pdf',
            className: "btn btn-secondary fas fa-file-pdf",
            title:'Products Code From '+start_code+' - '+end_code,
            action:newexportaction,      
            exportOptions: {
               columns: ':not(:last-child)',
               modifier: {
                  search: 'applied',
                  order: 'applied'  
               },
            }
         }
      ],
       "ajax": {
           url: url,
           type:'post',
           data: {
            "_token": '{{ csrf_token() }}',
            "start_code": start_code,
            "end_code": end_code,
           },
       },
       columns: [{
           data: 'supplier',
           name: 'suppliers.name',
         }, {
           data: 'code',
           name: 'code',
         },
         {
           data: 'category',
           name: 'categories.name',
         },{
           data: 'product_name',
           name: 'products.name',
         },
         {
           data: 'stock',
           name: 'units.name',
         },
         {
           data: 'action',
           name: 'action',
           orderable: false,
           searchable: false,
           width: 100
         },
       ],
       order:[1,'asc'],
     });
   }  
</script>
@endsection