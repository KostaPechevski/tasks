@extends('layouts.app')
@section('content')

    <div class="container mx-auto py-2">

        @if(!auth()->check())
            <login></login>
        @else
            <logout :user="{{auth()->user()}}"></logout>
            <tasks></tasks>
        @endif
    </div>

@endsection
