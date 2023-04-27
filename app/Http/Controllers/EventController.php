<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Logistics;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events =  Event::query()
        ->with('logistics')
        ->withCount('participants')
        ->orderBy('id','DESC')
        ->paginate();

        return view('adminpanel.event.index',compact('events'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminpanel.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $fee = [];
        foreach($request->reg_purpose as $key=>$value){
            if(!($value||$request->reg_fee[$key])){
                continue;
            }
            if($request->mandatory[$key] ===  '1' ){
                $fee[$value] = -1* $request->reg_fee[$key];
                continue;
            }
            $fee[$value] = (int) $request->reg_fee[$key];
        }
        $request['date']  = strtotime($request->event_date . ' ' . $request->event_time);
        $request['reg_last_date']  = strtotime($request->reg_date . ' ' . $request->reg_time);
        $request['fee']  = count($fee) ?$fee : null;
        // return $request;

        $event = Event::create($this->validation($request) + [
            'created_by'     => Auth::user()->id,
        ]);

        if(!empty($request->item_name)){

            foreach($request->item_name as $key => $item)
            {
                $logistics = new Logistics();
                $logistics->event_id = $event->id;
                $logistics->item = $item;
                $logistics->quantity = $request->item_quantity[$key];
                $logistics->save();
            }

        }

   

        return back()->with('success', 'Event has been Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return $event;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {

        $event->load('logistics');
        $mandatory = [];
        $reg_purpose = [];
        $reg_fee = [];

        if(isset($event->fee)){
            foreach($event->fee as $key=>$value){
                $reg_purpose[]= $key;
                $mandatory[]= $value<0 ? 1:0;
                $reg_fee[]= abs($value);
            }
        }

// return
        $event_data = [
            'id' => $event->id,
            'name' => $event->name,
            'event_date' => date("Y-m-d",$event->date),
            'event_time' => date("H:i",$event->date),
            'reg_date' => date("Y-m-d",$event->reg_last_date),
            'reg_time' => date("H:i",$event->reg_last_date),
            'location' => $event->location,
            'visibility' => $event->is_visible,
            'google_form_link' => $event->google_form_link,
            'reg_purpose' => $reg_purpose,
            'reg_fee' => $reg_fee,
            'mandatory' => $mandatory,
            'Haslogistics' => $event->logistics->count() > 0 ? true : false,
            'Eventlogistics' => $event->logistics
        ];

        return view('adminpanel.event.edit',compact('event_data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $fee = [];
        if(isset($request->reg_purpose)){

            foreach($request->reg_purpose as $key=>$value){
                if(!($value||$request->reg_fee[$key])){
                    continue;
                }
                if($request->mandatory[$key] ===  '1' ){
                    $fee[$value] = -1* $request->reg_fee[$key];
                    continue;
                }
                $fee[$value] = (int) $request->reg_fee[$key];
            }
        }
        $request['date']  = strtotime($request->event_date . ' ' . $request->event_time);
        $request['reg_last_date']  = strtotime($request->reg_date . ' ' . $request->reg_time);
        $request['fee']  = count($fee) ?$fee : null;
        // return $request;

        $event->update($this->validation($request) + [
            'created_by'     => Auth::user()->id,
        ]);


        if(!empty($request->item_name))
        {

            Logistics::where('event_id', $event->id)->delete();
            foreach($request->item_name as $key => $item)
            {
                $logistics = new Logistics();
                $logistics->event_id = $event->id;
                $logistics->item = $item;
                $logistics->quantity = $request->item_quantity[$key];
                $logistics->save();
            }
        }

        return back()->with('success', 'Event has been Created Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }


    private function validation($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required'
            ],

            'date' => [
                'required'
            ],

            'reg_last_date' => [
                'required'
            ],
            'fee' => '',
            'image' => '',
            'location' => '',
            'google_form_link' => '',
            'is_visible' => 'boolean',

        ]);
    }

    public function visibility($id)
    {

        $event = Event::find($id);
        if($event->is_visible == 1)
        {
            $event->is_visible = 0;
        }
        else {
            $event->is_visible = 1;
        }
        $event->save();
        return back()->with('success', 'Event has been Activated Successfully!');
    }
}
