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
                        <div class="card-header d-flex justify-content-between">
                        <h4>All Categories</h4>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModalCenter">Create Category</button>
                        </div>
                        <div class="card-body">
                            @isset($_SESSION['message'])
                                {{$_SESSION['message']}}
                            @endisset
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">

                            @if (isset($categories) && count($categories) > 0)
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                        #
                                        </th>
                                        <th>Category Title</th>
                                        <th>Category Description</th>
                                        <th>Members</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @foreach ($categories as $category)
                                <tbody>
                                <tr>
                                    <td>
                                        {{$category->id}}
                                    </td>
                                    <td>{{$category->category_title}}</td>
                                    <td class="align-middle">{{$category->category_desc}}</td>
                                    <td>
                                        <img alt="image" src="assets/img/users/user-5.png" width="35">
                                    </td>
                                    <td>2018-01-20</td>
                                        <td>
                                            @if ($category->status)
                                                <div class="badge badge-success badge-shadow">Completed</div>
                                            @else
                                                <div class="badge badge-warning badge-shadow">Delisted</div>
                                            @endif
                                        </td>
                                    <td>
                                        <a href="category/unlist/{{$category->unique_id}}" class="btn btn-primary">Unlist</a>
                                        <a href="category/delete/{{$category->unique_id}}" class="btn btn-secondary">Delete</a>
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
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModalCenter">Create Category</button>
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


                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Features</h4>
                            <button class="btn btn-sm btn-primary">New</button>
                        </div>

                        <div class="card-body">    
                            <button type="button" class="btn btn-primary">
                                Notifications <span class="badge badge-transparent">4</span>
                            </button>
                            <button type="button" class="btn btn-primary">
                                Notifications <span class="badge badge-transparent">4</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Amenities</h4>
                            <button class="btn btn-sm btn-primary">New</button>
                        </div>

                        <div class="card-body">    
                            <button type="button" class="btn btn-primary">
                                Notifications <span class="badge badge-transparent">4</span>
                            </button>
                            <button type="button" class="btn btn-primary">
                                Notifications <span class="badge badge-transparent">4</span>
                            </button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="/categories/create" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Category Title</label>
                    <input type="text" name="category_title" class="form-control">
                </div>

                <div class="form-group">
                    <label>Category Description</label>
                    <textarea type="text" name="category_desc" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="submit" class="btn btn-primary">Save</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
    </div>
</div>


@include('layouts.footer')