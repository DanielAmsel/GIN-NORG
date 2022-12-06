@php
    $insert = $storagetank->getInserts();
    $insertValue = $storagetank->tankConstruction()->number_of_inserts;
    $tubeValue = $storagetank->getTubes();
    $sampleValue = $storagetank->tankConstruction()->number_of_samples;
    $tankCapacity = $storagetank->tankConstruction()->capacity;
    $sample_nr = $samples->where('pos_tank_nr', $storagetank->tank_name)->count('pos_tank_nr');
@endphp

<div class="accordion accordion-flush container center_div" id="insertTable{{ $storagetank->id }}-{{ $insert }}">
    @for ($tubes = 1; $tubes <= $tubeValue; $tubes++)
        <div class="accordion-item">
            <h2 class="accordion-header" id="insert{{ $tubes }}">

                <button id="buttonTube{{ $storagetank->id }}-{{ $idContainer }}-{{ $tubes }}"
                    class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseinsert{{ $storagetank->id }}-{{ $idContainer }}-{{ $tubes }}"
                    aria-expanded="true" aria-controls="collapseinsert{{ $tubes }}">

                    @if ($samples->where('pos_tank_nr', $storagetank->tank_name)->where('pos_insert', $idContainer)->where('pos_tube', $tubes)->count('pos_smpl') == $sampleValue)
                        <div class="bg-danger p-2 badge bg-primary text-wrap">
                            Einsatz {{ $tubes }} </div>
                    @else
                        <div class="bg-success p-2 badge bg-primary text-wrap">
                            Einsatz {{ $tubes }} </div>
                    @endif
                </button>
            </h2>
            <div id="collapseinsert{{ $storagetank->id }}-{{ $idContainer }}-{{ $tubes }}"
                class="accordion-collapse collapse toggle" aria-labelledby="insert{{ $tubes }}"
                data-bs-parent="#insertTable{{ $storagetank->id }}-{{ $idContainer }}">
                <div class="accordion-body">

                    <!-- Sample Logik-->
                    <script>
                        $("#buttonTube{{ $storagetank->id }}-{{ $idContainer }}-{{ $tubes }}").click(function() {
                            $("#collapseinsert{{ $storagetank->id }}-{{ $idContainer }}-{{ $tubes }}").load(
                                "http://localhost:8000/insideTank/{{ $storagetank->id }}/{{ $idContainer }}/{{ $tubes }}/");
                        });
                    </script>

                </div>
            </div>
        </div>
    @endfor
</div>
