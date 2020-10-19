@extends('layouts.app', ['activePage' => 'user-management', 'titlePage' => __('User Management')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-6 text-left">
                                <h4 class="card-title ">Venues</h4>
                                <p class="card-category">You can manage the event venues here</p>
                            </div>
                            <!--<div class="col-6 text-right">
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="material-icons ">add_box</i>User
                                </a>
                            </div>-->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <speaker-list></speaker-list>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection