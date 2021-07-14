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
                    <h4>Agents Table</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">

                        @if (isset($agents) && count($agents) > 0)
                            <thead>
                                <tr>
                                    <th class="text-center">
                                    #
                                    </th>
                                    <th>Agent Name</th>
                                    <th>Location</th>
                                    <th>No of Listings</th>
                                    <th>Verified</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($agents as $agent)
                            <tbody>
                            <tr>
                                <td>
                                    1
                                </td>
                                <td><a href="agents/{{$agent->unique_id}}">{{$agent->firstname}} {{$agent->lastname}}</a></td>
                                <td>{{$agent->location}}</td>
                                <td class="text-center">{{$agent->no_of_listings}}</td>
                                
                                <td>

                                </td>
                                
                                <td>
                                <div class="badge badge-shadow {{ $agent->status ? 'badge-success' : 'badge-warning' }}">{{ $agent->status ? 'active' : 'suspended' }}</div>
                                </td>

                                <td>
                                  <a href="agents/suspend/{{$agent->unique_id}}" class="btn btn-primary">{{ $agent->status ? 'Block' : 'Unblock' }}</a>
                                  <a href="agents/delete/{{$agent->unique_id}}" class="btn btn-primary">Delete</a>
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