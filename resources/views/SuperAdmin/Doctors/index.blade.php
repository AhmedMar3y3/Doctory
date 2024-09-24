@extends('SuperAdmin.layout')

@section('main')
<div class="container">
    <h1>Doctors</h1>
    <a href="{{ route('superadmin.doctors.create') }}" class="btn btn-primary mb-3">Add Doctor</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>City</th>
                <th>Specialization</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctors as $doctor)
                <tr>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->city->name }}</td>
                    <td>{{ $doctor->specialization->name }}</td>
                    <td>
                        <a href="{{ route('superadmin.doctors.edit', $doctor->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('superadmin.doctors.delete', $doctor->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
