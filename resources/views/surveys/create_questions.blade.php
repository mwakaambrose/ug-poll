@extends('layouts.app')

@section('content') 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">            
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a class="btn btn-info" href="{{route('surveys.show',$survey->id)}}">View questions</a>

                    <h2>{{$survey->name}}</h2>

                    <form action="/surveys/{{$survey->id}}/questions" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="survey_id" value="{{$survey->id}}">
                        <div class="form-group">
                            <label>Question (<span class="text-danger">Required</span>) </label>
                            <input type="text" name="description" class="form-control" required>
                        </div>
                        <h6>Question answers</h6>
                        <hr>
                        <!-- <answer-field></answer-field> -->

                        <label>Question Type</label>
                        <select class="form-control" name="answer_type">
                            <option value="objective_type">Objective type</option>
                        </select>
                 

                    <div class="container1">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                <span>Posible Answer</span>
                                <input type="text" class="form-control" name="answertext[]">
                            </div>

                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                <span>Posible Value</span>
                                <input type="number" step="any" class="form-control" name="answervalue[]">
                            </div>
                        </div>
                        <br>
                             <button class="add_form_field btn btn-success">Add New Field &nbsp; <span style="font-size:16px; font-weight:bold;">+ </span></button>
                    
                    </div>

                </div>

                 


                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
                        <button type="submit" class="btn btn-success">Save Question</button>
                    </div>
                </form>

                             
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
  <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    var max_fields      = 10;
    var wrapper         = $(".container1");
    var add_button      = $(".add_form_field");
 
    var x = 1;
    $(add_button).click(function(e){
        e.preventDefault();
        if(x < max_fields){
            x++;
            $(wrapper).append("<div class='row'><div class='col-md-6 col-lg-6 col-sm-12 col-xs-12'><span>Posible Answer</span><input type='text' class='form-control' name='answertext[]'></div><div class='col-md-6 col-lg-6 col-sm-12 col-xs-12'><span>Posible Value</span><input type='number' step='any' class='form-control' name='answervalue[]'></div></div>"); 
        }
  else
  {
  alert('You Reached the limits')
  }
    });
 
    $(wrapper).on("click",".delete", function(e){
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>
@endpush