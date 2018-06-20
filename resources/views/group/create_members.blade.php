@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create members</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{route('respondent.store')}}">
                        @csrf
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                        <br>
                        <label>Phone number</label>
                        <input type="text" name="phone_number" class="form-control">

                        <label>Address</label>
                        <input type="text" name="address" class="form-control">

                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                        <label>Email adress (Optional)</label>
                        <input type="email" name="email_adress" class="form-control">

                        <label>District</label>
                        <select name="district_id" class="form-control">
                            @foreach(App\District::all() as $district)
                              <option value="{{$district->id}}">{{$district->name}}</option>
                            @endforeach
                        </select>

                        <label>Choose the gruops</label>
                        <select name="group[]" class="form-control" multiple="multiple">
                            @foreach(App\Group::all() as $gruops)
                              <option value="{{$gruops->id}}">{{$gruops->name}}</option>
                            @endforeach
                        </select>
                        <br>
                        <button id="save_region">Save</button>
                    </form>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection