@extends('layouts.app')

@section('content')
<div class="container">
    @csrf
    <h3>Welcome to the admin area of social.app</h3>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">List of the last added posts or:
                    <a href="/posts" >See all posts</a>
                </div>
                <div class="card-body">
                    @foreach ($posts as $post)
                        <h3>{{ $post->title }}</h3>
                        <p>{{ $post->content }}</p>
                        <p>From:{{ $post->user->name }} (id:{{ $post->user_id }})</p>
                        <p>Created at: {{ $post->created_at }} ({{ $post->created_at->diffForHumans() }})</p>
                        <br><hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection