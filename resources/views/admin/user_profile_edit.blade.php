@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Welcome to the admin area of social.app</h3>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Username: {{ $user->name }}</div>
                <div class="card-body">
                    <form method="POST" action="/admin/users/{{ $user->id }}/edit">
                        @csrf
                        <label for="username">First Name: </label> 
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}">
                        <label for="username">Last Name: </label> 
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}">
                        <label for="email">Email: </label> 
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        @hasrole('admin')
                            <p>Add Role to this user:</p>
                            @foreach ($roles as $role)
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        @endhasrole    
                        <button class="btn btn-primary" type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection