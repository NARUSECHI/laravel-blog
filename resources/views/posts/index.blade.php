@extends('layouts.app')

@section('title','Home')

@section('content')
    @forelse($post_list as $post)
        <div class="mt-2 border border-2 rounded py-3 px-4">
            <a href="{{ route('post.show',$post->id)}}">
                <h2 class="h4">{{ $post -> title }}</h2>
            </a>

            <h3 class="h6 text-muted">{{ $post->user->name }}</h3>
            <p class="fw-light mb-0">{{$post->body}}</p>
            
            {{--  ACTION BUTTONS --}}
            {{-- If the owner of the post is the Auth(logged in) User , show edit and delete buttons --}}
            @if($post->user->id === Auth::user()->id)
                <div class="text-end mt-2">
                    <a href="{{route('post.edit',$post->id)}}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-edit">Edit</i>
                    </a>

                    <form action="{{route('post.destroy',$post->id)}}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash"> Delete</i>
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @empty
        <div style="margin-top: 100px;">
            <h2 class="text-muted text-center">No Posts yet.</h2>
            <p class="text-center">
                <a href="{{ route('post.create') }}" class="text-decoration-none">Create a new post</a>
            </p>
        </div>

    @endforelse
@endsection