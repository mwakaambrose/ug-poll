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
                        <answer-field></answer-field>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
  <script src="{{ asset('js/app.js') }}" defer></script>
@endpush