@include('layouts.header')


@include('layouts.sidebar')

<div id="main">
    @include('layouts.nav')

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
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item current"><span>Support</span></li>
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
                                <div class="mb-5">
                                    <h4>Support Tickets</h4>
                                </div>
                                <!-- sidebar menu  -->
                                <div class="list-group list-group-messages">
                                    <a href="/support" class="list-group-item d-flex align-items-center {{$status === 'all' ? 'active' : ''}}">
                                        <div class="me-4 d-flex align-items-center">
                                            <i class="bi bi-grid"></i>
                                        </div>
                                        All
                                        <span class="badge badge-light-primary badge-pill badge-round text-primary float-right mt-50 ms-4">5</span>
                                    </a>
                                    <a href="/support/pending" class="list-group-item d-flex align-items-center {{$status === 'pending' ? 'active' : ''}}">
                                        <div class="me-3 d-flex align-items-center">
                                            <i class="bi bi-chat-dots"></i>
                                        </div>
                                        Pending
                                    </a>
                                    <a href="/support/resolved" class="list-group-item d-flex align-items-center {{$status === 'resolved' ? 'active' : ''}}">
                                        <div class="fonticon-wrap d-inline me-3 d-flex align-items-center">
                                            <i class="bi bi-check-all"></i>
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
                                                <i class="bi bi-chevron-right"></i>
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
                                                                <a href="/support/ticket/{{$ticket['ticket']->unique_id}}">
                                                                    <span class="list-group-item-text text-truncate mb-0">{{$ticket['ticket']->title}}</span>
                                                                </a>
                                                            </div>
                                                            <div class="mail-meta-item">
                                                                <div class="badge bg-primary fw-normal {{$ticket['ticket']->status === 'pending' ? 'bg-warning' : 'bg-success'}}">
                                                                    {{$ticket['ticket']->status}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mail-message">
                                                            <p class="list-group-item-text mb-0 truncate">
                                                                <span class="fw-bold">Created on -</span> {{$ticket['ticket']->created_at->date}} | <span class="fw-bold">Agent -</span>
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
                                            @else
                                                <!-- no result when nothing to show on list -->
                                                <div class="card card-body">
                                                    <h2>No Items Found</h2>
                                                </div>
                                            @endif
                                        </ul>
                                        <!-- email user list end -->
    
                                        
                                    </div>
                                </div>
                            </div>
                            <!--/ Email list Area -->
    
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



@include('layouts.footer')