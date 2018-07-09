@extends('layouts.app')
@section('content')

    <div class="col-md-12">
        <h4>Edit {{$respondents->name}}</h4>

        <div class="card">
            <div class="card-body">            

                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            
                        
                            <div class="form-group">
                                <label>Name <span class="text-danger">(Required)</span></label>
                                <input type="text" id="person_name" value="{{$respondents->name}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number <span class="text-danger">(Required)</span></label>
                                <input type="text" id="phone_number" value="{{$respondents->phone_number}}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Address <span class="text-danger">(Required)</span></label>
                                <input type="text" id="address" value="{{$respondents->address}}" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Gender [{{$respondents->gender}}]<span class="text-danger">(Required)</span></label>
                                <select id="gender" class="form-control" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Email adress (Optional)</label>
                                <input type="email" value="{{$respondents->email_adress}}" id="email_adress" class="form-control">
                            </div>                          

                            <a href="#" class="btn btn-success float-right" id="savebtn">Save</a>

                    </div>
                        <div class="col-md-6 col-lg-6">
                              <div class="form-group">
                                <label>District  [{{$respondents->district->name}}]</label>
                                <select id="district_id" class="form-control">
                                    @foreach($districts as $district)
                                      <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Choose the group
                                    [@foreach($respondents->groups as $group)
                                      {{$group->name}}; 
                                    @endforeach]
                                </label>
                                <select id="group_data" class="form-control">
                                    @foreach($groups as $group)
                                      <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Choose lunguage  [{{$respondents->language}}]</label>
                                <select id="language" class="form-control">
                                    <option></option>
                                    <option value="English">English</option>
                                    <option value="Luganda">Luganda</option>                                  
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Choose level of literacy [{{$respondents->level_of_education}}]</label>
                                <select id="level_of_education" class="form-control">
                                    <option></option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>                               
                                </select>
                            </div>

                        </div>
                    </div>
              
            </div>
        </div>
    </div>
@endsection

@push('scripts')
  <script>
     $(document).ready(function() {
        $('#savebtn').on('click',function(e){
        
              $.ajax({
                type: "PUT",
                url: "{{route('respondents.update',$respondents->id)}}",
                data: {
                    name: $("#person_name").val(),
                    phone_number: $("#phone_number").val(),
                    address: $("#address").val(),
                    gender: $("#gender").val(),
                    email_adress: $("#email_adress").val(),
                    district_id: $("#district_id").val(),
                    group: $("#group_data").val(),
                    language: $("#language").val(),
                    level_of_education: $("#level_of_education").val(),
                    _token: "{{Session::token()}}" 
                },
                success: function(result){
                    alert(result);
                }
            });
         });        
       });
  </script>
@endpush