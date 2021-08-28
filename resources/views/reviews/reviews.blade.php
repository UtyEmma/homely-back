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
                    <h3>Reviews</h3>
                    <p class="text-subtitle text-muted">Current Listings</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Reviews</li>
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
                    @if (isset($reviews) && count($reviews) > 0)
                        <thead>
                            <tr>
                                <th>Index</th>
                                <th>Reviewer</th>
                                <th>Listing</th>
                                <th>Message</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{$i = 0}}
                        @foreach ($reviews as $review)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$review->publisher_name}}</td>
                                <td>{{$review->listing_title}}</td>
                                <td>{{ $review->review }}</td>
                                <td>{{$review->rating}}/5</td>
                                <td><span class="badge {{$review->status ? 'bg-primary' : 'bg-warning'}}">{{$review->status ? 'Active' : 'Suspended'}}</span></td>
                                <td>
                                  <a href="reviews/block/{{$review->unique_id}}" class="btn btn-primary">{{ $review->status ? 'Block' : 'Unblock' }}</a>
                                  <a href="reviews/delete/{{$review->unique_id}}" class="btn btn-secondary">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
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
                </div>
                    </div>
        </section>
    </div>



@include('layouts.footer')