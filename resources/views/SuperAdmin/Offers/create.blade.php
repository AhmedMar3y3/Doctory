@extends('SuperAdmin.layout')

@section('main')
<div class="container">
    <h1>Add Offer</h1>
    <form action="{{ route('superadmin.offers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="OldPrice" class="form-label">Old Price</label>
            <input type="text" class="form-control" id="OldPrice" name="OldPrice" value="{{ old('OldPrice') }}">
            @error('OldPrice')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="NewPrice" class="form-label">New Price</label>
            <input type="text" class="form-control" id="NewPrice" name="NewPrice" value="{{ old('NewPrice') }}">
            @error('NewPrice')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
            @error('address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <select id="city" name="city" class="form-control">
                @foreach($cities as $city)
                    <option value="{{ $city->name }}">{{ $city->name }}</option>
                @endforeach
            </select>
            @error('city')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="specialization" class="form-label">Specialization</label>
            <select id="specialization" name="specialization" class="form-control">
                @foreach($specializations as $specialization)
                    <option value="{{ $specialization->name }}">{{ $specialization->name }}</option>
                @endforeach
            </select>
            @error('specialization')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('superadmin.offers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection