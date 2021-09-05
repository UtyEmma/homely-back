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
                                    <div class="badge badge-shadow {{ $agent->verified ? 'bg-info' : 'bg-dark' }}">{{ $agent->verified ? 'true' : 'false' }}</div>
                                </td>
                                <td>
                                  <div class="badge badge-shadow {{ $agent->status === 'active' ? 'bg-success' : 'bg-warning' }}">{{ $agent->status }}</div>
                                </td>
                                <td>
                                    <a href="agents/suspend/{{$agent->unique_id}}" class="btn btn-primary btn-sm">{{ $agent->status === 'active' ? 'Block' : 'Unblock' }}</a>
                                    <a href="agents/delete/{{$agent->unique_id}}" class="btn btn-danger btn-sm">Delete</a>
                                    <a href="{{$url}}" target="_blank" class="btn btn-primary btn-sm" title="Preview">
                                        View
                                    </a>
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