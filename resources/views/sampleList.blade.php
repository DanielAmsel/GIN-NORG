@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
 
    <div>
        <table id="myTables" class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col"                       >#</th>
                    <th scope="col"                       >{{__('messages.Tank Name')}}</th>
                    <th scope="col" data-orderable="false">{{__('messages.Container')}}</th>
                    <th scope="col" data-orderable="false">{{__('messages.Einsatz')}}</th>
                    <th scope="col" data-orderable="false">{{__('messages.Probenplatz')}}</th>
                    <th scope="col"                       >{{__('messages.ID')}}</th>
                    <th scope="col"                       >{{__('messages.Material')}}</th>
                    <th scope="col"                       >{{__('messages.Verantwortlicher')}}</th>
                    <th scope="col"                       >{{__('messages.Einlagerungsdatum')}}</th>
                    <th scope="col"                       >{{__('messages.Kommentar')}}</th>
                    @if (Auth::user()->role == 'physician' || Auth::user()->role == 'office')
                    @else
                        <th scope="col" data-orderable="false">{{__('messages.Versandort')}}</th>
                        <th scope="col" data-orderable="false"></th>
                        <th scope="col" data-orderable="false"></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($samples as $sampleOutput)
                    <tr>
                        <td scope="row">{{ $loop->iteration }}</td>
                        <td scope="row">{{ $sampleOutput->pos_tank_nr }}</td>
                        <th scope="row">{{ $sampleOutput->pos_insert }}</th>
                        <th scope="row">{{ $sampleOutput->pos_tube }}</th>
                        <th scope="row">{{ $sampleOutput->pos_smpl }}</th>
                        <td>{{ $sampleOutput->B_number }}</td>
                        <td>{{ $sampleOutput->type_of_material }}</td>
                        <td>{{ $sampleOutput->responsible_person }}</td>
                        <td>{{ $sampleOutput->storage_date }}</td>
                        <td>{{ $sampleOutput->commentary }}</td>
                        @if (Auth::user()->role == 'physician' || Auth::user()->role == 'office')
                        @else
                        <form method="POST" action="{{ Url('/shipped') }}">
                            @csrf
                            <td>
                                <div class="col">
                                    <input required type="text" class="form-control" name="address"
                                        autofocus="autofocus">
                                </div>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-outline-secondary"> {{__('messages.Probe verschicken')}}
                                    <input type="text" value="{{ $sampleOutput->id }}"name="sample_id" hidden>
                                </button>
                        </form>
                        </td> {{-- sollte auf gleiches zugreifen wie in Home --}}
                        <td>
                            <form method="POST" action="{{ Url('/transferSampleDelete') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary"> {{__('messages.Probe entfernen')}}
                                    <input type="text" value="{{ $sampleOutput->id }}"name="sample_id" hidden>
                                </button>
                            </form>
                        </td> {{-- sollte auf gleiches zugreifen wie in Home --}}
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    

@endsection
