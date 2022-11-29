@extends('admin.master')

@section('meta:title', $item->renderName())

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $item->renderName() }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $item->renderName() }}</a></li>
                </ol>
            </div>
        </div>
    </section>

    <page-pagination fetch-url="{{ route('admin.users.fetch-pagination', $item->id) }}"></page-pagination>

    <section class="content">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" data-target="#tab1-info" href="javascript:void(0)" data-toggle="tab">Information</a></li>
                    <li class="nav-item"><a @click="initList('table-1')" class="nav-link" data-target="#tab2-activity" href="javascript:void(0)" data-toggle="tab">Activity Logs</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="tab1-info">
                       <user-view
                       fetch-url="{{ route('admin.users.fetch-item', $item->id) }}"
                       submit-url="{{ route('admin.users.update', $item->id) }}"
                       ></user-view>
                    </div>
                    <div class="tab-pane" id="tab2-activity">
                        <activity-log-table 
                        ref="table-1"
                        disabled
                        fetch-url="{{ route('admin.activity-logs.fetch.users', $item->id) }}"
                        ></activity-log-table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Documents</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Documents</a></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a @click="initList('table-1')" class="nav-link active" href="#tab1" data-toggle="tab">Submitted</a></li>
                        <li class="nav-item"><a @click="initList('table-2')" class="nav-link" href="#tab2" data-toggle="tab">Approved</a></li>
                        <li class="nav-item"><a @click="initList('table-3')" class="nav-link" href="#tab3" data-toggle="tab">Rejected</a></li>
                        <li class="nav-item"><a @click="initList('table-4')" class="nav-link" href="#tab4" data-toggle="tab">Archived</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="tab1">
                            <documents-table 
                            ref="table-1"
                            fetch-url="{{ route('admin.documents.fetch', ['status' => 0, 'user' => $item->id]) }}"
                            ></documents-table>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <documents-table 
                            ref="table-2"
                            disabled
                            hide-buttons="true"
                            fetch-url="{{ route('admin.documents.fetch', ['status' => 1, 'user' => $item->id]) }}"
                            ></documents-table>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <documents-table 
                            ref="table-3"
                            disabled
                            hide-buttons="true"
                            fetch-url="{{ route('admin.documents.fetch', ['status' => 2, 'user' => $item->id]) }}"
                            ></documents-table>
                        </div>
                        <div class="tab-pane" id="tab4">
                            <documents-table
                            ref="table-4"
                            disabled
                            fetch-url="{{ route('admin.documents.fetch-archive') }}"
                            ></documents-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection