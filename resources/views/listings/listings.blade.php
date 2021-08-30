@include('layouts.header')

@php
    $auth = auth()->user();
@endphp

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
                    <h3>Properties</h3>
                    <p class="text-subtitle text-muted">Current Listings</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <!-- <li class="breadcrumb-item active" aria-current="page">DataTable</li> -->
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
                    @if (isset($listings) && count($listings) > 0)
                        <thead>
                            <tr>
                                <th>Index</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($listings as $listing)
                            @php
                                $slug = $listing->slug;
                                $id = $auth->unique_id;
                                $url = "http://localhost:3000/listings/$slug?auth=admin&id=$id";
                            @endphp

                            
                            <tr>
                                <td>{{$listing->index}}</td>
                                <td>
                                    <a href="{{$url}}" target="_blank">{{$listing->title}}</a>
                                </td>
                                <td><img alt="{{$listing->title}}" src="{{$listing->images[0]}}" width="35"></td>
                                <td>
                                  <div class="badge badge-shadow {{ $listing->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $listing->status ? 'active' : 'suspended' }}
                                  </div>
                                </td>
                                <td>
                                  <a href="listings/suspend/{{$listing->unique_id}}" class="btn btn-primary">{{ $listing->status ? 'Block' : 'Unblock' }}</a>
                                  <a href="listings/delete/{{$listing->unique_id}}" class="btn btn-secondary">Delete</a>
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