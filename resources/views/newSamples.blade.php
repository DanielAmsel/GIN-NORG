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

    <form action="{{ url('/newSamples/pos/confirm') }}" method="POST">
        @csrf
        <div class="col center">
            <table class="table table-striped">
                <input type="text" value="{{ $tank_pos }}" name="tank_pos" hidden>
                <input type="text" value="{{ $con_pos }}" name="con_pos" hidden>
                <input type="text" value="{{ $tube_pos }}" name="tube_pos" hidden>
                <input type="text" value="{{ $sample_pos }}" name="sample_pos" hidden>
                <thead>
                <tr>
                    <th scope="col">Tank</th>
                    <th scope="col">Einsatz</th>
                    <th scope="col">Röhrchen</th>
                    <th scope="col">Probenplatz</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $tank_pos }}</td>
                    <td>{{ $con_pos }}</td>
                    <td>{{ $tube_pos }}</td>
                    <td>{{ $sample_pos }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col">
            <label for="email" class="form-label">Eingelagert von</label>
            <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly>
        </div>
        <div class="col">
            <label for="bnummer" class="form-label" >B-Nummer</label>
            <input required type="text" class="form-control" name="bnummer" autofocus="autofocus">
        </div>
        <div class="col">
            <label for="MaterialSelect" class="form-label">Material-Typ</label>
            <select required id="MaterialSelect" class="form-select" name="materialtyp">
                <option disabled selected value> -- Bitte Materialtyp wählen durch anklicken -- </option>
                @foreach ($material as $material )
                    <option>{{$material->type_of_material}}</option>
                @endforeach
            </select>
        </div>
            <div class="form-group">
                <label for="commentary" class="form-label" >Kommentar</label>
                <textarea class="form-control" name="commentary" rows="1" ></textarea>
                <br>
            </div>
        <div class="col">
            Datum
        </div>
        <div class="col">
            <p><b><script>document.write(new Date().toLocaleDateString())</script></b></p>
        </div>
        <div class="col">
            <div class="form-check">
                <input required class="form-check-input" type="checkbox" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                    Daten Überprüft ?
                </label>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Einlagern</button>
        </div>
    </form>
@endsection
