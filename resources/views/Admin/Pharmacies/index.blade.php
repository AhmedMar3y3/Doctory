@extends('Admin.admin-layout')

@section('main')
<div class="container">
    <h1>Pharmacies</h1>
    <a href="{{ route('admin.pharmacies.create') }}" class="btn btn-primary mb-3">Add Pharmacy</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pharmacies as $pharmacy)
                <tr>
                    <td>{{ $pharmacy->name }}</td>
                    <td>{{ $pharmacy->phone }}</td>
                    <td><img src="{{ asset('storage/' . $pharmacy->image) }}" alt="Image" style="width: 100px;"></td>
                    <td>
                        <a href="{{ route('admin.pharmacies.edit', $pharmacy->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.pharmacies.destroy', $pharmacy->id) }}" method="POST" style="display:inline;">
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
