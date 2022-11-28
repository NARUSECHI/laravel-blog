@extends('layouts.app')

@section('title','Edit Post')

@section('content')
<form action="{{ route('post.update',$post->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

        <div class="mb-3">
            <label for="title" class="form-label text-muted">Title</label>
            <input type="text" name="title" id="" class="form-control" value="{{ old('title',$post->title)}}">
            @error('title')
                <p class="text small">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="body" class="form-label text-muted">Body</label>
            <textarea name="body" id="body" rows="5" class="form-control" placeholder="Start writing...">{{ old('body',$post->body)}}</textarea>
            @error('body')
                <p class="text small">{{ $message }}</p>
            @enderror
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label for="image" class="form-label text-muted">Image</label>
                    <img src="{{ asset('/storage/images/'.$post->image)}}" alt="{{$post->image}}" class="w-100 img-thumbnail">
                <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
                @error('image')
                    <p class="text small">{{ $message }}</p>
                @enderror            
                <div class="form-text" id="image-info">
                    Acceptable formats: jpeg, jpg, png, gif only <br>
                    Maximum file size: 1048kb
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-warning px-5">Edit</button>
    </form>
@endsection