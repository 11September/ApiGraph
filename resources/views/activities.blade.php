@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Activities</div>

                    @foreach($activities as $activity)
                        <div class="card-body">
                            <a href="{{ action('RecordsController@recordActivity', $activity->id) }}">{{ $activity->name }}</a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
