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
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Admin</h4>
        </div>
        <div class="my-auto">
            <a href="{{ route('admin-list.create') }}">
                <button class="btn btn-info rounded-pill">Add Admin</button>
            </a>
        </div>
    </div>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">All Admin</h5>
        <div class="table-responsive text-nowrap p-4">
            <table class="table" id="DataTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @if ($admins->isNotEmpty())

                    @foreach ($admins as $key=> $data)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->getRoleNames()[0] }}</td>
                        <td>
                            <a href="{{ route('admin-list.edit', $data->id) }}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-pencil"></i></a>

                            <a href="{{ route('admin-list.destroy', $data->id) }}" onclick="event.preventDefault(); document.getElementById('admin-delete-form-{{ $key }}').submit();" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                                <form id="admin-delete-form-{{ $key }}" action="{{route('admin-list.destroy',$data->id)}}" method="POST"
                                    style="display: none;">
                                    @method('DELETE')
                                    @csrf
                                </form>
                            </a>                    
                        </td>
                    </tr>
                    @endforeach

                    @endif

                </tbody>
            </table>
            @if ($admins->hasPages())
                <div class="pagination-wrapper">
                    {{ $admins->links() }}
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
    });

</script>
@endsection
