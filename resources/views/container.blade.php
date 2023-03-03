 @php
     $insertValue = $storagetank->getInserts();
     $tubeValue = $storagetank->tankConstruction()->number_of_tubes;
     $sampleValue = $storagetank->tankConstruction()->number_of_samples;
     $tankCapacity = $storagetank->tankConstruction()->capacity;
     $sample_nr = $samples->where('pos_tank_nr', $storagetank->tank_name)->count('pos_tank_nr');
 @endphp

 <div class="accordion accordion-flush container center_div" id="containerTable{{ $storagetank->id }}">
     @for ($insert = 1; $insert <= $insertValue; $insert++)
         <div class="accordion-item">
             <h2 class="accordion-header" id="container{{ $insert }}">

                 <button id="buttonContainer{{ $storagetank->id }}-{{ $insert }}"
                     class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                     data-bs-target="#collapsecontainer{{ $storagetank->id }}-{{ $insert }}" aria-expanded="true"
                     aria-controls="collapsecontainer{{ $insert }}">

                     @if ($samples->where('pos_tank_nr', $storagetank->tank_name)->where('pos_insert', $insert)->count('pos_tube') ==
                         $tubeValue * $sampleValue)
                         <div class="bg-danger p-2 badge bg-primary text-wrap"> {{__('messages.Container')}}
                             {{ $insert }} </div>
                     @else
                         <div class="bg-success p-2 badge bg-primary text-wrap"> {{__('messages.Container')}}
                             {{ $insert }} </div>
                     @endif
                 </button>
             </h2>
             <div id="collapsecontainer{{ $storagetank->id }}-{{ $insert }}"
                 class="accordion-collapse collapse toggle" aria-labelledby="container{{ $insert }}"
                 data-bs-parent="#containerTable{{ $storagetank->id }}">
                 <div class="accordion-body">

                     <!-- Tube Logik -->
                     <script>
                         $("#buttonContainer{{ $storagetank->id }}-{{ $insert }}").click(function() {
                             $("#collapsecontainer{{ $storagetank->id }}-{{ $insert }}").load(
                                 "http://localhost:8000/insideTank/{{ $storagetank->id }}/{{ $insert }}/");
                         });
                     </script>

                 </div>
             </div>
         </div>
     @endfor
 </div>
