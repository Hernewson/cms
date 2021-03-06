@extends('layouts.app')
@section('styles')
<style>
    .zoom {
        /* padding: 50px; */
        background-color: whitesmoke;
        transition: transform .2s;
        /* Animation */
        width: auto;
        height: '100px';
        margin: 0 auto;
    }

    .zoom:hover {
        transform: scale(3.5);
        /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }
</style>
@endsection
@section('content')
<div class="card card-default">
    <div class="card-header">
        {{isset($post) ? 'Edit post' : 'Create Post'}}
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-group">
                @foreach ($errors->all() as $error)
                <li class="list-group-item text-danger">
                    {{$error}}
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{isset($post)?route('posts.update', $post->id):route('posts.store')}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($post))
            @method('PUT')

            @endif
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title"
                    value="{{isset($post) ? $post->title : '' }} {{old('title')}} ">
            </div>
            <div class=" form-group">
                <label for="description">Description</label>
                <textarea type="text" class="form-control" name="description" cols="5" rows="5" id="description"
                    value="">{{isset($post) ? $post->description : ''}}{{old('description')}}</textarea>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <input id="content" type="hidden" name="content" class="form-control"
                    value="{{isset($post) ? $post->content : "" }} {{old('content')}}">
                <trix-editor input="content"></trix-editor>
            </div>
            <div class="form-group">
                <label for="published_at">Published at</label>
                <input type="text" class="form-control" name="published_at" id="published_at"
                    value="{{isset($post) ? $post->published_at : "" }} {{old('published_at')}}">
            </div>
            @if (isset($post))
            <div class="form-group">
                <img src="{{asset("storage/$post->image") }} " alt=" {{$post->image}} " width="auto" height="60px"
                    class="zoom">
            </div>
            @endif
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control" name="image" id="image">
            </div>
            <div class="form-group">
                <label for="category">Category </label>
                <select name="category" id="category" class="form-control">
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}" @if (isset($post)) @if ($category->id==$post->id)
                        selected
                        @endif
                        @endif
                        >{{$category->name}}</option>
                    @endforeach
                </select>

            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">
                    {{isset($post)?'Update Post':'Create Post'}}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr('#published_at',{
        enableTime:true
    })
</script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection
