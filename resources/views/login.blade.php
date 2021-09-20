<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homly Admin - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('vendors/bootstrap-icons/bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/pages/auth.css')}}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-5">
                        <a href="/"><img src="{{asset('images/logo/logo.png')}}" alt="Logo"></a>
                    </div>
                    <p class="auth-subtitle mb-3">Login to Homly Admin</p>
                    @isset($message)
                        {{$message}}
                    @endisset
                    <form method="POST" action="/login">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="email" placeholder="Email Address">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="password" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Keep me logged in
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-3">Log in</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>

    </div>

    @if($errors->any())
        <script>
            toastr.options = {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "toast-top-center",
            }
            toastr.error("Invalid Input Data");
        </script>
    @endif

    @if(Session::has('success'))
        <script>
            toastr.options = {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "toast-top-center",
            }
            toastr.success("{{ session('success') }}", "Success");
        </script>
    @endif

    @if(Session::has('message'))
        <script>
            toastr.options = {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "toast-top-center",
            }
            toastr.info("{{ session('message') }}", "Message");
        </script>
    @endif

    @if(Session::has('error'))
        <script>
            toastr.options = {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "toast-top-center",
            }
            toastr.error("{{ session('error') }}", "Error");
        </script>
    @endif

    @if(Session::has('warning'))
        <script>
            toastr.options = {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "toast-top-center",
            }
            toastr.error("{{ session('warning') }}", "Error");
        </script>
    @endif
</body>

</html>
