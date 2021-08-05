<?php
//prevent logged in users from logging in again
if(!is_null(Session::get('OrganiserID'))){
    $new_url = '/';
    header('Location: '.$new_url);
    exit();
}
?>

<!DOCTYPE html>
<html?>

    <head>
        @include('includes.head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
        <title>Login</title>

    </head>


    <body>
        <header>
            @include('includes.header')
        </header>
        <main class="login-form">
            <div class="cotainer">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Login</div>
                            <div class="card-body">
                                <form action="{{route('loginUser')}}" method="POST" id='loginForm'>
                                    <!--Protect against Cross-Site Request Forgery. 
                                    Creates a hidden token field in the form.
                                    Compared with Laravel automatically generated CSRF token on submission via POST-->
                                    @csrf
                                    <div class="form-group row">

                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-right">Email*</label>
                                        </label>
                                        <div class="col-md-6">

                                            <input type="email" name="emailAddress" id="emailAddress"
                                                class="form-control" placeholder="Email"
                                                value="{{old('emailAddress')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-right">Password*</label>
                                        <div class="col-md-6">
                                            <input type="password" id="password" class="form-control" name="password"
                                                required>
                                        </div>
                                    </div>


                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Login
                                        </button>
                                        <!-- <a href="#" class="btn btn-link">
                                            Forgot Your Password?
                                        </a> -->
                                        <a href="register" class="btn btn-link">
                                            Register for an Organiser Account
                                        </a>
                                    </div>
                            </div>
                            @if(count($errors))
                            <div class="form-group">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>

        </main>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>


        <script>
        // Wait for the DOM to be ready
        $(document).ready(function() {

            // Initialize form validation on the registration form.
            $("#loginForm").validate({
                // Specify validation rules
                rules: {

                    emailAddress: {
                        required: true,
                        email: true
                    },

                    password: {
                        required: true

                    },

                },
                // Specify validation error messages
                messages: {
                    emailAddress: {
                        required: "You must enter an email address",
                        email: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please provide a password"
                    },

                },

                // submit to the "action" in the form.
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
        </script>
    </body>

    </html>