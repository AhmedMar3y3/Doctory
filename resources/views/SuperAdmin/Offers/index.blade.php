@extends('SuperAdmin.layout')

@section('main')
<div class="container">
    <h1>Offers</h1>
    <a href="{{ route('superadmin.offers.create') }}" class="btn btn-primary mb-3">Add Offer</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Old Price</th>
                <th>New Price</th>
                <th>Address</th>
                <th>City</th>
                <th>Specialization</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($offers as $offer)
                <tr>
                    <td>{{ $offer->title }}</td>
                    <td>{{ $offer->OldPrice }}</td>
                    <td>{{ $offer->NewPrice }}</td>
                    <td>{{ $offer->address }}</td>
                    <td>{{ $offer->city->name }}</td>
                    <td>{{ $offer->specialization->name }}</td>
                    <td><img src="{{ asset('storage/' . $offer->image) }}" alt="Image" style="width: 100px;"></td>
                    <td>
                        <a href="{{ route('superadmin.offers.edit', $offer->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('superadmin.offers.delete', $offer->id) }}" method="POST" style="display:inline;">
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
