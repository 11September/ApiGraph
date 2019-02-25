@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Records - {{ count($records) }}</div>

                    @foreach($records as $record)
                        <div class="card-body">
                            <p>{{ $record->value }} - {{ $record->date }}</p>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="col-md-8">

            </div>
        </div>
    </div>
@endsection
