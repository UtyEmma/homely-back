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
                    <h3><i class="bi bi-people"></i> Admins</h3>
                    <p class="text-subtitle text-muted">All Admins</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Admins</li>
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
                    @if (isset($admins) && count($admins) > 0)
                        <thead>
                            <tr>
                              <th>Index</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Role</th>
                              <th>Permissions</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>1</td>
                                <td><a href="admins/{{$admin->unique_id}}">{{$admin->firstname}} {{$admin->lastname}}</a></td>
                                <td>{{$admin->email}}</td>
                                <td class="text-center">{{$admin->phone}}</td>
                                <td>
                                </td>
                                <td>
                                  <div class="badge badge-shadow {{ $admin->status ? 'bg-success' : 'bg-warning' }}">{{ $admin->status ? 'active' : 'suspended' }}</div>
                                </td>
                                <td>
                                  <a href="admin/suspend/{{$admin->unique_id}}" class="btn btn-primary">{{ $admin->status ? 'Block' : 'Unblock' }}</a>
                                  <a href="admin/delete/{{$admin->unique_id}}" class="btn btn-primary">Delete</a>
                              </td>
                            </tr>
                            @endforeach
                        @else
                        <div class="card shadow-none">
                            <div class="card-body">
                                <div class="empty-state" data-height="400">
                                <div class="empty-state-icon">
                                    <i class="fas fa-question"></i>
                                </div>
                                <h2>We couldn't find any data</h2>
                                <p class="lead">
                                    Sorry we can't find any data, to get rid of this message, make at least 1 entry.
                                </p>
                                <a href="#" class="btn btn-primary mt-4">Create new One</a>
                                <a href="#" class="mt-4 bb">Need Help?</a>
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