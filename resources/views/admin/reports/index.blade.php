@extends('admin.master')

@section('meta:title', 'Reports')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Reports</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Reports</a></li>
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
                        <li class="nav-item"><a @click="initList('table-1')" class="nav-link active" href="#tab1" data-toggle="tab">Files upload per user</a></li>
                        <li class="nav-item"><a @click="initList('table-2')" class="nav-link" href="#tab2" data-toggle="tab">Storage consumed per user</a></li>
                        <li class="nav-item"><a @click="initList('table-3')" class="nav-link" href="#tab3" data-toggle="tab">Usage time per user</a></li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="tab1">
                            <reports-table 
                            ref="table-1"
                            fetch-url="{{ route('admin.reports.fetch') }}"
                            export-url="{{ route('admin.reports.export') }}"
                            :types="{{ json_encode($types) }}"
                            :approvers="{{ json_encode($approvers) }}"
                            ></reports-table>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <storage-consumed-table 
                            disabled
                            ref="table-2"
                            fetch-url="{{ route('admin.storage-consume.fetch') }}"
                            export-url="{{ route('admin.storage-consumed.export') }}"
                            ></storage-consumed-table>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <time-usage-table 
                            disabled
                            ref="table-3"
                            fetch-url="{{ route('admin.time-usage.fetch') }}"
                            export-url="{{ route('admin.time-usage.export') }}"
                            ></time-usage-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection