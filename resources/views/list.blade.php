<!DOCTYPE html>
<html>

<head>
    @include('includes.head')
    <title>List</title>


</head>


<body padding=0 margin=0>
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


                <div class="flex items-center">
                    <br><br>
                    <div class="ml-4 text-lg leading-7 font-semibold">
                        <div style="font-size:1vw">
                            <h4>
                                Displaying: {{sizeof($Event)}} <?php echo (sizeof($Event) > 1) ? 'Events' : 'Event';?>
                                <br>
                            
                                Click the Column Headings to sort the table.
                                <br>
                                Filter the table by typing a search term in the box for the relevant column.
                            </h4>
                        </div>  


                            <table id='eventDataTable' border="2">

                                <thead>
                                    <tr>
                                        <th scope="col" width='200px'  onclick="sortTable(0)">Image</th>

                                        <th width='80px' onclick="sortTable(1)"> Event Title </th>
                                        <th scope="col" width='200px'  onclick="sortTable(2)" width='200px'>
                                            Event Description 
                                            <input type="text" id="descriptionFilter" onkeyup="filterTable(2)" placeholder="Search in description..." title="DescriptionFilter">

                                        </th>
                                        <th scope="col" width='200px'  onclick="sortTable(3)"> 
                                            Event Category 
                                            <input type="text" id="categoryFilter" onkeyup="filterTable(3)" placeholder="Search for category..." title="CategoryFilter">
                                        </th>
                                        <th scope="col" width='100px'  onclick="sortTable(4)">
                                            Event Start 
                                         <input type="text" id="startDateFilter" onkeyup="filterTable(4)" placeholder="Search for start date...." title="startDateFilter">
                                        </th>
                                        <th scope="col" width='100px'  onclick="sortTable(5)">
                                            Event End 
                                            <input type="text" id="endDateFilter" onkeyup="filterTable(5)" placeholder="Search for end date..." title="EndDateFilter">

                                        </th>
                                        <th scope="col" width='200px'  onclick="sortTable(6)">
                                             Event Organiser 
                                             <input type="text" id="organiserFilter" onkeyup="filterTable(6)" placeholder="Search for organiser..." title="OrganiserFilter">

                                            </th>
                                        <th scope="col" width='200px'  onclick="sortTable(7)">
                                            Interest Rank</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Event as $e)
          
                                        
                                    <tr>
                                        <td><img src="{{asset($e->EventImagePath)}}" height='150px'></td>

                                        <td><a href='/event/{{$e->EventID}}'>{{$e->EventTitle}}</a></td>
                                        <td>{{$e->EventDescription}}</td>
                                        <td>{{$e->EventCategory}}</td>
                                        <td>{{$e->EventStartTime}}</td>
                                        <td>{{$e->EventEndTime}}</td>
                                        <td>{{$e->OrganiserFirstName . ' ' . $e->OrganiserLastName}}</td>
                                        <td>{{$e->EventInterestRank}}</td>


                                        </td>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        
                    </div>
                </div>
            </div>

        



        <br><br>
    </div>

</body>


<script>
function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
function filterTable(n){
    var table, rows, i, input, tr, td;
    table = document.getElementById("eventDataTable");
  
    switch(n){
        case 1:
            input = document.getElementById('titleFilter');
            break;
        case 2:
            input = document.getElementById('descriptionFilter');
            break;
        case 3:
            input = document.getElementById('categoryFilter');
            break;
        case 4:
            input = document.getElementById('startDateFilter');
            break;
        case 5:
            input = document.getElementById('endDateFilter');
            break;
        case 6:
            input = document.getElementById('organiserFilter');
            break;
        case 7:
            input = document.getElementById('interestRankFilter');
            break;
    }
    filterValue = input.value.toLowerCase();
    //Get all rows from the table
    tr = table.getElementsByTagName("tr");
    //for each of the rows
    for (i = 0; i < tr.length; i++) {
        //get the column we are looking for by using its column index 
        td = tr[i].getElementsByTagName("td")[n];
        //if something is found
        if (td) {
            //
            txtValue = td.textContent || td.innerText;
            if (txtValue.toLowerCase().indexOf(filterValue) > -1) {
                tr[i].style.display = "";
            } 
            else {
                tr[i].style.display = "none";
            }
        }       
    }
}

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("eventDataTable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
          if (isNumeric(x.innerHTML) && isNumeric(y.innerHTML)){
            if (Number(x.innerHTML) > Number(y.innerHTML)) {
            shouldSwitch = true;
            break;
        }
          }
          else{
            if (x.innerText.toLowerCase() > y.innerText.toLowerCase()) {
                // If so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
            }
          }
        
      } else if (dir == "desc") {
        if (isNumeric(x.innerHTML) && isNumeric(y.innerHTML)){
            if (Number(x.innerHTML) < Number(y.innerHTML)) {
                shouldSwitch = true;
                break;
            }
        }
          else{
            if (x.innerText.toLowerCase() < y.innerText.toLowerCase()) {
                // If so, mark as a switch and break the loop:
                shouldSwitch = true;
                break;
            }
          }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>

</html>