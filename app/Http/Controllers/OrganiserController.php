<?php

namespace App\Http\Controllers;
use App\Models\Organiser;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OrganiserController extends Controller
{  
    public function index() {
        return view("register");
    }
    // register user
    public function registerOrganiser(Request $request) {
        //Validate the user variables.
        //If the email already exists in the Organiser table, the registration will be rejected.
        //This is the only additional logic applied at this level. 
        //All other validation rules are applied on the input form by using jQuery validation.
        $this->validate(request(), [

            'firstName'    => 'required',
            'lastName'     => 'required',
                                            //unique:tablename,columnname
            'emailAddress' => 'required|email|unique:Organiser,OrganiserEmailAddress',
            'phone'        => 'unique|digits_between:11,13',
            
            'password'     => 'required|between:8,20',


            
        ]);
        
        $password = $request->password;
        //Use bcrypt to generate a hash for the password
        $hashPass = password_hash($password, PASSWORD_DEFAULT);
        //Insert all of the request properties into an array for easy database insertion
        $user  =   array(
            "OrganiserFirstName"     =>      $request->firstName,
            "OrganiserLastName"      =>      $request->lastName,
            "OrganiserEmailAddress"  =>      strtolower($request->emailAddress),
            "OrganiserPhoneNumber"   =>      $request->phone,
            "OrganiserPassword"      =>      $hashPass,

        );
        $email = $user["OrganiserEmailAddress"];
        //Create the new user in the database Organiser table
        Organiser::create($user);
        //Retrieve current new organiser from the database table to grab variables for session
        $newUser = DB::table('Organiser')
        ->select('OrganiserID','OrganiserFirstName', 'OrganiserEmailAddress')
        ->where("OrganiserEmailAddress","=",$email)
        ->get();
        //Extract properties from the user array for use in a session
        // $organiserFirstName = $newUser["OrganiserFirstName"];
        // $organiserID = $newUser["OrganiserID"];
        // $organiserEmailAddress = $newUser["OrganiserEmailAddress"];

        $organiserFirstName = $newUser[0]->OrganiserFirstName;
        $organiserID = $newUser[0]->OrganiserID;
        $organiserEmailAddress = $newUser[0]->OrganiserEmailAddress;
        
        //create session variables
        session(['OrganiserID' => $organiserID]);
        session(['OrganiserFirstName' => $organiserFirstName]);
        session(['OrganiserEmailAddress' => $email]);
        //redirect to the home page
        return redirect()->route('home');

        

    }

    public function loginOrganiser(Request $request) {

        $this->validate(request(), [
            //Do NOT want to check if the email exists in the db at this stage, as that will print
            //an error message.
            'emailAddress' => 'required|email',

            'password'     => 'required',
    
        ]);

        $email = strtolower($request->emailAddress);
        $password = $request->password;
        //Use bcrypt to generate a hash for the password
        $hashPass = Hash::make($password);
        // $user = Organiser::where('OrganiserEmailAddress', '=', $email)
        // ->where('OrganiserPassword', '=', $hashPass);
        
        $user = DB::table('Organiser')
        ->select('OrganiserID','OrganiserFirstName', 'OrganiserEmailAddress',"OrganiserPassword")
        ->where("OrganiserEmailAddress","=",$email)
        ->get();


        
        //Extract properties from the user array for use in a session
        // $organiserFirstName = $newUser["OrganiserFirstName"];
        // $organiserID = $newUser["OrganiserID"];
        // $organiserEmailAddress = $newUser["OrganiserEmailAddress"];

        
        //if a user exists with this email and password combination
        if (!is_null($user) && !empty($user) && count($user) > 0){

            //If the password found for this registered user does not match the input
            if(!Hash::check($password, $user[0]->OrganiserPassword)){
                //return to login with an error
                return redirect()->route('login')->withErrors(['Invalid credentials. Please try again.']);
            }

            //start a new session, or resume existing
            session_start();

            $organiserFirstName = $user[0]->OrganiserFirstName;
            $organiserID = $user[0]->OrganiserID;
            $organiserEmailAddress = $user[0]->OrganiserEmailAddress;
            //populate the session variables
            session(['OrganiserID' => $organiserID]);
            session(['OrganiserFirstName' => $organiserFirstName]);
            session(['OrganiserEmailAddress' => $email]);
			//Create an OrganiserFirstName session variable
            
            
        //return to the home page
            return redirect()->route('home');
            
        }
        //If a user does not exist,
        else{
            //return to login with an error
            return redirect()->route('login')->withErrors(['Invalid credentials. Please try again.']);

        }


    }

    public function logoutOrganiser(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        return redirect()->route('home');

    }
}