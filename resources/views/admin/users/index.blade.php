@extends('admin.master')

@section('meta:title', 'Users')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="mb-4">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary text-white">
                <i class="fa fa-plus mr-1"></i>
                Create
            </a>
        </div>

        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a @click="initList('table-1')" class="nav-link active" data-target="#tab1" href="javascript:void(0)" data-toggle="tab">Active</a></li>
                    <li class="nav-item"><a @click="initList('table-2')" class="nav-link" data-target="#tab2" href="javascript:void(0)" data-toggle="tab">Archive</a></li>
                    <li class="nav-item"><a @click="initList('table-3')" class="nav-link" data-target="#tab3" href="javascript:void(0)" data-toggle="tab">Activity Logs</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="tab1">
                        <user-table 
                        ref="table-1"
                        export-url="{{ route('admin.users.export') }}"
                        fetch-url="{{ route('admin.users.fetch') }}"
                        ></user-table>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <user-table
                        ref="table-2" 
                        disabled
                        fetch-url="{{ route('admin.users.fetch-archive') }}"
                        ></user-table>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <activity-log-table 
                        ref="table-3"
                        disabled
                        show-subject
                        fetch-url="{{ route('admin.activity-logs.fetch.users') }}"
                        ></activity-log-table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection