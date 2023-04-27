<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Participant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    
    public function paymentSubmit(Request $request)
    {
        return $request;
    }

    public function index()
    {
        return view('welcome');
    }

    public function eventForm($id, $event_name)
    {
        $event = Event::where('id', $id)->where('is_visible', true)->first();

        // $currentTime = date('d-m-Y h:i:s a', strtotime(Carbon::now('Asia/Dhaka')));
        // $eventRegLastTime = date('d-m-Y h:i:s a', ($event->reg_last_date));

        $currentTime = strtotime(Carbon::now('Asia/Dhaka'));
        $eventRegLastTime = $event->reg_last_date;

        // return [$currentTime , $eventRegLastTime];


        if (!isset($event) || ($currentTime > $eventRegLastTime)) {
            $message = 'This Event Registration is either Not Open yet or Closed Already';
            return view('userpanel.event_status', compact('message'));
        } elseif (str_replace(" ", "-", $event->name) !== $event_name) {
            $message = 'This link is not correct';
            return view('userpanel.event_status', compact('message'));
        }


        
        return view('userpanel.check_phone',compact('event'));

    }

    public function eventFormRegistration(Request $request){
        $event = Event::where('id', $request->event_id)->where('is_visible', true)->first();

        //  return $request;
        if (!isset($event)) {
            $message = 'This Event Registration is either Not Open yet or Closed Already';
            return view('userpanel.event_status', compact('message'));
        }
        $name = $request->user_name ?? '';
        $email = $request->user_email ?? '';
        $emergency_contact_name = $request->user_emergency_name ?? '';
        $emergency_contact_phone = $request->user_emergency_phone ?? '';
        $gender = $request->user_gender ?? '';
        $bmdc = $request->user_bmdc ?? '';

        $participant = null;
        if($request->participant_id){
            // return 
            $participant = Participant::with('payments')->find($request->participant_id);
        }
        $fees = $participant ? $participant->selected_fee : [];  
        $paid_amount = $participant ? $participant->payments->sum('amount') : 0;  
        // $participant_id =$request-> ;
        
        
        $event_id = $request->event_id;
        $phone = $request->phone;


        



        return view('userpanel.event_form', compact('event','phone','event_id','name','email','emergency_contact_name','emergency_contact_phone','gender','bmdc','participant','paid_amount'));
    }




    public function transaction()
    {
        $participant_data = Session::get('latest_participant_data');
        // Session::forget('latest_participant_data');
        return view('userpanel.transaction', compact('participant_data'));
    }

    public function thankyou()
    {
        return view('userpanel.thankyou');
    }


    public function check_participant(Request $request){
        
        $reg_match =  preg_match("/^(\+88|0088|)01([123456789])([0-9]{8})$/", $request->phone);
        if ($reg_match && strlen($request->phone) >= 11) {
            $sub_phone = substr($request->phone, -11);
            $user = User::with(['participants' => function ($q) use ($request) {
                $q->where('event_id', $request->eventID);
            },
            'participants.payments'])->where('phone', $sub_phone)->first();
           
            return Response([
                'user' => (bool) $user,
                'registered' => $user->participants[0]->status ?? 0,
               
            ]);
        }


    }

    public function formSubmission(Request $request)
    {
        $user = User::updateOrCreate(
            [
                'phone'             => $request->phone
            ],
            [
                'name'              => $request->name,
                'emergency_name'    => $request->emergency_contact_name,
                'emergency_phone'   => $request->emergency_contact,
                'email'             => $request->email,
                'gender'            => $request->gender,
            ]
        );

        $selected_fee = [];
        $payable_amount = 0;
        if (isset($request->optional_selected_fee)) {
            if (count($request->optional_selected_fee)) {
                foreach ($request->optional_selected_fee as $fees) {
                    $fee = explode(':', $fees);
                    $selected_fee[] = $fee[0];
                    $payable_amount += $fee[1];
                }
            }
        }

        // return [$request->optional_selected_fee,$selected_fee, $payable_amount];

        $paymentStatus =0;
        // if(empty($selected_fee)){
        //     $paymentStatus = 1;
        // }

        $participant = Participant::updateOrCreate([
            'user_id' => (int) $user->id,
            'event_id' => (int) $request->event_id
        ], [

            'status' => (int) $paymentStatus,
            'selected_fee' => $selected_fee,
            'payable_amount' => (float) $payable_amount

        ]);
        $event = Event::find($request->event_id);
        // $charge = 1.8;
        $charge = 0;
        // return
        $total_amount = (float)$payable_amount + ((float)$payable_amount * ($charge / 100));
        $allData = [
            'user' => $user,
            'paid_amount' => $request->paid_amount ?? null,
            'participant' => $participant,
            'event' => $event,
            'charge' =>  $charge,
            'total_amount' => $total_amount
        ];
        Session::put('latest_participant_data', $allData);
        Session::save();

        if (empty($selected_fee)) {
            return redirect()->route('thankyou');
        }
        return redirect()->route('transaction');
        // return view('userpanel.transaction', compact('user','participant','event'));

    }

    public function mail_check(Request $request)
    {
        return
            User::where('email', $request->email)->exists();
    }


    // public function phone_check($id, $event_name)
    // {

    //     $event = Event::where('id', $id)->where('is_visible', true)->first();

    //     if (!isset($event)) {
    //         $message = 'This Event Registration is either Not Open yet or Closed Already';
    //         return view('userpanel.event_status', compact('message'));
    //     } elseif (str_replace(" ", "-", $event->name) !== $event_name) {
    //         $message = 'This link is not correct';
    //         return view('userpanel.event_status', compact('message'));
    //     }


    //     return view('userpanel.check_phone',compact('event'));
    // }


    public function phone_verification(Request $request)
    {

        // return $request;

        $reg_match =  preg_match("/^(\+88|0088|)01([123456789])([0-9]{8})$/", $request->phone);
        if ($reg_match && strlen($request->phone) >= 11) {
            $sub_phone = substr($request->phone, -11);
            $user = User::with(['participants' => function ($q) use ($request) {
                $q->where('event_id', $request->eventID);
            },
            'participants.payments'])->where('phone', $sub_phone)->first();
            $fees = [];
            $participated = (bool)($user ? !$user->participants->isEmpty() : 0);
            if($participated && !$user->participants->status ){
                $paid = $user->participants->payments->sum();
                $fees = $user->participants->selected_fees;
                
            }

            return Response([
                'user' => (bool) $user,
                // 'participated' => $participated,
                'registered' => $user->participants->status,
                // 'fees' => $fees
            ]);
            // return
            // User::where('phone', $sub_phone)->exists();
        }
    }

    public function fetch_user(Request $request)
    {

        // return $request;

        $reg_match =  preg_match("/^(\+88|0088|)01([123456789])([0-9]{8})$/", $request->phone);
        if ($reg_match && strlen($request->phone) >= 11) {
            $sub_phone = substr($request->phone, -11);
            // return
            $user = User::with(['participants' => function ($q) use ($request) {
                $q->where('event_id', $request->eventID);
            }])->where('phone', $sub_phone)->first();

            $participated = (bool)($user ? !$user->participants->isEmpty() : 0);

            // $user=DB::table('users')->where('phone',$request->phone)->get();
            return Response([
                'user' => $user ? $user->makeHidden('participants') : null,
                'participated' => $participated
            ]);
            // return
            // User::where('phone', $sub_phone)->exists();
        }
    }

    function event_checkout(Request $request){

        return $request->all();

    }
}
