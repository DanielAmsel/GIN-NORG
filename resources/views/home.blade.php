@extends('layouts.app')
@section('onDefault')
    <h2>Der Admin hat Ihnen noch keine Rolle zugewiesen</h2>
@endsection
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

    <div class="accordion accordion-flush container center_div" id="tankTable">

        @foreach ($storageTanks as $storagetank)
            @php
                $insertValue = $storagetank->tankConstruction()->number_of_inserts;
                $tubeValue = $storagetank->tankConstruction()->number_of_tubes;
                $sampleValue = $storagetank->tankConstruction()->number_of_samples;
                $tankCapacity = $storagetank->tankConstruction()->capacity;
                $sample_nr = $samples->where('pos_tank_nr', $storagetank->tank_name)->count('pos_tank_nr');
                
                $fill = round((1 / $tankCapacity) * $samples->where('pos_tank_nr', $storagetank->tank_name)->count('pos_tank_nr') * 100);
            @endphp
            <div class="accordion-item ">
                <h2 class="accordion-header" id="tank{{ $storagetank->tank_name }}">
                    <div class="progress">
                        @switch($fill)
                            @case($fill <= 75)
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $fill }}%;"
                                    aria-valuenow="{{ $fill }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $sample_nr }}/{{ $tankCapacity }} {{__('messages.Proben belegt')}}
                                </div>
                            @break

                            @case($fill > 75 && $fill <= 98)
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $fill }}%;"
                                    aria-valuenow="{{ $fill }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $sample_nr }}/{{ $tankCapacity }} {{__('messages.Proben belegt')}}
                                </div>
                            @break

                            @case($fill > 98)
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $fill }}%;"
                                    aria-valuenow="{{ $fill }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $sample_nr }}/{{ $tankCapacity }} {{__('messages.Proben belegt')}}
                                </div>
                            @break
                        @endswitch

                    </div>
                    <button id="buttonTank{{ $storagetank->id }}" class="accordion-button collapsed " type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseTank{{ $storagetank->id }}"
                        aria-expanded="false" aria-controls="collapseTank{{ $storagetank->id }}">

                        @if ($samples->where('pos_tank_nr', $storagetank->tank_name)->count('pos_insert') == $tankCapacity)
                            <div class="bg-danger p-2 badge bg-primary text-wrap"> {{__('message.Tank')}}{{ $storagetank->tank_name }}
                            </div>
                        @elseif ($fill > 50 && $fill <= 99)
                            <div class="bg-warning p-2 badge bg-primary text-wrap"> {{__('messages.Tank')}} {{ $storagetank->tank_name }}
                            </div>
                        @else
                            <div class="bg-success p-2 badge bg-primary text-wrap"> {{__('messages.Tank')}} {{ $storagetank->tank_name }}
                            </div>
                        @endif

                    </button>

                </h2>
                <div id="collapseTank{{ $storagetank->id }}" class="accordion-collapse collapse"
                    aria-labelledby="tank{{ $storagetank->id }}" data-bs-parent="#tankTable" data-delay="3000">
                    <div class="accordion-body ">

                        @php
                        echo $storagetank->id;    
                        @endphp

                        <!-- Container Logik -->
                        <script>
                            $("#buttonTank{{ $storagetank->id }}").click(function() {
                                $("#collapseTank{{ $storagetank->id }}").load(
                                    "http://localhost:8000/insideTank/{{ $storagetank->id }}/");
                            });
                        </script>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
