@extends('layouts.app')

@section('content')
<div class="container">
    @csrf
    <h3>Welcome to the admin area of social.app</h3>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Username: {{ $user->name }}</div>
                <div class="card-body">
                    <p>Email: {{ $user->email }}</p>
                    <p>Registered at: {{ $user->created_at }}</p>
                    <p>Last updated at: {{ $user->updated_at }}</p>
                    <p>This user has roles: </p>
                    <ul class="list">
                    @foreach ($roles as $role)
                        <li class="item active">{{ $role }}</li>
                    @endforeach
                   </ul>
                    <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-primary active">Edit User</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection