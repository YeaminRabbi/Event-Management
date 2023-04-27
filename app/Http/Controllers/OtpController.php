<?php

namespace App\Http\Controllers;

use App\Helpers\Sms\Sms;
use App\Models\Event;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function otp_verification(Request $request)
    {

        // return $request->all();
        $validation = $request->validate([
            'phone' => 'required',
            'eventID' => 'required',
            'OTP' => 'required',
        ]);

        // return
        $event = Event::find($request->eventID);
        $reg_match =  preg_match("/^(\+88|0088|)01([123456789])([0-9]{8})$/", $request->phone);
        if ($reg_match && strlen($request->phone) >= 11) {
            $sub_phone = substr($request->phone, -11);
            $otpVerify = Otp::where('phone', $sub_phone)->where('code', $request->OTP)->exists();
            // return
            $user = null;
            if ($otpVerify) {
                $user = User::with(['participants' => function ($q) use ($request) {
                    $q->where('event_id', $request->eventID);
                }])->where('phone', $sub_phone)->first();
                // return
                $participant_id = ($user ? ($user->participants[0]->id ?? Null ) : null);
            }
        }
        return Response([
            'otp' => $otpVerify,
            'user' => $user ? $user->makeHidden('participants') : null,
            'participant_id' => $participant_id ?? null,
            'event_name' => $event->name
        ]);
    }

    private $token_encryption_key = 'mWTlWyuxO4kpWxVzWtQ';

    public function otp_request(Request $request)
    {
        // return $request;
        $code =  rand(1111, 9999);

        $validation = $request->validate([
            'phone' => 'required|string',
        ]);

        // return
        $sub_phone = substr($request->phone, -11);
        $otp = Otp::updateOrCreate(
            [
                'phone' => $sub_phone
            ],
            [
                'code' => $code
            ]
        );



        $details = [
                'otp' => $code,
            ];
        
        \Mail::to($request->email)->send(new \App\Mail\MyTestMail($details));
        

        $token = urldecode(base64_encode(json_encode([$this->token_encryption_key . '-' . $request->event_id, $request->phone , $request->email])));

        return redirect()->route('otp-verification-form', [$token, $request->email]);
    }

    public function otp_verification_form(Request $request, $token)
    {

        $data = json_decode(base64_decode(urldecode($token)));

        if (((explode('-', $data[0] ?? '')[0] ?? '') != $this->token_encryption_key)) {
            return redirect()->route('home');
        }

        $event_id = explode('-', $data[0] ?? null)[1] ?? null;

        $phone = $data[1] ?? null;
        $email = $data[2] ?? null;

        if ($event_id == null || $phone == null) {
            return redirect()->route('home');
        }


        return view('userpanel.otp_verification', [
            'event' => Event::find($event_id),
            'phone' => $phone,
            'email' => $email,
            'token' => $token,
        ]);
    }



    // public function send_otp(Request $request){
    //     $otp =  rand(1111, 9999);

    //     $validation = $request->validate([
    //         'phone' => 'required|string',
    //     ]);

    //     $sub_phone = substr($request->phone, -11);
    //     $otp = Otp::updateOrCreate(
    //         [
    //             'phone' => $sub_phone
    //         ],
    //         [
    //             'code' => $otp
    //         ]
    //     );
    //     return response([
    //         'msg' => 'OTP send successfully',
    //         'otp' => $otp
    //     ]);
    // }

    public function resend_otp(Request $request)
    {
        // return $request;
        $code =  rand(1111, 9999);

        $validation = $request->validate([
            'phone' => 'required|string',
        ]);

        $sub_phone = substr($request->phone, -11);
        $otp = Otp::updateOrCreate(
            [
                'phone' => $sub_phone
            ],
            [
                'code' => $code
            ]
        );

        Sms::send($sub_phone, 'Your CDSC.INFO verification code: ' . $code);

        return response([
            'msg' => 'success',
            'otp' => $otp
        ]);
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
    public function show($id)
    {
        //
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
}
