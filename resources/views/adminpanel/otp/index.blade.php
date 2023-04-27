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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">OTP /</span> list</h4>
            </div>

        </div>
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">OTP List</h5>
            <div class="table-responsive text-nowrap p-4">
                <table class="table" id="DataTable">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Phone</th>
                            <th>OTP</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($otp_list as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td> <strong>{{ $item->phone }}</strong></td>
                                <td> {{ $item->code  }}</td>
                                <td>{{ $item->count  }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @if ($otp_list->hasPages())
                    <div class="pagination-wrapper">
                        {{ $otp_list->links() }}
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
        function CopyEventURL(id,event_name)
        {
            var url = window.location.origin;
            var replacedString = event_name.replace(/ /g, "-");
            var clipboardText = url+'/event/'+id+'/'+replacedString;
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
