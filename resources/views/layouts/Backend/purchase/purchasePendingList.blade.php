@extends('layouts.Backend.master')
@push('css')
<link href="{{ asset('assets/Backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Purchase Pending List</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>SL.</th>
                      <th>Supplier Name</th>
                      <th>Item Code</th>
                      <th>Category Name</th>
                      <th>Description</th>
                      <th>Purchase No.</th>
                      <th>Date</th> 
                      <th>Quantity</th>
                      <th>Unit Price</th>
                      <th>Total Price</th>
                      <!-- <th>Description</th> -->
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($prachases as $key => $prachase)
                     <tr>
                       <td>{{ $key+1 }}</td>
                       <td>{{ $prachase->supplier->name }}</td>
                       <td>{{ $prachase['product']['code'] }}</td>
                       <td>{{ $prachase->category->name }}</td>
                       <td>{{ $prachase['product']['name'] }}</td>
                       <td>{{ $prachase->purchase_no }}</td>
                       <td>{{ date('d-m-Y', strtotime($prachase->date)) }}</td>
                       <td>
                        {{ $prachase->buying_qty }}
                        {{ $prachase->product->unit->name }}
                       </td>
                       <td>{{ $prachase->unit_price }}</td>
                       <td>{{ $prachase->buying_price }}</td>
                       <!-- <td>{{ $prachase->description }}</td> -->
                       <td>
                         @if($prachase->status == '0')
                         <span class="btn btn-danger">Pending</span>
                         @elseif($prachase->status == '1')
                         <span class="btn btn-success">Approved</span>
                         @endif
                       </td>
                       <td>
                       <a onclick="return confirm('Are you sure To Confirm This Purchase')" href="{{ route('purchase.approve', $prachase->id) }}" class="btn btn-success">Approve</a>
                      </td>
                     </tr>
                     @endforeach
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
