@php
error_reporting(0);
@endphp
@extends('layouts.dashboard_app')


@section('title')
Contact Info | {{env("APP_NAME")}}
@endsection

@section('contactinfo')
active
@endsection


@section('dashboard_content')

<div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
        <a class="breadcrumb-item" href="{{url('home')}}">Home</a>
        <span class="breadcrumb-item active">Contact Info</span>
    </nav>

    <div class="sl-pagebody">
        <div class="sl-page-title">
            <h5>Contact Info</h5>
            <p>Manage Contact Info.</p>
        </div><!-- sl-page-title -->


        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card pd-20 pd-sm-40">
                        <div class="card-body-title">Update Contact Info</div>
                        <form method="POST" action="{{route('update_contactinfo')}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Address</label>
                                <textarea name="address" class="form-control">{{$contact_info->address}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="text" name="email" class="form-control" value="{{$contact_info->email}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{$contact_info->phone}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Map Embedd HTML</label>
                                <textarea name="map_embedd_link" class="form-control">{{$contact_info->map_embedd_link}}</textarea>
                                <small id="emailHelp" class="form-text text-muted">Paste your embedded map HTML here.</small>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- sl-pagebody -->


</div><!-- sl-mainpanel -->

@endsection




@section('script')
<script>
    $(function () {
        'use strict';

        $('#datatable1').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        // Select2
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity
        });

    });

</script>
@endsection
