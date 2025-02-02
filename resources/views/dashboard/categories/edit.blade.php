@extends('layouts.dashboard')

@section('title', 'Edit Category')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">Edit Category</li>
@endsection

@section('content')
    <form action="{{route('categories.update',$category->id)}}" method="post" class="ml-3" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dashboard.categories._form')
    </form>
@endsection
