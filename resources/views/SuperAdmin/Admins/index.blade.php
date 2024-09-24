@extends('SuperAdmin.layout')

@section('main')
<div class="container">        
    <a href="{{ route('superadmin.admins.createAdminForm') }}" class="btn btn-primary">Create Admin</a>
    
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Email</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->name }}</td>
                <td>
                    <form action="{{ route('superadmin.admins.deleteAdmin', $admin->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection