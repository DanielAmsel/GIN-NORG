@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row align-items-md-stretch">
            <div class="col-md-5">
                <div class="p-5 bg-light border rounded-3 flex-grow-1 min-vh-0">
                    <h3>{{__('messages.Neuen Materialtyp hinzufügen')}}</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ url('/manageMaterialTypes')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" id="newMaterialInput" name="newMaterial" placeholder="{{__('messages.Neuen Materialtyp eingeben')}}" style="width: 200%">
                                </div>                                
                                <br>
                                <button type="submit" class="btn btn-primary">{{ __('messages.Materialtyp hinzufügen') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="p-5 bg-light border rounded-3 flex-grow-1 min-vh-0">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">{{__('messages.Angelegte Materialtypen')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($material as $m)
                                <tr>
                                    <td scope="row">{{$m->type_of_material}}</td>
                                    <form method="POST" action="{{ Url('/materialDestroy') }}">
                                        @csrf

                                        @php
                                        $samples = $allSamplesinTank;
                                        $group = $samples->where('type_of_material', $m->type_of_material);
                                        @endphp

                                        @if ($group->count() == 0)
                                            <td>
                                                <button type="submit" class="btn btn-outline-secondary">{{__('messages.Materialtyp entfernen')}}                   
                                                    <input value="{{ $m->id }}"name="material_id" hidden>
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success" disabled>{{__('messages.Materialtyp keiner Probe zugeordnet')}}</button>
                                            </td>
                                        @else
                                            <td>
                                                <button type="submit" class="btn btn-outline-secondary" disabled> {{__('messages.Materialtyp entfernen')}}</button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger" disabled>{{__('messages.Es gibt noch Proben mit diesem Materialtypen')}}</button>
                                            </td>
                                        @endif
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

