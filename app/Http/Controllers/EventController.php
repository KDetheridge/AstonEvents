<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//Add reference to the module file in the app folder
//Need to specify the full path for some reason... Different version of Laravel to tutorials??
use App\Models\Event;
use DateTime;
//Contained within Laravel. Used for Date formatting and the like.
use Carbon\Carbon;
class EventController extends Controller
{


    //returns a list of all modules into the view 'list'
	public function list(){
		$events = DB::table('event')
		->select('EventID',
				'EventTitle',
				'EventDescription',
				'EventCategory',
				'EventStartTime',
				'EventEndTime', 
				'EventLocation',
				'EventOrganiserID',
				'OrganiserFirstName',
				'OrganiserLastName',
				'OrganiserEmailAddress',
				'EventInterestRank',
				'EventImagePath'
				)
		->leftJoin('organiser', 'event.EventOrganiserID', '=','organiser.OrganiserID')
		->get();

		return view('/list', array('Event'=>$events));
		//return view('/list', array('Event'=>Event::all()));
	
	}

	public function registerInterest($eventID){
		DB::table('event')->where('EventID',$eventID)->increment('EventInterestRank',1);
		return redirect()->route('event', ['eventID'=>$eventID]);
	}
	public function createEvent(Request $request) {
			$category = $request->get('eventCategory');
			$this->validate(request(), [

				'EventTitle'    	=> 'required|between:8,80',
	
				'EventDescription'  => 'required|between:200,2000',	
	
				'EventCategory' 	=> 'required|between:1,20',
	
				'EventStartTime'    => 'required|date|after:now',
	
				'EventEndTime'     	=> 'required|date|after:EventStartTime',
	
				'EventLocation'		=> 'between:0,200',
	
			]);
			//pull the organiser ID from session variables
			$organiserID = $request->session()->get('OrganiserID');

			//Format the dates
			$formattedStartDate = $this->formatDate($request->EventStartTime);
			$formattedEndDate = $this->formatDate($request->EventEndTime);

			//Split the input file path into an array on a backslash (explode) 
			$eventImgPathArr = explode('/', $request->EventImagePath);
			//retrieve the last value of the path array (end)
			$eventImgFileName = end($eventImgPathArr);

			$eventArr = array(
				'EventTitle'    	=>      $request->EventTitle,

				'EventDescription'  =>      $request->EventDescription,

				'EventCategory'     =>      $request->EventCategory,

				'EventStartTime'    =>      $formattedStartDate,

				'EventEndTime'      =>      $formattedEndDate,
				'EventLocation'		=>		$request->EventLocation,
				'EventOrganiserID'  => 		$organiserID
			);
			//Create a new record in the Event table with the above details
			$newEventID = Event::insertGetId($eventArr);
			
			//Upload the file and get the filePath in return
			$filePath = $this->storeImg($newEventID, $request);

			$updatedEvent = Event::where("EventID", $newEventID)
			->update(['EventImagePath' => $filePath]);

			//Redirect to the event page and pass the newly-created event details as a parameter
			return redirect()->route('event', ['eventID'=>$newEventID]);
	}
	public function formatDate($date){

		$date = Carbon::parse($date);
			return $date->format('Y-m-d H:i:s');
	}
	public function getUpdateEventForm($eventID){

		$eventData = DB::table('event')
		->select('EventImagePath','EventID','EventTitle','EventDescription', 'EventCategory', 'EventStartTime', 'EventEndTime', 'EventLocation','EventOrganiserID','EventInterestRank')
		->where('EventID','=',$eventID)
		->get();

		return view('/updateEvent', array('Event'=>$eventData));

	}

	public function updateEvent(Request $request){

		$this->validate(request(), [

			'EventTitle'    	=>	'required|between:8,80',

			'EventDescription'  => 	'required|between:200,2000',	

			'EventCategory' 	=> 	'required|between:1,20',

			'EventStartTime'    => 	'required|date|after:now',

			'EventEndTime'     	=> 	'required|date|after:EventStartTime',

			'EventLocation'		=> 	'between:0,200',

		]);

		$eventID = $request->EventID;


					//Use Carbon
		$startDate = Carbon::parse($request->EventStartTime);
		$formattedStartDate = $startDate->format('Y-m-d H:i:s');

		$endDate = Carbon::parse($request->EventEndTime);
		$formattedEndDate = $endDate->format('Y-m-d H:i:s');

		Event::where('EventID', $eventID)
			 ->update([
				'EventTitle'    	=>  	$request->EventTitle,

				'EventDescription'  =>      $request->EventDescription,

				'EventCategory'     =>      $request->EventCategory,

				'EventStartTime'    =>      $formattedStartDate,

				'EventEndTime'      =>      $formattedEndDate,

				'EventLocation'		=>		$request->EventLocation
			]);

			//Split the input file path into an array on a backslash (explode) 
			$eventImgPathArr = explode('/', $request->EventImagePath);
			//retrieve the last value of the path array (end)
			$eventImgFileName = end($eventImgPathArr);
		if (!is_null($eventImgFileName) && $eventImgFileName !=''){
			
			//Upload the file and get the filePath in return
			$filePath = $this->storeImg($eventID, $request);



			Event::where('EventID', $eventID)
				 ->update([
					'EventImagePath' => 	$filePath
				]);
		}


		

		return $this->getEventByID($eventID);
	}

	public function storeImg(Int $newEventID, Request $request){
		//If the request has a file

		if ($request->hasFile('EventImagePath')){

			//store the image in the images/events
			//$filePath = Storage::putFile('images/events/' . $newEventID, $request->file('eventImg'));
			$filePath = $request->file('EventImagePath')->storePublicly('images/events/'. $newEventID);

			return $filePath;
		}

	}

	public function listMyEvents($organiserID){
		$events =DB::table('event')
		->leftJoin('organiser', 'event.EventOrganiserID', '=','organiser.OrganiserID')
		->where('EventOrganiserID','=',$organiserID)
        ->get();

		return view('/list',array('Event'=>$events));
	}
	public function getEventByID(Int $eventID){

		$eventData = DB::table('event')
		->select('EventID',
				'EventTitle',
				'EventDescription',
				'EventCategory',
				'EventStartTime',
				'EventEndTime', 
				'EventLocation',
				'EventOrganiserID',
				'OrganiserFirstName',
				'OrganiserLastName',
				'OrganiserEmailAddress',
				'EventInterestRank',
				'EventImagePath'
				)
		->leftJoin('organiser', 'event.EventOrganiserID', '=','organiser.OrganiserID')
		->where('EventID','=',$eventID)
        ->get();
		//Redirect to the event page and pass the newly-created event details as a parameter
		return view('/event', array('Event'=>$eventData));
	}
}
