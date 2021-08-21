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
                    <h3>Admin</h3>
                    <p class="text-subtitle text-muted">All Admins</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page"><a href="/admins">Admins</a></li>
                            <li class="breadcrumb-item active">{{$admin->firstname." ".$admin->lastname}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-4">
        <div class="col-md-5">
            <div>
                <div class="">
                    <img src="{{$admin->avatar}}" alt="{{$admin->firstname.' '.$admin->lastname}}" class="img-fluid" />
                </div>

                <div>
                    <h3>{{$admin->firstname." ".$admin->lastname}} </h3>
                    <span class="badge badge-sm badge-pill bg-primary fs-14">{{$admin->status ? 'active' : 'suspended' }}</span>
                    <strong>{{$admin->email}}</strong>
                </div>
            </div>
        </div>
    </div>

</div>

@include('layouts.footer')