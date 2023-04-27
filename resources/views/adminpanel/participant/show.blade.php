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


        {{-- <a href="{{ url('admin/participants?eventID='.$item->id) }}" class="btn btn-dark"> Back to List</a> --}}

        <div class="d-flex justify-content-between">
            <div>
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Participant Profile / </span>
                    {{ $participant->user->name }}</h4>

            </div>
            <div class="my-auto">
                <a href="{{ url('admin/participants?event_id=' . $eventID) }}">
                    <button class="btn btn-dark rounded-pill">Back to Participants</button>
                </a>
            </div>

        </div>

        <div class="row">
            <div class="col-12 mb-4 p">

                <div class="col-md">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-2 py-3">
                                <svg style="width: 150px !important" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                                    <metadata> Svg Vector Icons : http://www.onlinewebfonts.com/icon </metadata>
                                    <g>
                                        <g transform="translate(0.000000,511.000000) scale(0.100000,-0.100000)">
                                            <path
                                                d="M4833.7,4989.8c-628.8-121.1-1215.2-553.8-1484.4-1099.9c-161.5-328.8-215.4-599.9-211.5-1069.1c0-250-3.9-328.8-26.9-365.3c-46.2-71.1-55.8-180.7-32.7-338.4c46.1-296.1,186.5-588.4,344.2-715.3c53.8-44.2,86.5-92.3,117.3-178.8C3847.3,369.2,4524.1-178.7,5147.1-82.6c540.3,84.6,1038.3,573,1303.7,1282.5c36.5,94.2,75,150,161.5,234.6c128.8,126.9,209.6,276.9,275,515.3c51.9,190.4,59.6,423,15.4,492.2c-26.9,38.5-34.6,126.9-42.3,488.4c-11.5,482.6-34.6,638.4-142.3,917.2c-136.5,348-409.6,609.5-678.8,644.2c-59.6,7.7-76.9,19.2-86.5,61.5c-5.8,26.9-38.5,88.5-69.2,136.5c-136.5,200-374.9,307.7-709.5,319.2C5054.8,5012.9,4916.4,5005.2,4833.7,4989.8z M4658.7,3716.9c169.2-46.1,521.1-44.2,688.4,1.9c163.4,46.1,405.7,48.1,509.6,1.9c276.9-119.2,471.1-425,528.8-828.7c57.7-411.5-9.6-1076.8-155.7-1513.3c-119.2-357.6-365.3-748-584.5-926.8c-207.7-171.1-459.6-280.7-644.2-280.7c-282.7,0-640.3,217.3-878.7,534.5c-363.4,480.7-551.8,1194.1-519.2,1965.1c15.4,376.9,80.8,592.2,250,821C4037.7,3741.9,4297.2,3813,4658.7,3716.9z" />
                                            <path
                                                d="M3497.3-221c-80.8-53.8-221.1-138.4-311.5-186.5l-165.4-84.6v-1126.8v-1126.8l125-61.5c453.8-223,442.3-871-19.2-1082.5c-138.4-63.5-365.3-61.5-499.9,3.8c-126.9,61.5-232.7,173-294.2,305.7c-138.5,298,7.7,665.3,313.4,792.2l105.8,44.2v1053.7c0,578.8-5.8,1053.7-11.5,1053.7c-5.8,0-215.3-92.3-465.3-207.7c-536.5-242.3-788.4-378.8-922.9-496.1c-282.7-248-438.4-944.1-503.8-2247.8c-38.5-782.6-26.9-871,142.3-1040.2c178.8-176.9-194.2-161.5,4011-161.5c4205.2,0,3832.2-15.4,4011,163.4c153.8,153.8,169.2,226.9,153.8,721.1C9119.7-2515,8969.7-1693.9,8712-1397.8c-69.2,78.8-294.2,225-511.5,334.6c-205.7,103.8-924.9,426.9-949.9,426.9c-11.5,0-19.2-84.6-19.2-211.5c0-155.8,5.8-211.5,25-211.5c46.2,0,234.6-98.1,313.4-163.4c101.9-84.6,217.3-255.7,292.3-436.5c40.4-96.1,111.5-392.3,225-928.7c155.7-734.5,165.4-794.1,146.1-882.6c-36.5-161.5-155.7-275-353.8-338.4c-38.4-11.5-96.1-48.1-126.9-78.8c-100-98.1-294.2-65.4-359.6,63.5c-103.8,201.9,115.4,411.5,319.2,305.7c71.2-36.5,84.6-38.5,144.2-13.4c34.6,15.4,78.8,50,96.1,76.9c32.7,48.1,28.8,75-115.4,757.6c-80.8,388.4-169.2,773-194.2,853.7c-228.8,701.8-830.7,707.6-1078.7,7.7c-30.8-90.4-332.6-1503.6-332.6-1563.2c0-44.2,65.4-111.5,140.4-138.4c42.3-17.3,63.4-13.4,115.4,17.3c32.7,21.1,88.5,38.5,119.2,38.5c115.4,0,240.4-121.1,240.4-230.7c0-69.2-59.6-173-117.3-201.9c-90.4-48.1-200-36.5-273,26.9c-34.6,32.7-113.5,76.9-175,100c-192.3,71.2-317.2,221.1-319.2,380.7c0,84.6,296.1,1490.2,348,1655.5c98.1,305.7,292.3,546.1,523,644.1l128.8,55.8v282.7v282.7L6795-396c-94.2,51.9-230.7,134.6-307.6,184.6c-151.9,103.8-178.8,109.6-221.1,61.5c-15.4-19.2-221.1-448-457.6-951.8c-238.4-503.8-434.5-913.3-440.3-909.5c-3.8,5.8-32.7,153.8-61.5,328.8l-53.8,321.1l65.4,76.9c126.9,146.1,171.1,344.2,117.3,499.9c-59.6,167.3-171.1,225-434.6,225c-263.4,0-374.9-57.7-434.6-225c-53.8-155.7-9.6-353.8,117.3-499.9l65.4-76.9l-53.8-321.1c-28.8-175-57.7-323-61.5-328.8c-5.8-3.8-203.8,405.7-440.3,909.5s-442.2,932.6-457.6,951.8C3691.5-99.9,3658.9-109.5,3497.3-221z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <h5 class="p-0 m-0">{{ $participant->user->name }}</h5>
                                    <p class="p-0 m-0">{{ $participant->user->phone }}</p>
                                    <p class="p-0 m-0">{{ $participant->user->email }}</p>
                                    <p class="">Gender: <strong>{{ $participant->user->gender ?? '' }}</strong> </p>
                                    {{-- <p class="p-0 m-0"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <h5 class="card-title">For Emergency</h5>
                                    <p class="p-0 m-0">Name: {{ $participant->user->emergency_name }}</p>
                                    <p class="p-0 m-0">Phone: {{ $participant->user->emergency_phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Basic Layout -->
            <div class="col-md-12 col-lg-8 mb-5">
                <div class="card">
                    <h5 class="card-header">Events Participated</h5>
                    <div class="table-responsive text-nowrap p-4">
                        <table class="table" id="DataTable1">
                            <thead>
                                <tr>
                                    <th>sl</th>
                                    <th>
                                        <p class=" p-0 m-0">Event </p>
                                        <hr class="p-0 m-0">
                                        <p class=" p-0 m-0">Fees</p>
                                    </th>
                                    {{-- <th>Fees</th> --}}
                                    <th>Amount</th>
                                    <th>Paid</th>
                                    <th>Verification</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($eventsAttended as $key => $data)
                                    <tr id="event_{{ $data->id }}" class="rows"
                                        @if ($data->payable_amount != 0) onclick="paymentDetails({{ $data->id }})" style="cursor: pointer;" @endif>
                                        <td>{{ $key + 1 }}</td>
                                       
                                        <td width="300"> <strong>{{ $data->event->name }}</strong>
                                            <br>
                                            <div class="d-flex flex-wrap">

                                                @if (empty($data->selected_fee))
                                                    <span class="badge bg-label-warning me-1">Free Registration</span>
                                                @else
                                                    @foreach ($data->selected_fee as $key => $item)
                                                        <span class="badge bg-label-primary me-1 mb-1">{{ $item }}</span>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $data->payable_amount }} </td>
                                        <td>
                                            @if ($data->payments->isEmpty())
                                                <span class="badge bg-label-warning me-1"> No </span>
                                            @else
                                                <span class="badge bg-label-success me-1"> Yes </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($data->payments->isNotEmpty())
                                                @php
                                                    $total_payments = $data->payments->count('id');
                                                    $payments_verified = $data->payments->whereNotNull('varified_by')->count('id');
                                                @endphp
                                                @if ($payments_verified == $total_payments)
                                                    <span class="badge bg-label-success me-1"> Verified </span>
                                                @else
                                                    <span class="badge bg-label-danger me-1"> Unverified </span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @if ($eventsAttended->hasPages())
                            <div class="pagination-wrapper">
                                {{ $eventsAttended->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-lg-4 order-0 mb-4" id="content">
            </div>
            {{-- @if (isset($payment_id))
                TIKTOK
            @endif --}}

        </div>

    </div>
@endsection
@section('footer_js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script> --}}
    <script src="https://unpkg.com/axios/dist/axios.min.js" defer></script>

    <script>
        $('#notificationAlert').delay(3000).fadeOut('slow');
        $(document).ready(function() {
            $('#DataTable').DataTable();
        });
    </script>

    <script>
        function paymentDetails(params) {
            console.log(params);
            let content = document.querySelector('#content')
            let row = document.querySelector('#event_' + params)
            let allRows = document.querySelectorAll('.rows')
            allRows.forEach((row) => {
                row.style.boxShadow = '';
            })

            // row.classList.add('bg-primary')

            // row.style.background='#F0F7FB';
            row.style.boxShadow = '2px 2px 2px 1px rgba(0, 0, 0, 0.2)';
            axios.get('/admin/payment-details', {
                    params: {
                        participant: params
                    }
                })
                .then((result) => {
                    console.log(result);
                    content.innerHTML = ''
                    if (result.data) {
                        content.innerHTML = result.data

                    }

                }).catch((err) => {
                    content.innerHTML = `<div class="card">
                        <div class="card-header  pb-0 mb-1">
                            <div class="card-title mb-0">
                                <h3 class="text-warning text-center">No Payment</h3>
                                {{-- <h5 class="m-0 me-2">Payment Details</h5> --}}
                            </div>

                        </div>

                    </div>`
                });

        }
    </script>
@endsection
