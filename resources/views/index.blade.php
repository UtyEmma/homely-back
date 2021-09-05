@include('layouts.header')

@php
    $auth = auth()->user();
@endphp

@include('layouts.sidebar')

<div id="main" class="layout-navbar">
    @include('layouts.nav')

<div id="main-content">
    <div class="page-heading">
        <h3>Summary</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon purple">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Tenants</h6>
                                        <h6 class="font-extrabold mb-0">{{$no_tenants}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon blue">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Total Agents</h6>
                                        <h6 class="font-extrabold mb-0">{{$no_agents}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="bi bi-building"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Properties</h6>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="font-extrabold mb-0">
                                                {{$no_listings}}
                                            </h6>
    
                                            <a href="/listings" class="fw-bold text-decoration-underline" style="font-size: 14px;">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon red">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Reviews</h6>
                                        <h6 class="font-extrabold mb-0">{{$reviews}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="bi bi-eye"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Property Views</h6>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="font-extrabold mb-0">
                                                {{$views}}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-3 py-4-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stats-icon green">
                                            <i class="bi bi-collection"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h6 class="text-muted font-semibold">Categories</h6>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="font-extrabold mb-0">
                                                {{$categories}}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Profile Visit</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Support /<span style="font-size: 14px;"> Open Tickets<span></h4>
                                <a href="/support" class="btn btn-outline-primary btn-sm">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <tbody>
                                            @if ($tickets && count($tickets) > 0)
                                                @foreach ($tickets as $ticket)
                                                    <tr>
                                                        <td class="col-1">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-md">
                                                                    <img src="{{$ticket['agent']->avatar[0]}}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="col-auto">
                                                            <a href="/support/ticket/{{$ticket['ticket']->unique_id}}" class=" mb-0">{{$ticket['ticket']->title}}</a>
                                                            <p style="font-size: 13px;" class="list-group-item-text mb-0 truncate">
                                                                <span class="fw-bold">Created -</span> {{$ticket['ticket']->created_at->date}} <span class="fw-bold">by -</span>
                                                                {{$ticket['agent']->firstname}} {{$ticket['agent']->lastname}}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Profile Visit</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-primary" width="32" height="32" fill="blue"
                                                style="width:10px">
                                                <use
                                                    xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            <h5 class="mb-0 ms-3">Europe</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-0">862</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-europe"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-success" width="32" height="32" fill="blue"
                                                style="width:10px">
                                                <use
                                                    xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            <h5 class="mb-0 ms-3">America</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-0">375</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-america"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-danger" width="32" height="32" fill="blue"
                                                style="width:10px">
                                                <use
                                                    xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            <h5 class="mb-0 ms-3">Indonesia</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="mb-0">1025</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-indonesia"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-header bg-primary pb-2">
                        <h4 class="text-white">Quick Actions</h4>
                    </div>
                    <div class="card-content pb-4">
                        @php
                            $id = $auth->unique_id;
                            $url = "http://localhost:3000?auth=admin&id=$id";
                        @endphp
                        <div class="px-4">
                            <a href="{{$url}}" target="_blank" class='btn btn-block btn-md d-flex align-items-center justify-content-center btn-outline-primary font-bold mt-3'>Visit Bayof <i class="ms-2 bi bi-box-arrow-in-up-right"></i></a>
                            <a data-bs-toggle="modal" data-bs-target="#create-admin" type="button" class='btn btn-block btn-md d-flex align-items-center justify-content-center btn-outline-success font-bold mt-3'>Register Admin <i class="ms-2 bi bi-person-badge"></i></a>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" class='btn btn-block btn-md d-flex align-items-center justify-content-center btn-outline-primary font-bold mt-3'>Create Category <i class="ms-2 bi bi-collection"></i></button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#createamenity" class='btn btn-block btn-md d-flex align-items-center justify-content-center btn-outline-warning font-bold mt-3'>Create Amenity<i class="ms-2 bi bi-inbox"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Visitors Profile</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-visitors-profile"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="categories/create" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Category Title</label>
                    <input type="text" name="category_title" class="form-control">
                </div>

                <div class="form-group">
                    <label>Category Description</label>
                    <textarea type="text" name="category_desc" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary">Save</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
    </div>
</div>


<div class="modal fade" id="createamenity" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Create Amenity</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="/amenities/create-amenities" method="post">
                @csrf
                <div class="col-12">
                    <div class="row gx-md-1 bg-white">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-8">
                                    <input type="text" name="amenity_title" class="form-control" placeholder="New Amenity">
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>

@include('layouts.footer')