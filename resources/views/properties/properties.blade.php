@include('layouts.header')

@include('layouts.sidebar')
<div id="main">
    @include('layouts.nav')

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Property Information</h3>
                    <p class="text-subtitle text-muted">For user to check they list</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Property Info</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="row" id="basic-table">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title">Available Categories</h4>
                            <button type="button" class="btn btn-outline-primary block"
                                data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                                Create Category
                            </button>
                        </div>
                        <div class="card-content">
                            <div class="card-body pt-0">

                                <!-- Table with outer spacing -->
                                <div class="table-responsive">
                                    <table class="table table-lg position-relative">
                                    @if (isset($categories) && count($categories) > 0)
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody class="position-relative">
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td class="text-bold-500">{{$category->category_title}}</td>
                                                <td>{{$category->category_desc}}</td>
                                                <td class="text-bold-500">
                                                    <div class="badge badge-shadow {{ $category->status ? 'bg-success' : 'bg-warning' }}">
                                                        {{ $category->status ? 'Active' : 'Suspended' }}
                                                    </div>
                                                </td>
                                                <td class="d-flex align-items-center">
                                                    <div class="dropdown" >
                                                        <button class="btn" type="button" id="dropdown{{$category->unique_id}}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <div class="dropdown-menu shadow dropdown-menu-left" aria-labelledby="dropdown{{$category->unique_id}}" >
                                                            <div class="dropdown-item ">
                                                                <p class="mb-2">Edit Category</p>
                                                                <form action="/categories/edit/{{$category->unique_id}}" method="post" >
                                                                    @csrf
                                                                    <input type="text" name="category_title" value="{{$category->category_title}}" class="form-control mb-2" />
                                                                    <textarea name="category_desc" class="form-control">{{$category->category_desc}}</textarea>
                                                                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="dropdown">
                                                        <button class="btn" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>
                                                        <div class="dropdown-menu shadow  dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="/categories/suspend/{{$category->unique_id}}">
                                                                {{ $category->status ? 'Suspend' : 'Restore' }}
                                                            </a>
                                                            <a class="dropdown-item" href="/categories/delete/{{$category->unique_id}}">Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
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
                                                    <button type="button" class="btn btn-outline-primary block"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                                                        Create Category
                                                    </button>
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
        </div>

        <div class="card">
            <div class="card-content">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Amenities</h4>
                            <p><span class="badge alert-primary">{{count($amenities)}} </span> Amenities Listed</p>
                        </div>

                        <div class="col-md-6">
                            <form action="/amenities/create-amenities" method="post">
                                @csrf
                                <div class="col-12">
                                    <div class="row gx-md-1 bg-white">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-8">
                                                    <input type="text" name="amenity_title" class="form-control" placeholder="New Amenity">
                                                </div>
                                                <div class="col-4">
                                                    <button type="submit" class="btn btn-primary btn-block">Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($amenities && count($amenities) > 0)
                        <div class="row gx-2 gy-1">
                            @foreach($amenities as $amenity)
                                <div class="col-md-4">
                                    <div class="bg-light p-2 pb-0 pt-3 rounded d-flex justify-content-between align-content-center">
                                        <div class="d-flex">
                                            <div style="width: 8px; height: 8px;" class="p-1 mt-2 me-2 rounded-circle {{$amenity->status ? 'bg-success' : 'bg-warning' }}"></div>
                                            <p class="position-relative">{{$amenity->amenity_title}}</p>
                                        </div>

                                        <div class="d-flex">
                                            <a class="border-0" type="button" id="dropdown{{$amenity->unique_id}}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-left p-4" aria-labelledby="dropdown{{$amenity->unique_id}}">
                                                <p class="mb-2">Edit Item</p>
                                                <form action="/amenities/edit/{{$amenity->unique_id}}" method="post" >
                                                    @csrf
                                                    <input type="text" name="amenity_title" value="{{$amenity->amenity_title}}" class="form-control" />
                                                    <button type="submit" class="btn btn-primary mt-2">Update</button>
                                                </form>
                                            </div>
                                            <a href="/amenities/suspend/{{$amenity->unique_id}}" class="ms-3"><i class="bi {{$amenity->status ? 'bi-eye-slash' : 'bi-eye'}}"></i></a>
                                            <a href="/amenities/delete/{{$amenity->unique_id}}" class="ms-3"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div>
                            <h2>No Amenities! Please Create</h2>
                        </div>
                    @endif
                </div>
                </div>
            </div>

            <!-- <div class="col-md-6">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title">Features</h4>
                                    <p><span class="badge alert-primary">{{count($features)}} </span> Features Listed</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($features && count($features) > 0)
                                @foreach($features as $feature)
                                    <span class="badge px-4 py-2 bg-success m-1">{{$feature->feature_title}}</span>
                                @endforeach
                            @else
                                <div>
                                    <h2>No Available Features!</h2>
                                    <p>Create a new one below</div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer col-12">
                            <div class="col-6">
                                <form action="features/create-features" method="post">
                                    @csrf
                                    <div class="col-12">
                                        <div class="row gx-1 bg-white">
                                            <div class="col-10">
                                                <input type="text" name="feature_title" class="form-control form-control-sm" placeholder="New Feature">
                                            </div>
                                            <div class="col-2">
                                                <button type="submit" class="btn btn-primary btn-sm">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> -->
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
        <form action="categories/create" method="POST">
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
