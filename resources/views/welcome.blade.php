@extends('layouts.app')
@section('content')

    <div class="container mx-auto py-2">

        @if(!auth()->check())
            {{auth()->user()}}
            <login></login>
        @else
            <logout :user="{{auth()->user()}}"></logout>
        @endif
    </div>

@endsection
