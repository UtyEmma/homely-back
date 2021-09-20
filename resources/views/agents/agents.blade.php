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
                    Filter
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                    @if (isset($agents) && count($agents) > 0)
                        <thead>
                            <tr>
                              <th>Index</th>
                              <th>Agent Name</th>
                              <th>Location</th>
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
                                $url = "http://localhost:3000/$slug?auth=admin&id=$id";
                            @endphp
                            <tr>
                                <td>1</td>
                                <td><a href="{{$url}}" target="_blank">{{$agent->firstname}} {{$agent->lastname}} </a></td>
                                <td>{{$agent->city}}, {{$agent->state}}</td>
                                <td class="text-center">{{$agent->no_of_listings}}</td>
                                <td>
                                    <div class="badge badge-shadow {{ $agent->verified ? 'bg-success' : 'bg-dark' }}">{{ $agent->verified ? 'true' : 'false' }}</div>
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

                                            @if (!$agent->isVerified)
                                                <a href="/agents/confirm-email/{{$agent->unique_id}}" class="dropdown-item" title="Preview">Confirm Email</a>
                                            @endif

                                            <a href="/agents/verify/{{$agent->unique_id}}"  class="dropdown-item" title="Preview">{{$agent->verified ? "Unverify Agent" : "Verify Agent"}}</a>
                                            <a href="/agents/suspend/{{$agent->unique_id}}" class="dropdown-item">{{ $agent->status === 'active' ? 'Block' : 'Unblock' }}</a>
                                            <a onclick="confirm('Are you sure you want to continue?')" href="/agents/delete/{{$agent->unique_id}}" class="dropdown-item">Delete</a>
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
