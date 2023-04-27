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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Participants /</span> list</h4>
            </div>
            <div class="my-auto">
                <a href="{{ route('events.create') }}">
                    <button class="btn btn-info rounded-pill">Add Events</button>
                </a>
                <a href="{{ route('events.index') }}">
                    <button class="btn btn-dark rounded-pill">Back to Events</button>
                </a>
            </div>

        </div>
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">Participants List</h5>
            <div class="table-responsive text-nowrap p-4">
                <table class="table" id="DataTable">
                    <thead>
                        <tr>
                            <th>sl</th>
                            <th>Name, email, phone</th>
                            {{-- <th>selected fees</th> --}}
                            <th>
                                <p class=" p-0 m-0">Payable amount</p>
                                <hr class="p-0 m-0">
                                <p class=" p-0 m-0">selected fees</p>
                            </th>
                            <th>Last Payment</th>
                            <th>Registration</th>
                            {{-- <th>status</th>
                            <th>patricipants</th> --}}
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($participants as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>

                                <td>
                                    <strong>{{ $item->user->name ?? '' }}</strong> <br>
                                    <span>{{ $item->user->email }}</span><br>
                                    <span style="color: gray">{{ $item->user->phone ?? '01xxxxxxxxx' }}</span>

                                </td>
                                <td width="500">
                                    <strong>{{ $item->payable_amount }}/-</strong> <br>
                                    @if (empty($item->selected_fee))
                                        <span class="badge bg-label-warning me-1">empty</span>
                                    @else
                                    <div class="d-flex flex-wrap">
                                        @foreach ($item->selected_fee as $key => $data)
                                        <span class="badge bg-label-primary me-1 mb-1">{{ $data }}</span>
                                        @endforeach
                                    </div>
                                    @endif
                                </td>


                                

                                {{-- <td>{{ $item->payable_amount }} </td> --}}

                                <td>
                                    {{-- {{ $item->payments->isEmpty() }} --}}

                                    @if ($item->payments->isEmpty())
                                        <span class="badge bg-label-warning me-1"> Free Registration </span>
                                    @else
                                        <span>&nbsp;&nbsp;{{ date("h:i a", strtotime( $item->payments[0]->created_at)) }}</span> <br>
                                        <span>{{ date("d M, Y",strtotime( $item->payments[0]->created_at)) }}</span>  <br>
                                            @php
                                                $total_payments = $item->payments->count('id');
                                                $payments_verified = $item->payments->whereNotNull('varified_by')->count('id');
                                            @endphp
                                            @if ($payments_verified == $total_payments)
                                                <span class="badge bg-label-success me-1"> Verified </span>
                                            @else
                                                <span class="badge bg-label-danger me-1"> Unverified </span>
                                            @endif
                                        {{-- <span class="badge bg-label-success me-1"> Yes </span> --}}
                                    @endif

                                    {{-- @if ($item->status == 1)
                                        <span class="badge bg-label-warning me-1"> Pending </span>
                                    @else
                                        <span class="badge bg-label-success me-1"> Verified</span>
                                    @endif --}}

                                    

                                </td>
                                
                                <td>                               
                                    @if (!$item->verified_at)

                                        <a href="{{ route('register-event', $item->id) }}" onclick="return confirm('Are you sure you want to Register this participant?');">
                                            <span class="btn bg-label-warning me-1"> register </span>
                                        </a>
            
                                          
                                    @else
                                        <span class="badge bg-label-primary me-1"> {{ $item->verified_by_admin->name ?? '' }}</span><br>
                                        <span>&nbsp;&nbsp;{{ date("h:i a", strtotime( $item->verified_at)) }}</span> <br>
                                        <span>{{ date("d M, Y",strtotime( $item->verified_at)) }}</span>  <br>
                                        
                                    @endif
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('participants.show', $item->id) }}"><i
                                                    class="bx bx-edit-alt me-1"></i> Details</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="bx bx-trash me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @if ($participants->hasPages())
                    <div class="pagination-wrapper">
                        {{ $participants->links() }}
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
