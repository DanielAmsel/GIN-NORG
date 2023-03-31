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
                    <th scope="col">{{__('messages.Tank')}}</th>
                    <th scope="col">{{__('messages.Container')}}</th>
                    <th scope="col">{{__('messages.Einsatz')}}</th>
                    <th scope="col">{{__('messages.Position')}}</th>
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
            <label for="email" class="form-label">{{__('messages.Eingelagert von')}}</label>
            <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly>
        </div>
        <div class="col">
            <label for="bnummer" class="form-label" >{{__('messages.ID')}}</label>
            <input required type="text" class="form-control" name="bnummer" autofocus="autofocus">
        </div>
        <div class="col">
            <label for="MaterialSelect" class="form-label">{{__('messages.Material-Typ')}}</label>
            <select required id="MaterialSelect" class="form-select" name="materialtyp">
                <option disabled selected value>{{__('messages.-- Bitte Materialtyp wählen durch anklicken --')}}  </option>
                @foreach ($material as $material )
                    <option>{{$material->type_of_material}}</option>
                @endforeach
            </select>
        </div>
            <div class="form-group">
                <label for="commentary" class="form-label" >{{__('messages.Kommentar')}}</label>
                <textarea class="form-control" name="commentary" rows="1" ></textarea>
                <br>
            </div>
        <div class="col">
            {{__('messages.Datum')}}
        </div>
        <div class="col">
            <p><b><script>document.write(new Date().toLocaleDateString())</script></b></p>
        </div>
        <div class="col">
            <div class="form-check">
                <input required class="form-check-input" type="checkbox" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                    {{__('messages.Daten überprüft?')}}
                </label>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">{{__('messages.Probe einlagern')}}</button>
        </div>
    </form>
@endsection
