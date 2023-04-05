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
                    <th scope="col">#</th>
                    <th scope="col">{{__('messages.ID')}}</th>
                    <th scope="col">{{__('messages.Material')}}</th>
                    <th scope="col">{{__('messages.Versand durch')}}</th>
                    <th scope="col">{{__('messages.Verschickt nach')}}</th>
                    <th scope="col">{{__('messages.Versand Datum')}}</th>
                    @if (Auth::user()->role == 'physician' || Auth::user()->role == 'office')
                    @else
                        <th scope="col" data-orderable="false"></th>
                    @endif
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
                        @if (Auth::user()->role == 'physician' || Auth::user()->role == 'office')
                        @else
                        <td>
                            <form method="POST" action="{{ Url('/transferSentSample') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary"> {{__('messages.Probe entfernen')}}
                                    <input type="text" value="{{ $hugo->id }}" name="sample_id" hidden>
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
