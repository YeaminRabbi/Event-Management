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
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Admin Profile / </span> {{ $user->name }}</h4>    
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-md-12 col-lg-6">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Admin Profile Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin-list.update' , $user->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name"
                                    placeholder="John Doe" name="name" value="{{ $user->name }}" required "/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-phone"
                                    placeholder="017*******" name="phone" value="{{ $user->phone }}" disabled />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-email">Email</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="email" id="basic-default-email" class="form-control"
                                        placeholder="admin@gmail.com" aria-label="john.doe"
                                        aria-describedby="basic-default-email2"  name="email" value="{{ $user->email }}" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Gender</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" name="gender" required>
                                    <option value="male" @if ($user->gender == 'male')selected @endif>Male</option>
                                    <option value="female" @if ($user->gender == 'female')selected @endif>Female</option>
                                    <option value="others" @if ($user->gender == 'others')selected @endif>others</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-password">Password</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" id="basic-default-password" class="form-control"
                                    placeholder="Input to change password" name="password" value="{{ $user->pass }}" required/>                                    
                                </div>
                            </div>
                        </div>

                        {{-- //TODO in future this portion needs to be Dynamic Admin Edit --}}
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Admin Type</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="exampleFormControlSelect12"  name="role_id" required>
                                    <option disabled selected>-- Choose option --</option>
                                    <option  value="2" @if ($user->hasRole('admin'))selected @endif>Admin</option>
                                    <option value="1" @if ($user->hasRole('super-admin'))selected @endif>Super-Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                <a href="{{ route('admin-list.index') }}" class="btn btn-dark btn-sm">Back to List</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
       
    </div>

</div>

@endsection
@section('footer_js')
<script>
    $('#notificationAlert').delay(3000).fadeOut('slow');     
 </script>
@endsection