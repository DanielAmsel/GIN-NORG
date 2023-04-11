@extends('layouts.app')

@section('content')
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    @if(Auth::user()->role == 'physician' || Auth::user()->role == 'office')
        <script>window.location = "/sampleList";</script>
    @endif

    <div>
        <table id="myTables" class="table table-hover text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{__('messages.ID')}}</th>
                <th scope="col">{{__('messages.Material')}}</th>
                <th scope="col">{{__('messages.Verantwortlicher')}}</th>
                <th scope="col">{{__('messages.Einlagerungsdatum')}}</th>
                <th scope="col">{{__('messages.Auslagerungsdatum')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($removedSamples as $sampleOutput)
                <tr>
                    <td scope="row">{{$loop->iteration }}</td>
                    <td>{{ $sampleOutput->identifier }}</td>
                    <td>{{ $sampleOutput->type_of_material}}</td>
                    <td>{{ $sampleOutput->responsible_person}}</td>
                    <td>{{ $sampleOutput->storage_date}}</td>
                    <td>{{ $sampleOutput->removal_date}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


