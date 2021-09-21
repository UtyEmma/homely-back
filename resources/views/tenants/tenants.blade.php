@include('layouts.header')


@include('layouts.sidebar')


<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Tenants</h3>
                    <p class="text-subtitle text-muted">All Tenants</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tenants</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Filter
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                    @if (isset($tenants) && count($tenants) > 0)
                        <thead>
                            <tr>
                              <th>Index</th>
                              <th>Tenant Name</th>
                              <th>Profile Image</th>
                              <th>Location</th>
                              <th>Wishlists</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($tenants as $tenant)
                            <tr>
                                <td>1</td>
                                <td><a href="tenants/{{$tenant->unique_id}}">{{$tenant->firstname}} {{$tenant->lastname}}</a></td>
                                <td>
                                  <img alt="{{$tenant->firstname}}" src="{{$tenant->avatar}}" width="35">
                                </td>
                                <td>{{$tenant->location}}</td>
                                <td class="text-center">{{$tenant->wishlists}}</td>

                                <td>
                                  <div class="badge badge-shadow {{ $tenant->status ? 'bg-success' : 'bg-warning' }}">{{ $tenant->status ? 'active' : 'suspended' }}</div>
                                </td>
                                <td>
                                  <a href="tenants/suspend/{{$tenant->unique_id}}" onclick="return confirm('Are you sure you wish to proceed?')" class="btn btn-sm btn-primary">{{ $tenant->status ? 'Block' : 'Unblock' }}</a>
                                  <a href="tenants/delete/{{$tenant->unique_id}}" onclick="return confirm('Are you sure you wish to proceed?')" class="btn btn-danger btn-sm">Delete</a>
                                  <a href="tenants/{{$tenant->unique_id}}" class="btn btn-primary btn-sm">View</a>
                              </td>
                            </tr>
                            @endforeach
                        @else
                        <div class="card shadow-none">
                            <div class="card-body text-center">
                                <div class="empty-state" data-height="400">
                                <div class="empty-state-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h2>We couldn't find any data</h2>
                                <p class="lead">
                                    No Tenants Available.
                                </p>
                                </div>
                            </div>
                        </div>
                        @endif
                  </tbody>
                </table>
                </div>
                    </div>
        </section>
    </div>


@include('layouts.footer')
