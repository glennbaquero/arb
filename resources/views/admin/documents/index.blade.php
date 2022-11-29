@extends('admin.master')

@section('meta:title', 'Documents')

@section('content')

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
                            fetch-url="{{ route('admin.documents.fetch', ['status' => 0]) }}"
                            ></documents-table>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <documents-table 
                            ref="table-2"
                            disabled
                            hide-buttons="true"
                            fetch-url="{{ route('admin.documents.fetch', ['status' => 1]) }}"
                            ></documents-table>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <documents-table 
                            ref="table-3"
                            disabled
                            hide-buttons="true"
                            fetch-url="{{ route('admin.documents.fetch', ['status' => 2]) }}"
                            ></documents-table>
                        </div>
                        <div class="tab-pane" id="tab4">
                            <documents-table
                            ref="table-4"
                            disabled
                            hide-buttons="true"
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