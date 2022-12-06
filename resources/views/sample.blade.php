

@php
    $insert = $storagetank->getInserts();
    $tubes   = $storagetank->getTubes();
    $sampleValue = $storagetank->getSamples();
    $tankCapacity = $storagetank->tankConstruction()->capacity;
    $sample_nr=$samples->where('pos_tank_nr', $storagetank->tank_name)->count('pos_tank_nr');
@endphp

    <!-- Sample Logik-->
    @for ($sample = 1; $sample <= $sampleValue; $sample++)
        @php
            $selecetedSample = $samples
                ->where('pos_tank_nr', $storagetank->tank_name)
                ->where('pos_insert', $idContainer)
                ->where('pos_tube', $idTube)
                ->where('pos_smpl', $sample);
        @endphp
        <div class="btn-group">

            @if ($selecetedSample->value('pos_smpl') == $sample)
                <button type="button"
                    class="btn btn-danger dropdown-toggle"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"> Probe
                    {{ $sample }} </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item">{{ $selecetedSample->value('B_number') }}
                        </a></li>
                    <li><a class="dropdown-item">{{ $selecetedSample->value('responsible_person') }}
                        </a></li>
                    <li><a class="dropdown-item">{{ $selecetedSample->value('type_of_material') }}
                        </a></li>
                    <li><a class="dropdown-item">{{ $selecetedSample->value('storage_date') }}
                        </a></li>
                    <li><a class="dropdown-item">Kommentar: {{ $selecetedSample->value('commentary') }}
                        </a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST"
                            action="{{ Url('/shipped') }}">
                            @csrf
                    <li>
                        <td>
                            <div class="col">
                                <input required type="text"
                                    class="form-control"
                                    placeholder="Verschicken nach"
                                    name="address"
                                    autofocus="autofocus">
                            </div>
                        </td>
                        <button type="submit"
                            class="dropdown-item"> Probe
                            verschicken
                            <input type="text"
                                value="{{ $selecetedSample->value('id') }}"name="sample_id"
                                hidden>
                        </button>
                    </li>
                    </form>
                    </li>
                    <li>
                        <form method="POST"
                            action="{{ Url('/transfer') }}">
                            @csrf
                    <li>
                        <button type="submit"
                            class="dropdown-item"> Probe
                            entfernen
                            <input type="text"
                                value="{{ $selecetedSample->value('id') }}"name="sample_id"
                                hidden>
                        </button>
                    </li>
                    </form>
                    </li>
                </ul>
            @else
                <button type="button"
                    class="btn btn-success dropdown-toggle"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"> Position
                    {{ $sample }} </button>
                <ul class="dropdown-menu">
                    <form method="POST"
                        action="{{ Url('newSamples/pos') }}">
                        @csrf
                        <li>
                            <button type="submit"
                                class="dropdown-item"> Probe
                                einlagern
                                <input type="text"
                                    value="{{ $storagetank->tank_name }}"
                                    name="tank_pos" hidden>
                                <input type="text"
                                    value="{{ $insert }}"
                                    name="con_pos" hidden>
                                <input type="text"
                                    value="{{ $tubes }}"
                                    name="insert_pos" hidden>
                                <input type="text"
                                    value="{{ $sample }}"
                                    name="sample_pos" hidden>
                            </button>
                        </li>
                    </form>
                    <li>
                        <form method="POST"
                            action="{{ Url('/restore') }}">
                            @csrf
                    <li>
                        <button type="submit"
                            class="dropdown-item"> Erneut
                            einlagern
                            <input type="text"
                                value="{{ $storagetank->tank_name }}"
                                name="tank_pos" hidden>
                            <input type="text"
                                value="{{ $insert }}"
                                name="con_pos" hidden>
                            <input type="text"
                                value="{{ $tubes }}"
                                name="insert_pos" hidden>
                            <input type="text"
                                value="{{ $sample }}"
                                name="sample_pos" hidden>
                        </button>
                    </li>
                    </form>
                    </li>
                </ul>
            @endif
        </div>
    @endfor