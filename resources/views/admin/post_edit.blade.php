@extends('layouts.app')

@section('content')
<div class="container">
    @csrf
    <h3>Welcome to the admin area of social.app</h3>
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header"><h3>{{ $post->title }}</h3>
                </div>
                
                <form method="POST" action="/admin/posts/{{ $post->id }}/edit">
                    @csrf
                    <div class="form-group col-md-7">
                        <input type="text" class="form-control" id="postTitle" name="postTitle" value="{{ $post->title }}">
                        <label for="createPost">Post something: </label>
                        <textarea class="form-control" name="postContent" rows="3" id="postContent">{{ $post->content }}</textarea>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div> 
                </form>
                <div class="card-body">
                    <p>From:{{ $post->user->name }} (id:{{ $post->user_id }})</p>
                    <p>Created at: {{ $post->created_at }} ({{ $post->created_at->diffForHumans() }})</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection