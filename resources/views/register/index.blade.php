<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Djanbrary</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body>

    @error('credential')
    <div class="alert alert-danger col-lg-12" role="alert">
        {{ $message }}
    </div>
    @enderror

    <div class="container">
        {{-- Login form --}}
        <form action="{{ route('authenticate') }}" method="POST">
            @csrf
            <div class="mx-auto mt-4" style="max-width: 50%">
                <h1><b>Register to Djanbrary</b></h1>
                <div class="form-group">
                    <label for="fullNameInput">Full Name</label>
                    <input type="text" class="form-control @error('fullname') is-invalid @enderror" value="{{ old('fullname') }}" id="fullNameInput" name="fullname"
                        aria-describedby="emailHelp" placeholder="Enter full name">
                    @error('fullname')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="usernameInput">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="emailInput" name="email"
                        aria-describedby="emailHelp" placeholder="Enter email">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="usernameInput">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" id="usernameInput" name="username"
                    aria-describedby="emailHelp" placeholder="Enter username">
                    @error('username')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="passwordInput">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" id="passwordInput" name="password"
                    placeholder="Password">
                    @error('password')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="addressInput">Address</label>
                    <input type="text" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" id="addressInput" name="address"
                        aria-describedby="emailHelp" placeholder="Enter address">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phoneInput">Phone number</label>
                    <input type="text" class="form-control @error('phonenumber') is-invalid @enderror" value="{{ old('phonenumber') }}" id="phoneInput" name="phonenumber"
                        aria-describedby="emailHelp" placeholder="Enter phone number">
                        @error('phonenumber')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                </div>
                <div class="form-group">
                    <label for="sex" class="form-label">Sex</label>
                    <select class="form-control col-lg-4" name="sex" id="sex">
                          <option value="1" selected>Male</option>
                          <option value="0">Female</option>
                    </select>
                </div>
                {{-- <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div> --}}
                <h6>Have an account?  <a href="{{ route('authenticate') }}">Login Here</a></h6>
                <button type="submit" class="btn btn-primary mb-4">Register</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>

</html>