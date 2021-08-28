@include('layouts.header')


@include('layouts.sidebar')

<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading email-application">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Support</h3>
                    <p class="text-subtitle text-muted">All Tickets</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>


        <section class="section content-area-wrapper">
            <div class="sidebar-left">
                <div class="sidebar">
                    <div class="sidebar-content email-app-sidebar d-flex">
                        <!-- sidebar close icon -->
                        <span class="sidebar-close-icon">
                            <i class="bx bx-x"></i>
                        </span>
                        <!-- sidebar close icon -->
                        <div class="email-app-menu">
                            <div class="sidebar-menu-list ps my-5">
                                <!-- sidebar menu  -->
                                <div class="list-group list-group-messages">
                                    <a href="#" class="list-group-item pt-0 active" id="inbox-menu">
                                        <div class="fonticon-wrap d-inline me-3">
                                            <i class="bi bi-alarm"></i>
                                        </div>
                                        All
                                        <span
                                            class="badge badge-light-primary badge-pill badge-round float-right mt-50">5</span>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="fonticon-wrap d-inline me-3">
                                            <i class="bi bi-alarm"></i>
                                        </div>
                                        Pending
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <div class="fonticon-wrap d-inline me-3">
                                            <i class="bi bi-alarm"></i>
                                        </div> 
                                        Resolved
                                    </a>
                                </div>
                                <!-- sidebar menu  end-->
                                <!-- sidebar label end -->
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                    <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                    <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
            <div class="content-right">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <!-- email app overlay -->
                        <div class="app-content-overlay"></div>
                        <div class="email-app-area">
                            <!-- Email list Area -->
                            <div class="email-app-list-wrapper">
                                <div class="email-app-list">
                                    <div class="email-action">
                                        <!-- action left start here -->
                                        <div class="action-left d-flex align-items-center">
                                            <!-- select All checkbox -->
                                            <div class="checkbox checkbox-shadow checkbox-sm selectAll me-3">
                                                <input type="checkbox" id="checkboxsmall" class='form-check-input'>
                                                <label for="checkboxsmall"></label>
                                            </div>
                                            <!-- delete unread dropdown -->
                                            <ul class="list-inline m-0 d-flex">
                                                <li class="list-inline-item mail-delete">
                                                    <button type="button" class="btn btn-icon action-icon"
                                                        data-toggle="tooltip">
                                                        <span class="fonticon-wrap">
                                                            <svg class="bi" width="1.5em" height="1.5em"
                                                                fill="currentColor">
                                                                <use
                                                                    xlink:href="{{asset('vendors/bootstrap-icons/bootstrap-icons.svg#trash')}}" />
                                                            </svg>
                                                        </span>
                                                    </button>
                                                </li>
                                                <li class="list-inline-item">
                                                    <div class="dropdown">
                                                        <button type="button"
                                                            class="btn btn-icon dropdown-toggle action-icon" id="tag"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <span class="fonticon-wrap">
    
                                                                <svg class="bi" width="1.5em" height="1.5em"
                                                                    fill="currentColor">
                                                                    <use
                                                                        xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#tag" />
                                                                </svg>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- action left end here -->
    
                                        <!-- action right start here -->
                                        <div
                                            class="action-right d-flex flex-grow-1 align-items-center justify-content-around">
                                            <!-- search bar  -->
                                            <div class="email-fixed-search flex-grow-1">
                                                <div class="sidebar-toggle d-block d-lg-none">
                                                    <i class="bx bx-menu"></i>
                                                </div>
    
                                                <div class="form-group position-relative  mb-0 has-icon-left">
                                                    <input type="text" class="form-control" placeholder="Search email..">
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-search"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- pagination and page count -->
                                            <span class="d-none d-sm-block">1-10 of 653</span>
                                            <button class="btn btn-icon email-pagination-prev d-none d-sm-block">
                                                <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                                                    <use
                                                        xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#chevron-left" />
                                                </svg>
                                            </button>
                                            <button class="btn btn-icon email-pagination-next d-none d-sm-block">
                                                <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                                                    <use
                                                        xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#chevron-right" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- / action right -->
    
                                    <!-- email user list start -->
                                    <div class="email-user-list list-group ps ps--active-y">
                                        <ul class="users-list-wrapper media-list">

                                            @if (isset($tickets) && count($tickets) > 0)
                                            
                                                @foreach ($tickets as $ticket)
                                                <li class="media mail-read">
                                                    <div class="pr-50">
                                                        <div class="avatar">
                                                            <img class="rounded-circle" src="@php
                                                                echo json_decode($ticket['agent']->avatar)[0];
                                                            @endphp">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="user-details">
                                                            <div class="mail-items">
                                                                <a href="/support/{{$ticket['ticket']->unique_id}}">
                                                                    <span class="list-group-item-text text-truncate mb-0">{{$ticket['ticket']->title}}</span>
                                                                </a>
                                                            </div>
                                                            <div class="mail-meta-item">
                                                                <span class="float-right">
                                                                    <span class="mail-date">21 Mar</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mail-message">
                                                            <p class="list-group-item-text mb-0 truncate">
                                                                {{-- Created on -  --}}
                                                                {{$ticket['agent']->firstname}} {{$ticket['agent']->lastname}}
                                                            </p>
                                                            <div class="mail-meta-item">
                                                                <span class="float-right">
                                                                    <span class="bullet bullet-warning bullet-sm"></span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach

                                            @endif
                                        </ul>
                                        <!-- email user list end -->
    
                                        <!-- no result when nothing to show on list -->
                                        <div class="no-results">
                                            <i class="bx bx-error-circle font-large-2"></i>
                                            <h5>No Items Found</h5>
                                        </div>
                                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                        </div>
                                        <div class="ps__rail-y" style="top: 0px; height: 733px; right: 0px;">
                                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 567px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Email list Area -->
    
                            <!-- Detailed Email View -->
                            <div class="email-app-details">
                                <!-- email detail view header -->
                                <div class="email-detail-header">
                                    <div class="email-header-left d-flex align-items-center mb-1">
                                        <span class="go-back me-3">
                                            <span class="fonticon-wrap d-inline">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </span>
                                        <h5 class="email-detail-title font-weight-normal mb-0">
                                            Advertising Internet Online
                                            <span class="badge badge-light-danger badge-pill ms-1">PRODUCT</span>
                                        </h5>
                                    </div>
                                    <div class="email-header-right mb-1 ml-2 pl-1">
                                        <ul class="list-inline m-0">
                                            <li class="list-inline-item">
                                                <button class="btn btn-icon action-icon">
                                                    <span class="fonticon-wrap">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                </button>
                                            </li>
                                            <li class="list-inline-item">
                                                <button class="btn btn-icon action-icon">
                                                    <span class="fonticon-wrap">
                                                        <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                                                            <use
                                                                xlink:href="assets/vendors/bootstrap-icons/bootstrap-icons.svg#envelope" />
                                                        </svg>
                                                    </span>
                                                </button>
                                            </li>
                                            <li class="list-inline-item">
                                                <div class="dropdown">
                                                    <button class="btn btn-icon dropdown-toggle action-icon"
                                                        id="open-mail-menu" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="fonticon-wrap">
                                                            <i class="fas fa-folder"></i>
                                                        </span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="open-mail-menu">
                                                        <a class="dropdown-item" href="#"><i class="bx bx-edit"></i>
                                                            Draft</a>
                                                        <a class="dropdown-item" href="#"><i class="bx bx-info-circle"></i>
                                                            Spam</a>
                                                        <a class="dropdown-item" href="#"><i class="bx bx-trash"></i>
                                                            Trash</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-inline-item">
                                                <div class="dropdown">
                                                    <button class="btn btn-icon dropdown-toggle action-icon"
                                                        id="open-mail-tag" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <span class="fonticon-wrap">
                                                            <i class="fas fa-tag"></i>
                                                        </span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="open-mail-tag">
                                                        <a href="#" class="dropdown-item align-items-center">
                                                            <span class="bullet bullet-success bullet-sm"></span>
                                                            Product
                                                        </a>
                                                        <a href="#" class="dropdown-item align-items-center">
                                                            <span class="bullet bullet-primary bullet-sm"></span>
                                                            Work
                                                        </a>
                                                        <a href="#" class="dropdown-item align-items-center">
                                                            <span class="bullet bullet-warning bullet-sm"></span>
                                                            Misc
                                                        </a>
                                                        <a href="#" class="dropdown-item align-items-center">
                                                            <span class="bullet bullet-danger bullet-sm"></span>
                                                            Family
                                                        </a>
                                                        <a href="#" class="dropdown-item align-items-center">
                                                            <span class="bullet bullet-info bullet-sm"></span>
                                                            Design
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-inline-item">
                                                <span class="no-of-list d-none d-sm-block ms-1">1-10 of 653</span>
                                            </li>
                                            <li class="list-inline-item">
                                                <button class="btn btn-icon email-pagination-prev action-icon">
                                                    <i class="bx bx-chevron-left"></i>
                                                </button>
                                            </li>
                                            <li class="list-inline-item">
                                                <button class="btn btn-icon email-pagination-next action-icon">
                                                    <i class="bx bx-chevron-right"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--/ Detailed Email View -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



@include('layouts.footer')