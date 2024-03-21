@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Probenimport</h1>
        @if ($errors->any())
            <div>
                <h4>Fehler:</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('sample.import') }}" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="file">CSV-Datei auswählen:</label>
                <input type="file" id="file" name="file" accept=".csv">
            </div>
            <div>
                <button type="submit">Importieren</button>
            </div>
        </form>
    </div>
@endsection
