<?php
//prevent non-logged in users from editing a post
if(is_null(Session::get('OrganiserID'))){
    $new_url = '/login';
    header('Location: '.$new_url);
    exit();
}

//Prevent a user from editing a post that is not their own
foreach ($Event as $e){
    //if the organiserID for the requested event does not match what is recorded in the session
    if ($e->EventOrganiserID != Session::get('OrganiserID')){
        $new_url = '/event/'.$e->EventID;
        //redirect to the event view page
        header('Location: '.$new_url);
        exit();
    }
}


?>

<!DOCTYPE html>
<html?>

    <head>
        @include('includes.head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
        <title>Create Event</title>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
    </head>


    <body>
        <header>
            @include('includes.header')
        </header>


        <main class="createEvent">
            <div class="container-lg">
                <div class="row">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header">Create Event</div>
                            <div class="card-body">


                                
                                <form action="{{url('updateEvent')}}" method="POST" enctype="multipart/form-data" id="eventForm" novalidate >
                                    @csrf
                                    @foreach ($Event as $e)

                                    <div class="row">

                                        <div class="col-md-4">
                                            <label for="EventImagePath">Image (Leave blank to keep current image)</label>
                                            <input type="file" class="form-control-file" id="EventImagePath" name='EventImagePath'
                                                value="{{ old('EventImagePath', $e->EventImagePath) }}">
                                        </div>
                                        <div class=" col-md-6">
                                            <label for="EventTitle">Event Title *</label>

                                            <input type="text" id="EventTitle" class="form-control" name="EventTitle"
                                                required autofocus value="{{ old('EventTitle', $e->EventTitle) }}">
                                        </div>
                                    </div>


                                    <div class=" form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <label for="EventDescription">Event Description *</label>
                                            <textarea class="form-control animated" id="EventDescription"
                                                name="EventDescription" required
                                                visibility="visible">{{ old('EventDescription' , $e->EventDescription)}}</textarea>
                                            <!-- <input type=" text" id="EventDescription" class="form-control"
                                                    name="EventDescription" required autofocus> -->
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <label for="EventCategory">Event Category *</label>
                                            <select class="form-control" id='EventCategory' name='EventCategory'>
                                                <option value='Sports'>Sports</option>
                                                <option value='Culture'>Culture</option>
                                                <option value='Other'>Other</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <label for="EventStartTime">Event Start Time *</label>

                                            <div class="form-group">
                                                <div class='input-group date' id='EventStartTime'>
                                                    <input type='text' class="form-control" name='EventStartTime'
                                                        minlength="3" value="{{ old('EventStartTime', $e->EventStartTime) }}" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-md-6 offset-md-4">
                                            <label for="EventEndTime">Event End Time *</label>

                                            <div class="form-group">
                                                <div class='input-group date' id='EventEndTime'>
                                                    <input type='text' class="form-control" name='EventEndTime'
                                                        value="{{ old('EventEndTime', $e->EventEndTime) }}" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-md-6 offset-md-4">
                                            <label for="EventLocation">Event Location</label>

                                            <div class="form-group">
                                                <div class='input-group date' id='EventLocation'>
                                                    <input type='text' class="form-control" name='EventLocation'
                                                        value="{{ old('EventLocation', $e->EventLocation) }}" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type='hidden' name='EventID' id='EventID' value="{{$e->EventID}}"/>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-xl-6 offset-lg-4 text-right">
                                            <button type="submit" class="btn btn-success"> Create Event </button>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <!-- Import scripts for form validation -->

        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js">
        </script>


        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
        < script src = "https://code.jquery.com/ui/1.12.1/jquery-ui.js" >
        </script>
        </script>
        <script type="text/javascript">
        $(function() {
            $('#EventStartTime').datetimepicker({
                onSubmit: function() {
                    $(this).valid();
                }
            });

            $('#EventEndTime').datetimepicker();
        });
        </script>

        <script>
        $('#EventStartTime').datetimepicker();
        // Wait for the DOM to be ready
        $(document).ready(function() {

            // Initialize form validation on the registration form.
            $("#eventForm").validate({
                // Specify validation rules
                rules: {
                    EventImagePath: {
                        accept: "jpg,jpeg,png"
                    },
                    EventTitle: {
                        required: true,
                        minlength: 20
                    },
                    EventDescription: {
                        required: true,
                        minlength: 200

                    },
                    EventStartTime: {
                        required: true,
                        date: true
                    },
                    EventEndTime: {
                        required: true,
                        date: true
                    },
                },
                // Specify validation error messages
                messages: {
                    imgFile: {
                        required: "Please upload an image.",
                        accept: "Please submit only files that are either .jpg, .jpeg, or .png"
                    },

                    EventTitle: "Please enter the title of the event. It must be at least 20 characters long.",

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