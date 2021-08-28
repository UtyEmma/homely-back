@include('layouts.header')

@include('layouts.sidebar')

<div id="main" class="layout-navbar">
    @include('layouts.nav')
    
    @php
        $auth = auth()->user();
    @endphp

<div id="main-content">
    <div class="page-heading">
        <h3>All Adminstrators</h3>
        <div class="alert alert-light-primary rounded alert-dismissible fade show" role="alert">
            <p class="fw-bold ">
                <i class="bi bi-info-circle text-warning"></i>
                Only <code>Super Adminstrators</code> can register new adminstrators, and delete or suspend any administrator. In order to perform any of these actions, please login as a <code>Super Adminstrator</code>
            </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert"
            aria-label="Close"></button>
        </div>
    </div>
    <div class="page-content">
      <section class="section">
        <div class="row" id="table-hover-row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Admins Table</h4>
                        
                        @if ($auth->role === 'Super Administrator')
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#success">
                            <i class="ml-2 bi bi-person fs-4"></i> Create Admin
                            </button>
                        @endif
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                      <th>Index</th>
                                      <th>Name</th>
                                      <th>Email Address</th>
                                      <th>Status</th>
                                      <th>Role</th>
                                      @if ($auth->role === 'Super Administrator')
                                        <th>Action</th>
                                      @endif
                                    </tr>
                                </thead>
                                @php
                                  $i = 0;
                                @endphp
                                @if(isset($admins) && count($admins) > 0)
                                  <tbody>
                                    @foreach($admins as $admin)
                                      <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$admin->firstname}} {{$admin->lastname}}</td>
                                        <td> {{$admin->email}}</td>
                                        <td>
                                          <div class="badge badge-shadow {{ $admin->status ? 'bg-success' : 'bg-warning' }}">
                                              {{ $admin->status ? 'active' : 'suspended' }}
                                          </div>
                                        </td>
                                        <td>
                                          {{ $admin->role }}
                                        </td>

                                        @if ($auth->role === 'Super Administrator')
                                            <td class="td-actions text-primary">
                                                <button class="btn btn-primary dropdown-toggle border-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{-- <i class="fa fa-list"></i> --}}
                                                    Action
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="admins/delete/{{$admin->unique_id}}">Delete</a>
                                                    <a class="dropdown-item" href="admins/suspend/{{$admin->unique_id}}">{{ $admin->status ? 'Suspend' : 'Restore' }}</a>
                                                </div>
                                            </td>
                                        @endif
                                      </tr>
                                    @endforeach
                                  </tbody>
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
    </section>

    <div class="modal fade text-left" id="success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
          role="document">
          <div class="modal-content">
              <div class="modal-header bg-primary">
                  <h5 class="modal-title white" id="myModalLabel110">
                      Create new Admin
                  </h5>
                  <button type="button" class="close"
                      data-bs-dismiss="modal" aria-label="Close">
                      <i data-feather="x"></i>
                  </button>
              </div>
              <div class="modal-body">
                <div class="card-header py-2 card-header-primary">
                  <p class="card-category">Register a New Admin</p>
                </div>
                <div class="card-body">
                    @if(session('response'))
                        <div class="alert alert-success">{{session('response')}}</div>
                    @endif

                    <form action="/register" method="POST" class="mt-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="bmd-label-floating">Firstname</label>
                                <input type="text" name="firstname" class="form-control form-control-lg @error('firstname') is-invalid @enderror">
                                @error('firstname')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="bmd-label-floating">Lastname</label>
                                <input type="text" name="lastname" class="form-control form-control-lg @error('firstname') is-invalid @enderror">
                                @error('lastname')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="bmd-label-floating">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="admin_role" class="">Role</label>
                                    <select class="form-control form-control-lg @error('role') is-invalid @enderror selectpicker" data-style="btn btn-link" name="role" id="admin_role">
                                        <option>Select Admin</option>
                                        <option>Administrator</option>
                                        <option>Super Administrator</option>
                                    </select>
                                    @error('role')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating" for="password">Default Password</label>
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" id="password">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating" for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">Register Admin</button>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>      
        </div>
        <div class="modal-footer">
            <button type="button"
                class="btn btn-light-secondary"
                data-bs-dismiss="modal">
                <i class="bx bx-x d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Close</span>
            </button>

            <button type="button" class="btn btn-success ml-1"
                data-bs-dismiss="modal">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Accept</span>
            </button>
        </div>
        </div>
      </div>
  </div>
</div>

@include('layouts.footer')

</div>
</div>