@extends('layouts.app')

@section('title', __('إضافة سيارة جديدة'))

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4">➕ إضافة سيارة</h1>

        <form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-4 bg-white p-6 rounded shadow">
            @csrf

            @include('admin.vehicles.partials.form')


        </form>
    </div>
@endsection
