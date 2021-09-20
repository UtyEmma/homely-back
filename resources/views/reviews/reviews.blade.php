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
                    <h3>Reviews</h3>
                    <p class="text-subtitle text-muted">All Reviews</p>
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
                    Reviews
                </div>
                <div class="card-body">
                    @if (isset($reviews) && count($reviews) > 0)
                    <table class="table table-striped" id="table1">
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
                            @php
                                $slug = $review->listing_slug;
                                $username = $review->agent_username;
                                $id = $auth->unique_id;
                                $url = "http://localhost:3000/$username/$slug?auth=admin&id=$id";
                            @endphp
                            <tr>
                                <td>{{++$i}}</td>
                                <td><a href="/tenants/{{$review->reviewer_id}}">{{$review->publisher_name}}</a></td>
                                <td><a href="{{$url}}">{{$review->listing_title}}</a></td>
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
                            <div class="card-body text-center">
                                <div class="empty-state" data-height="400">
                                <div class="empty-state-icon">
                                    <i class="fas fa-question"></i>
                                </div>
                                    <h2>No Reviews Available</h2>
                                    <p class="lead">
                                        No Tenant has made a review
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                </div>
            </div>
        </section>
    </div>



@include('layouts.footer')
