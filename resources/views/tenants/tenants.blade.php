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
                    <h4>Tenant Table</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">

                        @if (isset($tenants) && count($tenants) > 0)
                            <thead>
                                <tr>
                                    <th class="text-center">
                                    #
                                    </th>
                                    <th>Tenant Name</th>
                                    <th>Profile Image</th>
                                    <th>Location</th>
                                    <th>Date Joined</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($tenants as $tenant)
                            <tbody>
                            <tr>
                                <td>
                                    1
                                </td>
                                <td><a href="/{{$tenant->unique_id}}">{{$tenant->firstname}} {{$tenant->lastname}}</a></td>
                                <td>
                                    <img alt="image" src="assets/img/users/user-5.png" width="35">
                                </td>
                                <td>{{$tenant->location}}</td>
                                <td>{{$tenant->created_at}}</td>
                                <td>
                                    <div class="badge badge-shadow {{ $tenant->status ? 'badge-danger' : 'badge-success' }}">Completed</div>
                                </td>
                                <td>
                                  <a href="/tenants/suspend/{{$tenant->unique_id}}" class="btn btn-primary">Suspend</a>
                                  <a href="/tenants/delete/{{$tenant->unique_id}}" class="btn btn-secondary">Delete</a>
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