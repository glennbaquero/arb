@extends('admin.master')

@section('meta:title', 'My Account')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>My Account</h1>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" data-target="#tab1" href="javascript:void(0)" data-toggle="tab">Information</a></li>
                    <li class="nav-item"><a class="nav-link" data-target="#tab2" href="javascript:void(0)" data-toggle="tab">Change Password</a></li>
                     <li class="nav-item"><a @click="initList('table-1')" class="nav-link" data-target="#tab3" href="javascript:void(0)" data-toggle="tab">Activity Logs</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="tab1">
                       <admin-user-view
                       :editable="false"
                       fetch-url="{{ route('admin.profiles.fetch') }}"
                       submit-url="{{ route('admin.profiles.update') }}"
                       ></admin-user-view>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <change-password-form submit-url="{{ route('admin.profiles.change-password') }}"></change-password-form>
                    </div>
                    <div class="tab-pane" id="tab3">
                        <activity-log-table 
                        ref="table-1"
                        disabled
                        fetch-url="{{ route('admin.activity-logs.fetch.profiles') }}"
                        ></activity-log-table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection