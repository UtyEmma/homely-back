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
                            <li class="breadcrumb-item"><a href="/support">Dashboard</a></li>
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
                                <div class="card ">
                                    <div class="card-header bg-light py-2">
                                        <h4>Ticket Info</h4>
                                    </div>
                                    <div class="card-body">

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
                                                <span class="badge bg-primary text-xs">{{$ticket->status}}</span>
                                            </div>
                                            <button class="btn btn-sm">
                                                <i data-feather="x"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body pt-4 bg-grey">
                                        <div class="chat-content">
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
                                            <a href="http://" class="black"><i data-feather="smile"></i></a>
                                            <div class="">
                                                <form action="/support/chat/{{$ticket->unique_id}}" method="post">
                                                    @csrf
                                                    <textarea type="text" class="form-control border-0" name="message" placeholder="Type your message.."></textarea>
                                                    <button type="submit" class="btn btn-link">Send</button>
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