@extends('layouts.app')

@if (Auth::user()->role == 'administrator')


    @section('content')
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        @if(Auth::user()->role == 'physician' || Auth::user()->role == 'office')
            <script>window.location = "/sampleList";</script>
        @endif

        <div>
            <table class="table table-hover text-center">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{__('messages.Name')}}</th>
                    <th scope="col">{{__('messages.E-Mail')}}</th>
                    <th scope="col">{{__('messages.Rolle')}}</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{$loop->iteration }}</th>
                        <td>{{ $user->name}}</td>
                        <td>{{ $user->email}}</td>
                        <td>
                            <form action="{{ url('/manageUser/updateRights') }}" method="post">
                                @csrf
                                <select id="Roleselect" class="form-select" name="role">
                                    <option disabled selected value> {{ $user->role }} </option>
                                    @foreach ($roles as $role )
                                        <option>{{$role->role_name }}</option>
                                    @endforeach
                                </select>
                                <td>
                                    <button type="submit" class="btn btn-outline-secondary"> 
                                        <input type="text" value="{{ $user->id }}" name="id" hidden>{{__('messages.Rechte aktualisieren')}} 
                                    </button>
                                </td>
                            </form>
                        </td>

                        <td>
                            <form action="{{ url('/manageUser/delete') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger"> 
                                    <input type="text" value="{{ $user->id }}" name="id" hidden> {{__('messages.Nutzer entfernen')}}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endsection

@else

@endif