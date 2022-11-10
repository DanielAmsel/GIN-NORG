@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif



    <div>
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">B-nummer</th>
                    <th scope="col">Material Typ</th>
                    <th scope="col">Versand durch</th>
                    <th scope="col">Verschickt nach</th>
                    <th scope="col">Versand Datum</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shippedsample as $hugo)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $hugo->identifier }}</td>
                        <td>{{ $hugo->type_of_material }}</td>
                        <td>{{ $hugo->responsible_person }}</td>
                        <td>{{ $hugo->shipped_to }}</td>
                        <td>{{ $hugo->shipping_date }}</td>
                        <td>
                            <form method="POST" action="{{ Url('/transferSentSample') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary"> Probe entfernen
                                    <input type="text" value="{{ $hugo->id }}" name="sample_id" hidden>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
