@extends('layouts.app')
@section('content')

    <div class="col-md-12">
        <h4>Create Respondent Details</h4>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/respondents">
                    @csrf
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Phone number</label>
                        <input type="text" name="phone_number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email adress (Optional)</label>
                        <input type="email" name="email_adress" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>District</label>
                        <select name="district_id" class="form-control">
                            @foreach($districts as $district)
                              <option value="{{$district->id}}">{{$district->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Choose the group</label>
                        <select name="group[]" class="form-control" multiple="multiple">
                            @foreach($groups as $group)
                              <option value="{{$group->id}}">{{$group->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button class="btn btn-success float-right">Save</button>
                </form>
            </div>
        </div>
    </div>

@endsection
