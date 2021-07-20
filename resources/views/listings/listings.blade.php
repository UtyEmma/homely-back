@include('layouts.header')

<div id="app">
    <div class="main-wrapper main-wrapper-1">
@include('layouts.nav')

@include('layouts.sidebar')


<div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="text-uppercase">Listings Table</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">

                        @if (isset($listings) && count($listings) > 0)
                            <thead>
                                <tr>
                                    <th class="text-center">
                                    #
                                    </th>
                                    <th>Listing Title</th>
                                    <th>Listing Image</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($listings as $listing)
                            <tbody>
                            <tr>
                                <td>
                                    {{$listing->index}}
                                </td>
                                <td>{{$listing->title}}</td>
                                <td>
                                    <img alt="{{$listing->title}}" src="{{$listing->images[0]->url}}" width="35">
                                </td>
                                <td>2018-01-20</td>
                                    <td>
                                        <div class="badge badge-shadow {{ $listing->status ? 'badge-success' : 'badge-danger' }}">
											{{ $listing->status ? 'active' : 'suspended' }}
										</div>
                                    </td>
                                <td>
									<a href="listings/suspend/{{$listing->unique_id}}" class="btn btn-primary">{{ $listing->status ? 'Block' : 'Unblock' }}</a>
									<a href="listings/delete/{{$listing->unique_id}}" class="btn btn-secondary">Delete</a>
                                </td>
                            </tr>
                            </tbody>
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
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


@include('layouts.footer')