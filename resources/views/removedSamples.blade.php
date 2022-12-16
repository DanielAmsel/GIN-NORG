@extends('layouts.app')

@section('content')
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    @if(Auth::user()->role == 'Arzt' || Auth::user()->role == 'Sekretariat')
        <script>window.location = "/sampleList";</script>
    @endif

    <div>
        <table id="myTables" class="table table-hover text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">B-nummer</th>
                <th scope="col">Material Typ</th>
                <th scope="col">Verantwortlicher</th>
                <th scope="col">Einlagerungsdatum</th>
                <th scope="col">Auslagerungsdatum</th>
            </tr>
            </thead>
            <tbody>
            @foreach($removedSamples as $sampleOutput)
                <tr>
                    <th scope="row">{{$loop->iteration }}</th>
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


