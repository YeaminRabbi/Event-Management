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
    <div class="row" id="notificationAlert2" style="display: none;">
        <div class="col-md-12">
            <div class="alert alert-warning">
                <span style="color:black;">
                    URL copied to Clipboard
                </span>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <div>
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Events /</span> list</h4>
        </div>
        <div class="my-auto">
            <a href="{{ route('events.create') }}">
                <button class="btn btn-info rounded-pill">Add Events</button>
            </a>
        </div>
    </div>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Event List</h5>
        <div class="table-responsive text-nowrap p-4">
            <table class="table" id="DataTable">
                <thead>
                    <tr>
                        <th>sl</th>
                        <th>Name</th>
                        <th>Event Date </th>
                        <th>Last date</th>
                        <th>Fee</th>
                        <th>Logistics</th>
                        <th>status</th>
                        <th>patricipants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($events as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td> <strong>{{ $item->name }}</strong></td>


                        {{-- //<td>{{ date("d M, Y | H:i a", $item->date) }} </td>
                        //<td>{{ date('d M, Y | H:i a', $item->reg_last_date) }} </td> --}}


                        <td>
                            <span>&nbsp;&nbsp;{{ date("h:i a", $item->date) }}</span> <br>
                            <span>{{ date("d M, Y", $item->date) }}</span>
                            {{--  {{ date("d M, Y | H:i a", $item->date) }} --}}
                        </td>
                        <td>
                            <span>&nbsp;&nbsp;{{ date("h:i a", $item->reg_last_date) }}</span> <br>
                            <span>{{ date("d M, Y", $item->reg_last_date) }}</span>
                            {{--  {{ date('d M, Y | H:i a', $item->reg_last_date) }} --}}
                        </td>
                      
                        <td>
                            @if (!$item->fee)
                                <span class="badge bg-label-success" style="font-size: 0.85em">Free Registration</span>
                            @else
                                @foreach ($item->fee as $key=>$data)
                                    <span class="badge bg-label-primary me-1">{{ $key }}</span> : &nbsp; {{ abs($data ) }}/-
                                    @if (((int)($data))<0) &nbsp;<span class="badge rounded-pill bg-warning "
                                        style="font-size: 0.65em">Mandatory</span>
                                    @endif <br>
                                
                                @endforeach
                            @endif
                        </td>
                        <td>
                            {{ $item->logistics->count() > 0 ? 'yes': 'no' }}
                        </td>
                        <td>
                            @if ($item->is_visible)
                            <a href="{{ route('event_visibility', $item->id) }}">
                                <span class="badge bg-label-success me-1"> Active </span>
                            </a>
                            @else
                            <a href="{{ route('event_visibility', $item->id) }}">
                                <span class="badge bg-label-warning me-1"> Inactive </span>
                            </a>
                            @endif
                        </td>

                        <td>

                            <a href="{{ url('admin/participants?event_id='.$item->id) }}">
                                <span>{{ $item->participants_count ?? 0 }}</span> &nbsp; <i class="fa fa-users"
                                    aria-hidden="true"></i> </a>
                        </td>

                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('events.edit', $item->id) }}"><i
                                            class="bx bx-edit-alt me-1"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                        Delete</a>
                                    <a class="dropdown-item"
                                        onclick="CopyEventURL('{{ $item->id }}', '{{ $item->name }}')"
                                        style="cursor: pointer;"><i class="fa fa-clipboard me-1"></i> Get Link</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            @if ($events->hasPages())
                <div class="pagination-wrapper">
                    {{ $events->links() }}
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
<script>
    function CopyEventURL(id, event_name) {
        var url = window.location.origin;
        var replacedString = event_name.replace(/ /g, "-");
        var clipboardText = url + '/event/' + id + '/' + replacedString;
        // alert(clipboardText);

        // console.log(url+'this is url link');
        // console.log(clipboardText+'this is actual link');

        navigator.clipboard.writeText(clipboardText);

        document.getElementById('notificationAlert2').style.display = 'block';
        $('#notificationAlert2').delay(3000).fadeOut('slow');
        // console.log(navigator.clipboard.writeText(clipboardText));
    }

</script>

@endsection
