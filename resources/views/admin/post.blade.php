@extends('layouts.app')

@section('content')
<div class="container">
    @csrf
    <h3>Welcome to the admin area of social.app</h3>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><h3>{{ $post->title }}</h3> or
                    <a href="/admin/posts" >See all posts</a>
                </div>
                <div class="card-body">
                    <p>{{ $post->content }}</p>
                    <p>From:{{ $post->user->name }} (id:{{ $post->user_id }})</p>
                    <p>Created at: {{ $post->created_at }} ({{ $post->created_at->diffForHumans() }})</p>
                    <a href="/admin/posts/{{ $post->id }}/edit" class="btn btn-primary" type="submit">Edit Post</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection