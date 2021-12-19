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
<div class="card shadow mb-4">
   <div class="card-header py-3">
      <h4 class=" font-weight-bold text-primary"  style="float: left;">Products List</h4>
      <a class="btn btn-success" href="{{ route('products.add') }}" style="float: right;"><i class="fa fa-plus-circle"></i>Add Product</a>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
   var url = "{{ route('products.fetchProducts') }}";
   $('#dataTable').DataTable({
           processing: true,
           serverSide: true,
           scrollX: true,
           dom: 'Bfrtip',
           buttons: [{
             extend: 'excel',
             text: 'Export to excel',
           }],
           ajax: url,
           dom: 'Bflrtip',
            buttons: [
              {
              extend: 'excel',
              className: "btn btn-success fas fa-file-excel",
              title:'Products',
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
                 title:'Products',
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
</script>
@endsection