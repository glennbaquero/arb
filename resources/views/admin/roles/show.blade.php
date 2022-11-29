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
                    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Roles &amp; Permissions</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $item->renderName() }}</a></li>
                </ol>
            </div>
        </div>
    </section>

    <page-pagination fetch-url="{{ route('admin.roles.fetch-pagination', $item->id) }}"></page-pagination>
    
    <section class="content">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" data-target="#tab1" href="javascript:void(0)" data-toggle="tab">Information</a></li>
                    
                    @if ($item->isPermissionEditable())
                        <li class="nav-item"><a class="nav-link" data-target="#tab2" href="javascript:void(0)" data-toggle="tab">Permissions</a></li>
                    @endif

                    <li class="nav-item"><a @click="initList('table-1')" class="nav-link" data-target="#tab3" href="javascript:void(0)" data-toggle="tab">Activity Logs</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="tab1">
                        <role-view
						fetch-url="{{ route('admin.roles.fetch-item', $item->id) }}"
						submit-url="{{ route('admin.roles.update', $item->id) }}"
						></role-view>
                    </div>

                    @if ($item->isPermissionEditable())
                        <div class="tab-pane" id="tab2">
                            <permission-list 
    						fetch-url="{{ route('admin.permissions.fetch', $item->id) }}"
    						submit-url="{{ route('admin.roles.update-permissions', $item->id) }}"
    						></permission-list>
                        </div>
                    @endif

                    <div class="tab-pane" id="tab3">
                        <activity-log-table 
                        ref="table-1"
                        disabled
                        fetch-url="{{ route('admin.activity-logs.fetch.roles', $item->id) }}"
                        ></activity-log-table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection