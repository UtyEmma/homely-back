@include('layouts.header')

@php
    $auth = auth()->user();
@endphp


@include('layouts.sidebar')


<div id="main">
    @include('layouts.nav')

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Agents</h3>
                    <p class="text-subtitle text-muted">All Agents</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Agents</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div class="col-md-4">
                            <form action="/agents" method="get">
                                <div class="row gx-1">
                                    <div class="col-8">
                                        <select class="form-control form-select" name="sort">
                                            <option value="">All</option>
                                            <option value="confirmed">Approved Agents</option>
                                            <option value="not_confirmed">Unapproved Agents</option>
                                            <option value="email_verified">Email Verified</option>
                                            <option value="email_not_verified">Email Unverified</option>
                                            <option value="verified_agents">Verified Agents</option>
                                            <option value="unverified_agents">Unverified Agents</option>
                                            <option value="suspended">Suspended Agents</option>
                                            <option value="active">Active Agents</option>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-outline-primary" type="submit">Sort</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form action="/agents" method="get">
                                <div class="row gx-1">
                                    <div class="col-4">
                                        <input type="text" name="search" class="form-control" placeholder="Search">
                                    </div>
                                    <div class="col-4">
                                        <select name="search_param" required class="form-select"  id="">
                                            <option value="" selected>Search By</option>
                                            <option value="firstname">Firstname</option>
                                            <option value="lastname">Lastname</option>
                                            <option value="username">Username</option>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <button class="btn btn-outline-primary" type="submit">Sort</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-2">
                            {{$agents->links()}}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                    @if (isset($agents) && count($agents) > 0)
                        <thead>
                            <tr>
                              <th>Index</th>
                              <th>Agent Name</th>
                              <th>Location</th>
                              <th>Email Confirmed</th>
                              <th>Listings</th>
                              <th>Verified</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($agents as $agent)
                            @php
                                $slug = $agent->username;
                                $id = $auth->unique_id;
                                $url = env('FRONTEND_URL')."/$slug?auth=admin&id=$id";
                            @endphp
                            <tr>
                                <td>1</td>
                                <td><a href="{{$url}}" target="_blank">{{$agent->firstname}} {{$agent->lastname}} </a></td>
                                <td>{{$agent->city || $agent->state ? $agent->city.", ".$agent->state : "Not Available" }}</td>
                                <td>
                                    <div class="badge badge-shadow {{ $agent->isVerified ? 'bg-success' : 'bg-dark' }}">{{ $agent->isVerified ? 'Confirmed' : 'Not Confirmed' }}</div>
                                </td>
                                <td class="text-center">{{$agent->no_of_listings}}</td>
                                <td>
                                    <div class="badge badge-shadow {{ $agent->verified ? 'bg-success' : 'bg-dark' }}">{{ $agent->verified ? 'Verified' : 'Not Verified' }}</div>
                                </td>
                                <td>
                                  <div class="badge badge-shadow {{ $agent->status === 'active' ? 'bg-success' : 'bg-warning' }}">{{ $agent->status }}</div>
                                </td>
                                <td>
                                    <div class="dropdown" style="z-index: 9999999; position: absolute; margin-top: -10px;">
                                        <button class="btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <div class="dropdown-menu shadow  dropdown-menu-right"  aria-labelledby="dropdownMenuButton">
                                            <a href="{{$url}}" target="_blank" class="dropdown-item" title="Preview">View</a>


                                            <a onclick="return confirm('Are you sure you wish to proceed?')" href="/agents/confirm-email/{{$agent->unique_id}}" class="dropdown-item" title="Preview">Confirm Email</a>

                                            <a onclick="return confirm('Are you sure you wish to proceed?')" href="/agents/verify/{{$agent->unique_id}}"  class="dropdown-item" title="Preview">{{$agent->verified ? "Unverify Agent" : "Verify Agent"}}</a>
                                            <a onclick="return confirm('Are you sure you wish to proceed?')" href="/agents/suspend/{{$agent->unique_id}}" class="dropdown-item">{{ $agent->status === 'active' ? 'Block' : 'Unblock' }}</a>
                                            <a onclick="return confirm('Are you sure you wish to proceed?')" href="/agents/delete/{{$agent->unique_id}}" class="dropdown-item">Delete</a>
                                        </div>
                                    </div>

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
