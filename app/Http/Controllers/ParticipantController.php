<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Participant;
use App\Models\Payment;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  public function custom($id)
    //  {
    //     return $id;
    //  }
    public function index(Request $request)
    {
        // return
            // return
            $participants = Participant::query()
            ->with('payments', 'user','verified_by_admin')
            ->when($request->event_id, function($q)  use($request){
                $q
                ->where('event_id', $request->event_id);
            })
            ->paginate();

            // $participants = Participant::query()
            // ->with(['payments'=>function($q){
            //     $q->latest()
            //     ->take(1);
            // }, 'user'])
            // ->when($request->event_id, function($q)  use($request){
            //     $q
            //     ->where('event_id', $request->event_id);
            // })
            // ->paginate();

        return view('adminpanel.participant.index',compact('participants'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {

        // return $payment_id;

        $participant = Participant::where('id', $id)
        ->with('user')
        ->first();

        $userID = $participant->user_id;
        // return
        $eventsAttended = Participant::query()
        ->with('payments', 'event')
        ->when( $userID , function($q)  use($userID){
            $q
            ->where('user_id', $userID);
        })
        ->orderBy('created_at','desc')
        ->paginate();

        
        $eventID = $participant->event_id;

        return view('adminpanel.participant.show',[
            'eventsAttended'=> $eventsAttended,
            'participant' => $participant,
            'eventID'=> $eventID,
            'payment_id'=> $request->payment_id ?? null
        ]);
        // return view('adminpanel.participant.show', compact('eventsAttended', 'participant','eventID','payment_id'));
        
        // $eventID = $participant->event->id;
        // $OtherEvents = Participant::with('event')
        // ->whereDoesntHave('event', function($query) use ($eventID){
        //     $query->where('id', $eventID);
        // })
        // ->where('user_id', $participant->user->id)
        // ->get();

        // $participatedEvents = Participant::with('event')
        // ->where('user_id', $participant->user->id)
        // ->get();



        // return  [$participant,$OtherEvents];
        // return view('adminpanel.participant.show', compact('participant', 'OtherEvents', 'participatedEvents'));
    }

    public function payment_details(Request $request)
    {
        // return $request;
        // return
        $payments = Payment::where('participant_id', $request->participant)->get();

        return view('adminpanel.participant.payment_details', compact('payments'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function register_event(Participant $participant)
    {

        $participant->update([
            'verified_by' =>Auth::id(),
            'verified_at' =>now()
        ]);

        
        return back()->with('success', 'Participant registered successfully');
    }



}
