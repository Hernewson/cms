@section('styles')
<style>
    .zoom {
        /* padding: 50px; */
        background-color: red;
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
@extends('layouts.app')


@section('content')
<div class="d-flex justify-content-end mb-2">
    <a href="{{route('posts.create')}}" class="btn btn-success">Add Post</a>
</div>

<div class="card card-default">
    <div class="card-header">
        Posts
    </div>
    <div class="card-body">
        @if ($posts->count() > 0)
        <table class="table">
            <thead>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th></th>
            </thead>
            <tbody>

                @foreach ($posts as $post)
                <tr>
                    <td>

                        <img src="{{asset("storage/$post->image") }} " alt="image" width="auto" height="60px"
                            class="zoom">
                    </td>
                    <td>{{$post->title}} </td>
                    <td>
                        <a href="{{route('categories.edit', $post->category->id)}}">
                            {{$post->category->name}}
                        </a>
                    </td>

                    @if ($post->trashed())
                    <td>
                        <form action="{{route('restore-post', $post->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-info btn-sm" style="color:#fff">Restore</button>
                        </form>
                    </td>
                    @else
                    <td>
                        <a href="{{route('posts.edit', $post->id)}}" class="btn btn-info btn-sm">Edit</a>
                    </td>
                    @endif

                    <td>
                        <form action="{{route('posts.destroy',$post->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                {{$post->trashed() ? 'Delete' : 'Trash'}}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>

        </table>
        @else
        <h3 class="text-center">
            No posts yet.
        </h3>
        @endif

    </div>
</div>

@endsection
