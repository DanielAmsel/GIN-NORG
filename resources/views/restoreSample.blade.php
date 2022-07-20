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

    <div >
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">B-nummer</th>
                    <th scope="col">Material Typ</th>
                    <th scope="col">Versand durch</th>
                    <th scope="col">Versand Datum</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shippedsample as $hugo)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $hugo->identifier }}</td>
                        <td>{{ $hugo->type_of_material}}</td>
                        <td>{{ $hugo->responsible_person}}</td>
                        <td>{{ $hugo->shipping_date}}</td>
                        <td>
                            <form method="POST" action="{{ Url('/restore/confirm') }}" >
                                @csrf
                            <button type="submit" class="btn btn-outline-secondary"> Probe einlagern
                                <input type="text" value="{{ $hugo->identifier }}"     name="bnummer"       hidden>
                                <input type="text" value="{{ $hugo->type_of_material }}" name="material"    hidden>
                                <input type="text" value="{{ $hugo->responsible_person }}"   name="name"    hidden>
                                <input type="text" value="{{ $hugo->id }}"   name="id"    hidden>
                            </button>
                                <input type="text" value="{{ $tank_pos }}" name="tank_pos" hidden>
                                <input type="text" value="{{ $con_pos }}" name="con_pos" hidden>
                                <input type="text" value="{{ $insert_pos }}" name="insert_pos" hidden>
                                <input type="text" value="{{ $sample_pos }}" name="sample_pos" hidden>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


