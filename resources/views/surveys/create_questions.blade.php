@extends('layouts.app_fancy')

@section('content') 
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <blockquote class="blockquote">
                    <p class="mb-0">{{ $survey->name }}</p>
                    <footer class="blockquote-footer">{{$survey->description }}</footer>
                </blockquote>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                
                <div class="modal-body">
                    <form action="/surveys/{{$survey->id}}/questions" method="POST">
                        @csrf
                        <input type="hidden" name="survey_id" value="{{$survey->id}}">
                        <div class="form-group">
                            <label>Question <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                            <input type="text" name="description" class="form-control" required>
                        </div>
                        <h6 class="text-center"><em>Question answers</em></h6>
                        <hr>

                        <label>Question Type <span class="text-warning" style="font-size: 13px;">(Required)</span></label>
                        <select class="form-control" name="answer_type">
                            <option></option>
                            <option value="objective_type">Objective type</option>
                        </select>
                        
                        <div class="container1">
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <span>Posible Answer <span class="text-warning" style="font-size: 13px;">(Required)</span></span>
                                    <input type="text" class="form-control" name="answertext[]" required>
                                </div>

                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <span>Posible Value <span class="text-warning" style="font-size: 13px;">(Required)</span></span>
                                    <input type="number" step="any" class="form-control" name="answervalue[]" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="add_form_field btn btn-success">Add New Field &nbsp; <span style="font-size:16px; font-weight:bold;">+ </span></button>
                            <button type="submit" class="float-right btn btn-success">Save Question</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer">
                <a class="float-right btn btn-info" href="{{route('surveys.show',$survey->id)}}">View questions</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var max_fields      = 10;
    var wrapper         = $(".container1");
    var add_button      = $(".add_form_field");
 
    var x = 1;
    $(add_button).click(function(e){
        e.preventDefault();
        if(x < max_fields){
            x++;
            $(wrapper).append("<div class='row'><div class='col-md-6 col-lg-6 col-sm-12 col-xs-12'><span>Posible Answer <span class='text-warning' style='font-size: 13px;'>(Required)</span></span><input type='text' class='form-control' name='answertext[]' required></div><div class='col-md-6 col-lg-6 col-sm-12 col-xs-12'><span>Posible Value <span class='text-warning' style='font-size: 13px;'>(Required)</span></span><input type='number' step='any' class='form-control' name='answervalue[]'></div></div>"); 
        }else{
            alert('You Reached the limit');
        }
    });
    
    $(wrapper).on("click",".delete", function(e){
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
</script>
@endpush