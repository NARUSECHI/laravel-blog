@extends('layouts.app')

@section('title','Show Post')

@section('content')
    <div class="mt-2 border border-2 rounded py-3 px-4 shadow-sm">
        <h2 class="h4">{{$post->title}}</h2>
        <h3 class="h6 text-muted">{{$post->user->name}}</h3>
        <p>{{$post->body}}</p>

        <img src="{{asset('/storage/images/'.$post->image)}}" alt="{{$post->image}}" class="w-100 shadow">
        {{-- asset('/storage/images/1234.jpg') --}}
    </div>
@endsection