@extends('admin.master')

@section('meta:title', 'Create Supervisor')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Supervisor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.supervisors.index') }}">Supervisors</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <supervisors-view
        fetch-url="{{ route('admin.supervisors.fetch-item') }}"
        submit-url="{{ route('admin.supervisors.store') }}"
        ></supervisors-view>
    </section>
</div>

@endsection