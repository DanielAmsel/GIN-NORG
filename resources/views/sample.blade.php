

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
                    aria-expanded="false"> {{__('messages.Probe')}}
                    {{ $sample }} </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" style="transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='white'" onmouseout="this.style.backgroundColor=''">- {{ $selecetedSample->value('identifier') }}</a></li>
                        <li><a class="dropdown-item" style="transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='white'" onmouseout="this.style.backgroundColor=''">- {{ $selecetedSample->value('responsible_person') }}</a></li>
                        <li><a class="dropdown-item" style="transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='white'" onmouseout="this.style.backgroundColor=''">- {{ $selecetedSample->value('type_of_material') }}</a></li>
                        <li><a class="dropdown-item" style="transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='white'" onmouseout="this.style.backgroundColor=''">- {{ $selecetedSample->value('storage_date') }}</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" style="transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='white'" onmouseout="this.style.backgroundColor=''">- {{__('messages.Kommentar: ')}} {{ $selecetedSample->value('commentary') }}</a></li>
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
                                    placeholder="{{__('messages.Verschicken nach')}}"
                                    name="address"
                                    autofocus="autofocus">
                            </div>
                        </td>
                        <button type="submit"
                            class="dropdown-item"> {{__('messages.Probe verschicken')}}
                            <input type="text"
                                value="{{ $selecetedSample->value('id') }}"name="sample_id"
                                hidden>
                        </button>
                    </li>
                    </form>
                    </li>
                    <li>
                        <form method="POST"
                            action="{{ Url('/transfer') }}" onsubmit="return confirm('{{__('messages.Sicher, dass diese Probe entfernt werden soll?')}}')">
                            @csrf
                    <li>
                        <button type="submit"
                            class="dropdown-item" style="transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#CD5C5C'" onmouseout="this.style.backgroundColor=''"> {{__('messages.Probe entfernen')}}
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
                    aria-expanded="false"> {{__('messages.Position')}}
                    {{ $sample }} </button>
                <ul class="dropdown-menu">
                    <form method="POST"
                        action="{{ Url('newSamples/pos') }}">
                        @csrf
                        <li>
                            <button type="submit"
                                class="dropdown-item"> {{__('messages.Probe einlagern')}}
                                <input type="text"
                                    value="{{ $storagetank->tank_name }}"
                                    name="tank_pos" hidden>
                                <input type="text"
                                    value="{{ $idContainer }}"
                                    name="con_pos" hidden>
                                <input type="text"
                                    value="{{ $idTube }}"
                                    name="tube_pos" hidden>
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
                            class="dropdown-item"> {{__('messages.Probe erneut einlagern')}}
                            <input type="text"
                                value="{{ $storagetank->tank_name }}"
                                name="tank_pos" hidden>
                            <input type="text"
                                value="{{ $idContainer }}"
                                name="con_pos" hidden>
                            <input type="text"
                                value="{{ $idTube }}"
                                name="tube_pos" hidden>
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