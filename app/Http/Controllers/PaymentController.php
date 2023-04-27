<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return 
        $payments = Payment::with('participant.user','event')       
        ->orderBy('id','desc')->paginate();

        return view('adminpanel.payment.index',[
            'payments' => $payments
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
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }

    private function validation($request, $id = '')
    {
       
        return $request->validate([
            'account_number' => [
                'required'
            ],

            'transactionID' => [
                'required'
            ],

            'paid_amount' => [
                'required'
            ],
            'event_id' => [
                'required'
            ],
            'participant_id' => [
                'required'
            ],
            'transaction_id' => [
                'required'
            ],
            'amount' => [
                'required'
            ],
            'payment_method_id' => '1',
            'status'=>'0'
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'account_number' => 'required',
            'paid_amount' => 'required',
            'event_id' => 'required',            
            'participant_id' => 'required',            
            'transaction_id' => 'required',            
            
        ]);
        // return $request;
        $payment = new Payment();
        $payment->event_id = $request->event_id;
        $payment->participant_id = $request->participant_id;
        $payment->paid_by = $request->account_number;
        $payment->transaction_id = $request->transaction_id;
        $payment->amount = $request->paid_amount;
        $payment->note = $request->note;
        $payment->payment_method_id = 1;
        $payment->status = 0;
        $payment->save();


        return redirect()->route('thankyou');
        
    }

    public function payment_verify($id)
    {
        $payment = Payment::find($id);
        $payment->status = 1;
        $payment->varified_by = Auth::id();
        $payment->save();

        // $participant = Participant::where('id', $payment->participant_id)->first();
        // $participant->status = 1;
        // $participant->save();

        return back()->with('success', 'Payment Verified Successfully!');
    }
}
