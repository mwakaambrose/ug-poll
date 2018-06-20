@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Create regions</div>

                <a href="{{route('region.create')}}">Add region</a>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <th>Name</th><th>Districts</th><th>Actions</th>

                         @foreach($regions as $region)
                         <tr>
                             <td>{{$region->name}}</td>
                             <td>
                                 @foreach($region->district as $districts)
                                   {{$districts->name}}; 
                                 @endforeach
                             </td>
                             <td>
                                 <a href="{{route('district.edit',$region->id)}}">Add District</a>
                             </td>
                         </tr>
                          
                        @endforeach
                    </table>           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection