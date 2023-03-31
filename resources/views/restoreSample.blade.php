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

    <div >
        <table id="myTables" class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('messages.ID')}}</th>
                    <th scope="col">{{__('messages.Material-Typ')}}</th>
                    <th scope="col">{{__('messages.Versand durch')}}</th>
                    <th scope="col">{{__('messages.Zurück aus')}}</th>
                    <th scope="col">{{__('messages.Versand Datum')}}</th>
                    <th scope="col" data-orderable="false"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($shippedsample as $hugo)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $hugo->identifier }}</td>
                        <td>{{ $hugo->type_of_material}}</td>
                        <td>{{ $hugo->responsible_person}}</td>
                        <td>{{ $hugo->shipped_to}}</td>
                        <td>{{ $hugo->shipping_date}}</td>
                        <td>
                            <form method="POST" action="{{ Url('/restore/confirm') }}" >
                                @csrf
                            <button type="submit" class="btn btn-outline-secondary"> {{__('messages.Probe einlagern')}}
                                <input type="text" value="{{ $hugo->identifier }}"     name="bnummer"       hidden>
                                <input type="text" value="{{ $hugo->type_of_material }}" name="material"    hidden>
                                <input type="text" value="{{ $hugo->responsible_person }}"   name="name"    hidden>
                                <input type="text" value="{{ $hugo->id }}"   name="id"    hidden>
                            </button>
                                <input type="text" value="{{ $tank_pos }}" name="tank_pos" hidden>
                                <input type="text" value="{{ $con_pos }}" name="con_pos" hidden>
                                <input type="text" value="{{ $tube_pos }}" name="tube_pos" hidden>
                                <input type="text" value="{{ $sample_pos }}" name="sample_pos" hidden>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


