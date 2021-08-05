<?php
//prevent logged in users from registering again while logged in
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
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

        <title>Register</title>

    </head>


    <body>
        <header>
            @include('includes.header')
        </header>
        <main class="register-form">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Register</div>
                            <div class="card-body">
                                <form action="{{url('registerUser')}}" method="POST" autocomplete="off"
                                    id="registrationForm">
                                    <!--Protect against Cross-Site Request Forgery. 
                                    Creates a hidden token field in the form.
                                    Compared with Laravel automatically generated CSRF token on submission via POST-->
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-8 m-auto">
                                            <div class="card-body pl-4 pr-4">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label for="firstName"> First Name <span
                                                                    class="text-danger">*</span> </label>
                                                            <input type="text" name="firstName" id="firstName"
                                                                class="form-control" placeholder="First Name">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label for="lastName"> Last Name <span
                                                                    class="text-danger">*</span> </label>
                                                            <input type="text" name="lastName" id="lastName"
                                                                class="form-control" placeholder="Last Name">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label for="emailAddress"> Email <span
                                                                    class="text-danger">*</span>
                                                            </label>
                                                            <input type="email" name="emailAddress" id="emailAddress"
                                                                class="form-control" placeholder="Email">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label for="phoneNumber"> Phone Number
                                                            </label>
                                                            <input type="text" name="phoneNumber" id="phoneNumber"
                                                                class="form-control" placeholder="Phone">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label for="password"> Password <span
                                                                    class="text-danger">*</span> </label>
                                                            <input type="password" name="password" id="password"
                                                                class="form-control" placeholder="Password">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="form-group">
                                                            <label for="confirmPassword"> Confirm Password <span
                                                                    class="text-danger">*</span> </label>
                                                            <input type="password" name="confirmPassword"
                                                                id="confirmPassword" class="form-control"
                                                                placeholder="Confirm Password">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-xl-6 offset-lg-6 text-right">
                                                        <button type="submit" class="btn btn-success"> Create your
                                                            account </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="login" class="btn btn-link">
                                                Already an Organiser? Log in
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
            //Create a new validation rule called alphanum that requires 
            jQuery.validator.addMethod("alphanum", function(value, element) {
                return this.optional(element) || (value.match(/[A-Z]/) && value.match(/[a-z]/) &&
                    value.match(/[0-9]/));
            }, "Please use only alphanumeric characters.");
            // Initialize form validation on the registration form.
            $("#registrationForm").validate({
                // Specify validation rules
                rules: {
                    firstName: {
                        required: true
                    },
                    lastName: {
                        required: true
                    },
                    emailAddress: {
                        required: true,
                        email: true
                    },

                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        alphanum: true
                    },
                    confirmPassword: {
                        equalTo: "#password"

                    },
                    phoneNumber: {
                        minlength: 11,
                        maxlength: 13,
                        digits: true

                    },
                },
                // Specify validation error messages
                messages: {
                    firstName: "Please enter your firstname",
                    lastName: "Please enter your lastname",
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 8 characters long",
                        alphanum: "Your password must contain at least one digit and one uppercase letter and no special characters."
                    },
                    confirmPassword: "Passwords must match.",
                    email: "Please enter a valid email address"
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