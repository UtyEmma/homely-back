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
                    <h3>Support</h3>
                    <p class="text-subtitle text-muted">Chat</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/support">Support</a></li>
                            <li class="breadcrumb-item current"><span >Ticket</span></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card p-4">
                <section class="section">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="fs-6 btn btn-link d-flex align-items-center my-2" href="/support"><i class="bi bi-chevron-left me-1"></i> Back To Support</a>
                                <div class="card bg-light-primary">
                                    <div class="card-header bg-light-primary pt-3 pb-0">
                                        <h4 class="fw-bolder mb-0">Ticket Info</h4>
                                        <hr/>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0"><span class="fw-bold">Ticket ID: </span style="font-size: 12px"> {{$ticket->unique_id}}</p>
                                        <div class="badge fw-normal {{$ticket->status === 'pending' ? 'bg-warning' : 'bg-success'}}">
                                            {{$ticket->status}}
                                        </div>

                                        <div class="col-12 bg-white mt-3 rounded-3 p-2">
                                            <p>
                                                <span class="fw-bolder d-block">Title</span>
                                                {{$ticket->title}}
                                            </p>
                                        </div>

                                        <div class="col-12 bg-white mt-3 rounded-3 p-2">
                                            <a href="/support/resolve/{{$ticket->unique_id}}" class="btn btn-sm {{$ticket->status === 'pending' ? 'btn-success' : 'btn-warning'}}">{{$ticket->status === 'pending' ? 'Mark As Resolved' : 'Reopen Ticket'}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="card" style="background-color: #435ebe;">
                                    <div class="card-header bg-light">
                                        <div class="media d-flex align-items-center">
                                            <div class="avatar me-3">
                                                <img src="assets/images/faces/1.jpg" alt="" srcset="">
                                                <span class="avatar-status bg-success"></span>
                                            </div>
                                            <div class="name flex-grow-1">
                                                <h6 class="mb-0">{{$agent->firstname}} {{$agent->lastname}}</h6>
                                                <span class="badge bg-primary text-xs fw-normal {{$ticket->status === 'pending' ? 'bg-warning' : 'bg-success'}}">{{$ticket->status}}</span>
                                            </div>
                                            <button class="btn btn-sm">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body pt-4 bg-grey">
                                        <div class="chat-content py-3" style="height: 60vh;">
                                            @foreach ($chats as $chat )
                                                <div class="chat {{$chat->sender === 'agent' ? 'chat-left' : "" }}">
                                                    <div class="chat-body">
                                                        <div class="chat-message">{{$chat->message}}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                    </div>
                                    <div class="card-footer bg-light">
                                        <div class="message-form d-flex flex-direction-column align-items-center">
                                            <div class="col-12">
                                                <form action="/support/chat/{{$ticket->unique_id}}" method="post">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-10">
                                                            <textarea type="text" class="form-control border-0" rows="1" name="message" placeholder="Type your message.."></textarea>
                                                        </div>

                                                        <div class="col-2">
                                                            <button type="submit" class="btn btn-primary">Send</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>



@include('layouts.footer')
