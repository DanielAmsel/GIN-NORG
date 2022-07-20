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
        <table class="table table-hover text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tank Nummer</th>
                <th scope="col">Einsatz</th>
                <th scope="col">Röhrchen</th>
                <th scope="col">Probenplatz</th>
                <th scope="col">B-Nummer</th>
                <th scope="col">Material</th>
                <th scope="col">Verantwortlicher</th>
                <th scope="col">Einlagerungsdatum</th>
            </tr>
            </thead>
            <tbody>
            @foreach($samples as $sampleOutput)
                <tr>
                    <th scope="row">{{$loop->iteration }}</th>
                    <th scope="row">{{$sampleOutput->pos_tank_nr }}</th>
                    <th scope="row">{{$sampleOutput->pos_insert}}</th>
                    <th scope="row">{{$sampleOutput->pos_tube}}</th>
                    <th scope="row">{{$sampleOutput->pos_smpl}}</th>
                    <td>{{ $sampleOutput->B_number }}</td>
                    <td>{{ $sampleOutput->type_of_material}}</td>
                    <td>{{ $sampleOutput->responsible_person}}</td>
                    <td>{{ $sampleOutput->storage_date}}</td>
                    <td>
                        <form method="POST" action="{{ Url('/shipped') }}" >
                            @csrf
                                <button type="submit" class="btn btn-outline-secondary"> Probe verschicken
                                    <input type="text" value="{{ $sampleOutput->id }}"name="sample_id" hidden>
                                </button>
                        </form>
                    </td>    {{-- sollte auf gleiches zugreifen wie in Home --}}
                    <td>
                        <form method="POST" action="{{ Url('/transferSampleDelete') }}" >
                            @csrf
                                <button type="submit" class="btn btn-outline-secondary"> Probe entfernen
                                    <input type="text" value="{{ $sampleOutput->id }}"name="sample_id" hidden>
                                </button>
                        </form>
                    </td>      {{-- sollte auf gleiches zugreifen wie in Home --}}
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


