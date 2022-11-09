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

<div>
    <table class="table table-hover text-center">
        <thead>
        <tr>
            <th scope="col">Tank Name</th>
            <th scope="col">Model</th>
            <th scope="col">Hinzugefügt am</th>
        </tr>
        </thead>
        <tbody>
        @foreach($activeTanks as $activeTank)
            <tr>
                <th scope="row">{{$activeTank->tank_name }}</th>
                <th scope="row">{{$activeTank->modelname}}</th>
                <th scope="row">{{$activeTank->created_at}}</th>
                    <form method="POST" action="{{ Url('/tankDestroy') }}" >
                        @csrf
                        @foreach ($allSamplesinTank as $sample)
                            @php
                                $group = $sample->where('pos_tank_nr', $activeTank->tank_name);
                            @endphp
                         @if ($group->count() != 0)
                                <th>
                                    {{-- <button type="button" class="btn btn-primary" id="liveAlertBtn">Show live alert</button>  --}}
                                    <button type="submit" class="btn btn-outline-secondary" disabled> Tank Entfernen

                                    </button>
                                </th>
                                <th >
                                    <button type="button" class="btn btn-danger" disabled>Es sind noch Porben im Tank</button>
                                </th>
                                @break
                            @else

                                <th>
                                    <button type="submit" class="btn btn-outline-secondary"> Tank Entfernen
                                        <input value="{{ $activeTank->id }}"name="tank_id" hidden>
                                    </button>
                                </th>
                                <th></th>

                                @break

                            @endif

                        @endforeach


                    </form>
                </td>      {{-- sollte auf gleiches zugreifen wie in Home --}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div id="liveAlertPlaceholder"></div>
    <form action="{{ url('/addTank') }}" method="POST">
        @csrf
        <div class="col">
            <div class="col">
                <label class="form-label">Tank Name</label>
                <input required type="text" class="form-control" name="tank_name">
                @error('tank_name') {{$message}} @enderror
                <br>
            </div>
            <div class="col">
                <label for="MaterialSelect" class="form-label">Model</label>
                <select required id="MaterialSelect" class="form-select" name="modelname">
                    <option disabled selected value> -- Bitte Modeltype wählen durch anklicken -- </option>
                    @foreach ($tankModel as $tank )
                        <option>{{$tank->modelname }}</option>
                    @endforeach
                </select>
                @error('modelname') {{$message}} @enderror
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
                        Daten überprüft?
                    </label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Tank hinzufügen</button>
            </div>
        </div>
    </form>
@endsection
