@extends('layouts.app')

@section('content')

<chat-component id="{{$user->id}}" ></chat-component>

@endsection
