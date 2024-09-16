@extends('Admin.admin-layout')

@section('main')
<div class="container">
    <h1>Doctor Details</h1>
    <div class="mb-3">
        <strong>Name:</strong> {{ $doctor->name }}
    </div>
    <div class="mb-3">
        <strong>Price:</strong> {{ $doctor->price }}
    </div>
    <div class="mb-3">
        <strong>Details:</strong> {{ $doctor->details }}
    </div>
    <div class="mb-3">
        <strong>Waiting Time:</strong> {{ $doctor->waiting_time }}
    </div>
    <div class="mb-3">
        <strong>Address:</strong> {{ $doctor->address }}
    </div>
    <div class="mb-3">
        <strong>City:</strong> {{ $doctor->city->name }}
    </div>
    <div class="mb-3">
        <strong>Specialization:</strong> {{ $doctor->specialization->name }}
    </div>
    <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection