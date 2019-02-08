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
                    @foreach ($users as $user)
                        <p>Username: {{ $user->name }}</p>
                        <p>Email: {{ $user->email }}</p>
                        <p>Registered at: {{ $user->created_at }}</p>
                        <p>Last updated at: {{ $user->updated_at }}</p>
                        <br><hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection