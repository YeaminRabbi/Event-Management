@extends('layouts.adminpanel.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @if (\Session::has('success'))
    <div class="row">
        <div class="col-md-12">
            <div id="notificationAlert" style="display: block;">
                <div class="alert alert-warning">
                    <span style="color:black;">
                        {!! \Session::get('success') !!}
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="d-flex justify-content-between">
        <div>
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Payments</h4>
        </div>
        <div class="my-auto">
            <a href="{{ route('admin-list.create') }}">
                <button class="btn btn-info rounded-pill">All Payments</button>
            </a>
        </div>
    </div>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">All Payments</h5>
        <div class="table-responsive text-nowrap p-4">
            <table class="table" id="DataTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Participant</th>
                        <th>Event</th>
                        <th>Transaction ID</th>
                        <th>Amount Paid</th>
                        <th>Phone</th>
                        <th>Paid by</th>
                        {{-- <th>Status</th> --}}
                        <th>View</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if ($payments->isNotEmpty())

                    @foreach ($payments as $key=> $data)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $data->participant->user->name }}</td>
                        <td>{{ $data->event->name }}</td>
                        <td>{{ $data->transaction_id }}</td>
                        <td>{{ $data->amount }}</td>
                        <td>{{ $data->participant->user->phone }}</td>
                        <td>{{ $data->paid_by }}</td>
                        <td>
                            <a href="{{ url('admin/participants/'.$data->participant->user->id.'/?payment_id='.$data->id) }}" class="btn btn-primary " ><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                    @endforeach

                    @endif

                </tbody>
            </table>
            @if ($payments->hasPages())
                <div class="pagination-wrapper">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->



</div>
@endsection

@section('header_css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
@endsection

@section('footer_js')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script>
    $('#notificationAlert').delay(3000).fadeOut('slow');
    $(document).ready(function() {
        $('#DataTable').DataTable({
            "paging": false
        });
    } );

</script>
@endsection
