@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if (Auth::user()->role == 'Arzt' || Auth::user()->role == 'Sekretariat')
        <script>
            window.location = "/sampleList";
        </script>
    @endif
   
    <div>
        <table id="myTables" class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col"                       >#</th>
                    <th scope="col"                       >Tank Name</th>
                    <th scope="col" data-orderable="false">Einsatz</th>
                    <th scope="col" data-orderable="false">Röhrchen</th>
                    <th scope="col" data-orderable="false">Probenplatz</th>
                    <th scope="col"                       >B-Nummer</th>
                    <th scope="col"                       >Material</th>
                    <th scope="col"                       >Verantwortlicher</th>
                    <th scope="col"                       >Einlagerungsdatum</th>
                    <th scope="col"                       >Kommentar</th>
                    <th scope="col" data-orderable="false">Versandort</th>
                    <th scope="col" data-orderable="false">Probe verschicken</th>
                    <th scope="col" data-orderable="false">Probe entfernen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($samples as $sampleOutput)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <th scope="row">{{ $sampleOutput->pos_tank_nr }}</th>
                        <th scope="row">{{ $sampleOutput->pos_insert }}</th>
                        <th scope="row">{{ $sampleOutput->pos_tube }}</th>
                        <th scope="row">{{ $sampleOutput->pos_smpl }}</th>
                        <td>{{ $sampleOutput->B_number }}</td>
                        <td>{{ $sampleOutput->type_of_material }}</td>
                        <td>{{ $sampleOutput->responsible_person }}</td>
                        <td>{{ $sampleOutput->storage_date }}</td>
                        <td>{{ $sampleOutput->commentary }}</td>
                        <form method="POST" action="{{ Url('/shipped') }}">
                            @csrf
                            <td>
                                <div class="col">
                                    <input required type="text" class="form-control" name="address"
                                        autofocus="autofocus">
                                </div>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-outline-secondary"> Probe verschicken
                                    <input type="text" value="{{ $sampleOutput->id }}"name="sample_id" hidden>
                                </button>
                        </form>
                        </td> {{-- sollte auf gleiches zugreifen wie in Home --}}
                        <td>
                            <form method="POST" action="{{ Url('/transferSampleDelete') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary"> Probe entfernen
                                    <input type="text" value="{{ $sampleOutput->id }}"name="sample_id" hidden>
                                </button>
                            </form>
                        </td> {{-- sollte auf gleiches zugreifen wie in Home --}}
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- <script>
            $('#myTable').DataTable( {
            fixedHeader: false
        } );
        </script> --}}
       
        {{-- <script>
            $('#myTable').dataTable( {
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 1, 2, 3 ] }
                ]
            });
        </script> --}}

    </div>
    

@endsection
