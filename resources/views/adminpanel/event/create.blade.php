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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Event / </span> Create</h4>
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Event Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" placeholder="Event Name"
                                    name="name" required />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-date">Event Date-Time</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" id="basic-default-date" placeholder="Event Name"
                                    name="event_date" required />
                            </div>
                            <div class="col-sm-5">
                                <input type="time" class="form-control" id="basic-default-time" placeholder="Event Name"
                                    name="event_time" required />
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-date2">Reg. Last Date-Time</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control" id="basic-default-date2"
                                    name="reg_date" required />
                            </div>
                            <div class="col-sm-5">
                                <input type="time" class="form-control" id="basic-default-time2"
                                    name="reg_time" required />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-location">Location</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-location" placeholder="Input Event Location.."
                                    name="location" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Visibility</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="exampleFormControlSelect1"
                                    aria-label="Default select example" name="is_visible" required>

                                    <option value="1">Yes</option>
                                    <option value="0" selected>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-google-form">Google Form</label>
                            <div class="col-sm-10">
                                <input type="url" class="form-control" id="basic-default-google-form" placeholder="URl.."
                                    name="google_form_link" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-date2">Event Fees</label>
                            <div class="col-sm-1">
                                <div class="d-flex justify-content-center my-auto">
                                    <label for="primary_mandatory" style="font-size: 0.85em;">Mandatory</label>&nbsp;&nbsp;
                                    <input type="hidden" name="mandatory[]" value="0"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value">
                                </div>
                            </div>
                            <div class="col-sm-4">
                              <input type="text" class="form-control"
                                    name="reg_purpose[]" placeholder="Registration Purpose" />
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" id="basic-default-time2"
                                    name="reg_fee[]" placeholder="Registration Fee" />
                            </div>
                            <div class="col-sm-1 my-auto">
                                <i class="fa fa-plus-circle " aria-hidden="true" style="font-size: 25px;color:black;" onclick="ADDFORM()"></i>
                            </div>

                        </div>
                        <div id="items" class="mt-3"></div>


                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="basic-default-date2">Logistics</label>
                            
                            <div class="col-sm-3">
                              <input type="text" class="form-control"
                                    name="item_name[]" placeholder="Logistics Name" />
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" id="basic-default-time2"
                                    name="item_quantity[]" placeholder="Logistics quantity" />
                            </div>
                            <div class="col-sm-3 my-auto">
                                <i class="fa fa-plus-circle " aria-hidden="true" style="font-size: 25px;color:black;" onclick="ADDLOGISTICSFORM()"></i>
                            </div>

                        </div>
                        <div id="logistics_items" class="mt-3"></div>


                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                <a href="{{ route('events.index') }}" class="btn btn-dark btn-sm">Back to List</a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>

    <div class="row">

    </div>
</div>


@endsection


@section('footer_js')
    <script>

        var UniqueID = 1;
        var start_item = 1;
        var form = document.getElementById('items');
        var logisticsForm = document.getElementById('logistics_items');
        

        function ADDLOGISTICSFORM()
        {
            var tagID= start_item;
            console.log(tagID);
            var newDiv = document.createElement('div');
            newDiv.setAttribute('class', 'row mb-3');
            newDiv.setAttribute('id', 'uni-' + tagID);
            newDiv.innerHTML+=
            '<div class="row mb-3" id="uni-'+tagID+'">'+
                '<label class="col-sm-3 col-form-label" for="basic-default-date2"></label>'+
                '<div class="col-sm-3">'+
                    '<input type="text" class="form-control" name="item_name[]" placeholder="Logistics Name" required />'+
                '</div>'+
                '<div class="col-sm-3">'+
                    '<input type="number" class="form-control" id="basic-default-time2"  name="item_quantity[]" placeholder="Logistics quantity" required />'+
                '</div>'+
                '<div class="col-sm-3 my-auto">'+
                    '<i class="fa fa-trash " aria-hidden="true" style="font-size: 25px;color:red;" onclick="REMOVELOGISTICSFORM('+tagID+')"></i>'+
            '</div>'+
            '</div>';

            logisticsForm.appendChild(newDiv);

            start_item++;
        }


        function ADDFORM() {
            var tagID = UniqueID;
            var newDiv = document.createElement('div');
            newDiv.setAttribute('class', 'row mb-3');
            newDiv.setAttribute('id', 'uni-' + tagID);

            newDiv.innerHTML =
                '<label class="col-sm-2 col-form-label" for="basic-default-date2"></label>' +
                '<div class="col-sm-1">' +
                '<div class="d-flex justify-content-center my-auto">' +
                '<label for="primary_mandatory' + tagID + '" style="font-size: 0.85em;">Mandatory </label>&nbsp;&nbsp;' +
                '<input type="hidden" name="mandatory[]" value="0"><input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value">' +
                '</div>' +
                '</div>' +
                '<div class="col-sm-4">' +
                '<input type="text" class="form-control" name="reg_purpose[]" placeholder="Registration Purpose" required />' +
                '</div>' +
                '<div class="col-sm-3">' +
                '<input type="number" class="form-control" id="basic-default-time2" name="reg_fee[]" placeholder="Registration Fee" required />' +
                '</div>' +
                '<div class="col-sm-1 my-auto">' +
                '<i class="fa fa-trash " aria-hidden="true" style="font-size: 25px;color:red;" onclick="REMOVEFORM(' + tagID + ')"></i>' +
                '</div>' +
                '<br>';

            form.appendChild(newDiv);
            UniqueID++;
        }

        function REMOVEFORM(id) {
            var div = document.getElementById('uni-' + id).remove();
        }

        let fee_mandatory = [];
        function REMOVELOGISTICSFORM(id)
        {
            var div = document.getElementById('uni-'+id).remove();
        }
        function Mandatory(id) {
            var div = document.getElementById(id);
            fee_mandatory.push(div);
            console.log(fee_mandatory + '<br>');
        }


    </script>
    <script>
        $('#notificationAlert').delay(3000).fadeOut('slow');     
     </script>
  
@endsection

