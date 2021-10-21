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
                    <h3>Properties</h3>
                    <p class="text-subtitle text-muted">Current Listings</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Properties</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-4">
                        <form action="/listings" method="get">
                            <div class="row gx-1">
                                <div class="col-8">
                                    <select class="form-control form-select" name="sort">
                                        <option value="">All</option>
                                        <option value="confirmed">Approved Agents</option>
                                        <option value="not_confirmed">Unapproved Properties</option>
                                        <option value="rented">Rented Properties</option>
                                        <option value="not_rented">Available Properties</option>
                                        <option value="suspended">Suspended Properties</option>
                                        <option value="active">Active Properties</option>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <button class="btn btn-outline-primary" type="submit">Sort</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <form action="/tenants" method="get">
                            <div class="row gx-1">
                                <div class="col-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search">
                                </div>
                                <div class="col-4">
                                    <select name="search_param" required class="form-select"  id="">
                                        <option value="" selected>Search By</option>
                                        <option value="title">Title</option>
                                        <option value="type">Category</option>
                                        <option value="state">State</option>
                                        <option value="city">City</option>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <button class="btn btn-outline-primary" type="submit">Sort</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-2">
                        {{$listings->links()}}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                    @if (isset($listings) && count($listings) > 0)
                        <thead>
                            <tr>
                                <th>Index</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Reviews</th>
                                <th>Confirm</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($listings as $listing)
                            @php
                                $slug = $listing->slug;
                                $username = $listing->username;
                                $id = $auth->unique_id;
                                $url = env('FRONTEND_URL')."/$username/$slug?auth=admin&id=$id";
                            @endphp


                            <tr>
                                <td>{{$listing->index}}</td>
                                <td>
                                    <a href="{{$url}}" target="_blank">{{$listing->title}}</a>
                                </td>
                                <td><img alt="{{$listing->title}}" src="{{$listing->images[0]}}" width="35"></td>
                                <td>
                                    {{$listing->reviews}} Review{{$listing->reviews !== 1 ? 's' : '' }}
                                </td>
                                <td>
                                    @if ($listing->status !== "pending")
                                       <div class="badge bg-success">Confirmed </div>
                                    @else
                                        <a href="listings/confirm/{{$listing->unique_id}}" class="btn btn-sm btn-success">Confirm</a>
                                    @endif
                                </td>
                                <td>
                                  <div class="badge badge-shadow {{ $listing->status === 'active' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $listing->status }}
                                  </div>
                                </td>
                                <td>
                                  <a href="listings/suspend/{{$listing->unique_id}}" class="btn btn-sm btn-warning">{{ $listing->status === 'suspended' ? 'Unblock' : 'Block' }}</a>
                                  <a href="listings/delete/{{$listing->unique_id}}" class="btn btn-sm btn-danger">
                                    Delete
                                </a>
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

    <script>
        function openPage(target){
            return window.location.href = "http://"+target
        }
    </script>

@include('layouts.footer')
