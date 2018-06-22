@extends('layouts.app')
@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>{{ $region->name }}</h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <form action="/regions/{{ $region->id }}" method="POST">
                {{method_field('DELETE')}}
                {{ csrf_field() }}
                <span class="glyphicon glyphicon-trash"></span>
                <input type="submit" class="btn btn-danger" value="Delete Region"/>
            </form>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="row py-3">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $region->districts->count() }}</h5>
                        <p class="card-text">Districts</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $total_respondents }}</h5>
                        <p class="card-text">Respondents</p>
                    </div>
                </div>
            </div>
        </div>

        <h4>Add New District</h4>

        <div class="card my-3">
            <div class="card-body">
                <form action="/district" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Name of District</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <input type="hidden" name="region_id" value="{{ $region->id }}">

                    {{-- <button id="save_region">Save</button> --}}
                    <input type="submit" class="btn btn-outline-success" value="Save">
                </form>
            </div>
        </div>

        <h4>Districts</h4>

        <div class="card">
            <div class="card-body">
                <table class="table table-condensed table-striped">
                    <tr>
                        <th>District</th>
                        <th>Respondents</th>
                        <th class="text-center">Actions</th>
                    </tr>

                     @foreach($region->districts as $district)
                         <tr>
                             <td>{{ $district->name }}</td>
                             <td>{{ $district->respondents->count() }}</td>
                             <td class="text-center">
                                 <form action="/district/{{ $district->id }}" method="POST">
                                    {{method_field('DELETE')}}
                                    {{ csrf_field() }}

                                    <span class="glyphicon glyphicon-trash"></span>
                                    <input type="submit" class="btn btn-outline-danger" value="Delete District"/>
                                </form>
                             </td>
                         </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection
