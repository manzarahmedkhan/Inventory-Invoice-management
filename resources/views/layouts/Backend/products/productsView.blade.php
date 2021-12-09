@extends('layouts.Backend.master')
@push('css')
<link href="{{ asset('assets/Backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
 <!-- Page Heading -->
          <a class="btn btn-success my-3" href="{{ route('products.add') }}"><i class="fa fa-plus-circle"></i>Add Product</a>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Products List</h6>
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
        });
</script>
@endsection
