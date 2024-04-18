@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{__('messages.Probenimport')}}</h1>
        @if ($errors->any())
            <div>
                <h4>{{__('messages.Fehler:')}}</h4>
                <h4></h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('sample.import') }}" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="file">{{__('messages.CSV-Datei auswählen:')}}</label>
                <input type="file" id="file" name="file" accept=".csv">
            </div>
            <div>
                <button type="submit">{{__('messages.Importieren')}}</button>
            </div>
        </form>
    </div>
@endsection
