@extends('layouts.app')
@section('content')

    <div class="col-md-12">
        <h4>Create Respondent Details</h4>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/respondents">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            
                        
                            <div class="form-group">
                                <label>Name <span class="text-danger">(Required)</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number <span class="text-danger">(Required)</span></label>
                                <input type="text" name="phone_number" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Address <span class="text-danger">(Required)</span></label>
                                <input type="text" name="address" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Gender <span class="text-danger">(Required)</span></label>
                                <select name="gender" class="form-control" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Email adress (Optional)</label>
                                <input type="email" name="email_adress" class="form-control">
                            </div>
                          

                            <button class="btn btn-success float-right">Save</button>

                    </div>
                        <div class="col-md-6 col-lg-6">
                              <div class="form-group">
                                <label>District</label>
                                <select name="district_id" class="form-control">
                                    @foreach($districts as $district)
                                      <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Choose the group</label>
                                <select name="group[]" class="form-control" multiple="multiple">
                                    @foreach($groups as $group)
                                      <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Choose lunguage</label>
                                <select name="language" class="form-control">
                                    <option></option>
                                    <option value="English">English</option>
                                    <option value="Luganda">Luganda</option>                                  
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Choose level of literacy</label>
                                <select name="level_of_education" class="form-control">
                                    <option></option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>                               
                                </select>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection