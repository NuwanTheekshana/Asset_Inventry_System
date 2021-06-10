@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('All User Details') }}</div>

                <div class="card-body">
                   
                    <table id="all_user_tbl" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="10%">EPF No</th>
                                <th width="20%">Full Name</th>
                                <th width="10%">Comapny</th>
                                <th width="15%">Email</th>
                                <th width="15%">Permision</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($all_user_data as $users)
                              <tr>
                                  <td>{{$users->epf_no}}</td>
                                  <td>{{$users->name}}</td>
                                  <td>{{$users->company}}</td>
                                  <td>{{$users->email }}</td>
                                  <td>{{$users->permission}}</td>
                                  <td>
                                      <center>
                                        <button class="btn btn-success" style="background-color: green" data-toggle="modal" data-target="#update_user{{$users->id}}"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-warning" style="background-color: orange" data-toggle="modal" data-target="#change_user_password{{$users->id}}"><i class="fa fa-key"></i></button>
                                        <button class="btn btn-danger" style="background-color: red" data-toggle="modal" data-target="#remove_user{{$users->id}}"><i class="fa fa-trash"></i></button>
                                  
                                      </center>
                                       </td>
                              </tr>


                                                            <!--Remove Modal -->
                                <div id="remove_user{{$users->id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h4 class="modal-title">Remove User</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                        <form action="{{route('remove_users')}}" method="POST">
                                            @csrf
                                            <p>Are you sure do you want to remove this user ?</p>
                                        
                                        <input type="hidden" name="remove_users_ids" id="remove_users_ids" value="{{$users->id}}">
                                
                                        <button class="btn btn-danger pull-right" style="background-color: red">No, Don't Remove</button>
                                        <button type="submit" class="btn btn-success pull-right mr-2" style="background-color: green">Yes, Remove user</button>
                                        </form>
                                        </div>
                                
                                    </div>
                                
                                    </div>
                                </div>

        
                            <!--Change Password Modal -->
                            <div id="change_user_password{{$users->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                            
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title">Change Password User</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="pass_change_form" action="{{route('change_user_password')}}" method="POST">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-4 col-form-label">Current Password</label>
                                                <div class="col-sm-8">
                                                  <input type="password" class="form-control" id="password" name="password">
                                                  <input type="hidden" class="form-control" id="id_pass_id" name="id_pass_id" value="{{$users->id}}">
                                                </div>
                                              </div>
                                
                                              <div class="form-group row">
                                                <label for="new_pass" class="col-sm-4 col-form-label">New Password</label>
                                                <div class="col-sm-8">
                                                  <input type="password" class="form-control" id="new_pass" name="new_pass">
                                                </div>
                                              </div>
                                
                                              <div class="form-group row">
                                                <label for="confirm_pass" class="col-sm-4 col-form-label">Confirm Password</label>
                                                <div class="col-sm-8">
                                                  <input type="password" class="form-control" id="confirm_pass" name="confirm_pass">
                                                </div>
                                              </div>

                                              <center>
                                                    <button type="submit" id="change_pass_btn" class="btn btn-danger mr-2">Change Password</button>
                                              </center>
                                            </form>
                                    </div>
                            
                                </div>
                            
                                </div>
                            </div>
                                                             







                                                        <!--Update Modal -->
                            <div id="update_user{{$users->id}}" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                            
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Update User</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    
                                    </div>
                                    <div class="modal-body">
                                        
                                        <form action="{{route('user_update_details')}}" method="POST">
                                            @csrf
                                        
                                        

                                            <div class="form-group row">
                                                <label for="add_other_asset_type" class="col-sm-4 col-form-label">EPF No</label>
                                                <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="update_epf" name="update_epf" value="{{$users->epf_no}}" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="update_name" class="col-sm-4 col-form-label">Name</label>
                                                <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="update_name" name="update_name" value="{{$users->name}}" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="update_company" class="col-sm-4 col-form-label">Company</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="update_company" id="update_company" required>
                                                        <option value="{{$users->company}}">{{$users->company}}</option>
                                                        <option value="HNBA">HNBA</option>
                                                        <option value="HNBGI">HNBGI</option>
                                                      </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="update_department" class="col-sm-4 col-form-label">Department</label>
                                                <div class="col-sm-8">
                                                  <input type="text" class="form-control" id="update_department" name="update_department" value="{{$users->department}}" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="update_email" class="col-sm-4 col-form-label">Email</label>
                                                <div class="col-sm-8">
                                                  <input type="text" class="form-control" id="update_email" name="update_email" value="{{$users->email}}" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="update_permission" class="col-sm-4 col-form-label">Permision</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="update_permission" id="update_permission" required>
                                                        <option value="{{$users->permission}}">{{$users->permission}}</option>
                                                        <option value="Admin User">Admin User</option>
                                                        <option value="IT Support User">IT Support User</option>
                                                        <option value="IT Support Admin User">IT Support Admin User</option>
                                                      </select>
                                                </div>
                                            </div>
                            
                                            <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{$users->id}}" required>
                                        
                            
                                                <button class="btn btn-danger pull-right" style="background-color: red" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning pull-right mr-2" style="background-color: orange">Update User</button>

                                        </form>

                                    </div>
                                   
                                </div>
                            
                                </div>
                            </div>



                          @endforeach
                
                        </tbody>
                
                </table>








                </div>
            </div>
        </div>
    </div>
</div>
@endsection
