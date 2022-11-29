@extends('admin.master')

@section('meta:title', 'Create Announcement')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create About Us</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.about-us.index') }}">About Us</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <about-us-view
        fetch-url="{{ route('admin.about-us.fetch-item') }}"
        submit-url="{{ route('admin.about-us.store') }}"
        ></about-us-view>
    </section>
</div>

@endsection