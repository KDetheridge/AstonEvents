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
        <main class="login-form">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Register</div>
                            <div class="card-body">
                                <form action="{{url('register-user')}}" method="POST" autocomplete="off"
                                    id="registrationForm">

                                    <div class="form-group row">
                                        <label for="firstName" class="col-md-4 col-form-label text-md-right">First
                                            Name *</label>
                                        <div class="col-md-6">
                                            <input type="text" id="firstName" class="form-control" name="firstName"
                                                autofocus>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="lastName" class="col-md-4 col-form-label text-md-right">Last
                                            Name *</label>
                                        <div class="col-md-6">
                                            <input type="text" id="lastName" class="form-control" name="lastName">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="emailAddress" class="col-md-4 col-form-label text-md-right">E-Mail
                                            Address *</label>
                                        <div class="col-md-6">
                                            <input type="text" id="emailAddress" class="form-control"
                                                name="emailAddress">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="phoneNumber" class="col-md-4 col-form-label text-md-right">Phone
                                            Number</label>
                                        <div class="col-md-6">
                                            <input type="text" id="phoneNumber" class="form-control" name="phoneNumber">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password
                                            *</label>
                                        <div class="col-md-6">
                                            <input type="password" id="password" class="form-control" name="password">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="confirm-password"
                                            class="col-md-4 col-form-label text-md-right">Confirm
                                            Password *</label>
                                        <div class="col-md-6">
                                            <input type="password" id="confirmPassword" class="form-control"
                                                name="confirmPassword">
                                        </div>
                                    </div>



                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Register
                                        </button>
                                        <a href="#" class="btn btn-link">
                                            Forgot Your Password?
                                        </a>
                                        <a href="login" class="btn btn-link">
                                            Already have an account? Login
                                        </a>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>

        </main>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>

        <script>
        // Wait for the DOM to be ready
        $(function() {
                    // Initialize form validation on the registration form.
                    // It has the name attribute "registration"
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
                                phoneNumber: {
                                    required: false,
                                    digits: true

                                },
                                password: {
                                    required: true,
                                    password: true
                                }
                                confirmPassword: {
                                    minlength: 8,
                                    //don't need a required here because this equalTo covers it
                                    equalTo: "#password"

                                },
                                // Specify validation error messages
                                messages: {
                                    firstName: "Please enter your firstname",
                                    lastName: "Please enter your lastname",
                                    password: {
                                        required: "Please provide a password",
                                        minlength: "Your password must be at least 5 characters long"
                                    },
                                    confirmPassword: "Passwords must match."
                                    email: "Please enter a valid email address"
                                },
                                // Make sure the form is submitted to the destination defined
                                // in the "action" attribute of the form when valid
                                submitHandler: function(form) {
                                    form.submit();
                                }
                            });
                    });
        </script>
    </body>

    </html>