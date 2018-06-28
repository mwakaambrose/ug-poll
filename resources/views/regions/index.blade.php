@extends('layouts.app')

@section('content')

    <div class="row col-md-12">
        <div class="col-sm-6 pull-left">
            <h4>Available Regions</h4>
        </div>
        <div class="col-sm-6 text-right pb-2">
            <a href="/regions/create" class="btn btn-success">+ Add New Region</a>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-condensed" id="data_table">
                    <thead>
                        <th>Region</th>
                        <th>Districts</th>
                        <th>Actions</th>
                    </thead>

                    <tbody>

                    @foreach($regions as $region)
                        <tr>
                            <td>{{$region->name}}</td>
                            <td>
                                @foreach($region->districts as $district)
                                    {{ $district->name }},
                                @endforeach
                            </td>
                            <td>
                                <a href="/regions/{{ $region->id }}/edit">Add District</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@include('shared._datatable_scripts')
