<!DOCTYPE html>
<html>

<head>
    @include('includes.head')
    <title>List</title>

</head>


<body>
    <header>
        @include('includes.header')
    </header>

    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <br>
        <div class="grid grid-cols-1 md:grid-cols-2">

            <section>

                <div class="col-md-4">
                    <a href='/newEvent'>
                        <button class="btn btn-primary">
                            Create Event
                        </button>
                    </a>

                </div>
                <br>
                <?php
                    if(!is_null(Session::get('OrganiserID'))){
                ?>
                        <div class="col-md-4">
                            <a href='/list/{{Session::get("OrganiserID")}}'>
                                <button type="submit" class="btn btn-primary">
                                    View Your Organised Events
                                </button>
                            </a>
                        </div>
                    <?php
                    };
                    ?>

            </section>

            <div class="p-6 offset-md-1">

                <div class="flex items-center">
                    <br><br>
                    <div class="ml-4 text-lg leading-7 font-semibold">

                        <div>
                            <table border="2">

                                <thead>
                                    <tr>
                                        <th> Image </th>

                                        <th> Event Title </th>
                                        <th> Event Description </th>
                                        <th> Event Category </th>
                                        <th>Event Location</th>
                                        <th> Event Start </th>
                                        <th> Event End </th>
                                        <th> Event Organiser </th>
                                        <th>Interest Rank</th>
                                    </tr>
                                </thead>
                                @foreach ($Event as $e)
                                    <?php      
                                    if(!(is_null(Session::get('OrganiserID'))) && Session::get('OrganiserID') == $e->EventOrganiserID){
                                    ?>
                                <tbody>

                                    <div class="col-md-4">
                   
                                                                            
                                    
                                        <a href='/updateEvent/{{$e->EventID}}'>
                                        <button class="btn btn-primary">Update Event</button>
                                        </a>
                                    </div>
                                    <?php
                                    };
                                    ?>
                            

                                    <tr>
                                        <td><img src = "{{asset($e->EventImagePath)}}" height='200px' ></td>


                                        <td>{{$e->EventTitle}}</td>
                                        <td>{{$e->EventDescription}}</td>
                                        <td>{{$e->EventCategory}}</td>
                                        <td>{{$e->EventLocation}}</td>

                                        <td>{{$e->EventStartTime}}</td>
                                        <td>{{$e->EventEndTime}}</td>
                                        <td>{{$e->OrganiserFirstName . " " . $e->OrganiserLastName . "\n\n " . $e->OrganiserEmailAddress}}</td>
                                        <td>{{$e->EventInterestRank}}</td>

                                        <td><a href='/registerInterest/{{ $e->EventID }}'>Register Interest</a>
                                        </td>
                                        </td>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <br><br>
    </div>

</body>

</html>