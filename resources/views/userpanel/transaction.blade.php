@extends('layouts.userpanel.master')

@section('content')
<section class="text-gray-600 body-font">

        <div class="container py-4 mx-auto">
          <div class="flex flex-col text-center w-full">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">{{ $participant_data['event']['name']}}</h1>



            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
              <span>Dear </span>
              <span class="text-lg text-purple-600 font-bold">{{ $participant_data['user']['name'] }}</span>
            </p>

            <p class="font-semibold text-green-500 text-xl mb-4">Thank you for your effort! </p>

            <p>
              <span>We are accepting </span>
              <span class="text-blue-600 font-bold text-xl"> Bkash </span>
              <span> Payment</span>
            </p>

            <p>
              <span>Please </span>
              <span class="text-blue-600 font-bold text-xl"> Make Payment </span>
              <span> (not Send Money) to </span>
              <span class="text-red-700 font-bold text-xl"> 01404432554</span>
            </p>

            <div class="lg:w-1/4 md:w-full mx-auto mb-5 mt-5">
                <div class="overflow-x-auto relative">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 text-center">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">
                                   Name
                                </th>
                                <th scope="col" class="py-3 px-6">
                                    Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Payable Amount
                                </th>
                                <td class="py-4 px-6">
                                    {{ $participant_data['participant']['payable_amount'] }}/-
                                </td>
                            </tr>

                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Charge
                                </th>
                                <td class="py-4 px-6">
                                  {{ $participant_data['charge'] }}%
                                </td>
                            </tr>

                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="py-4 px-6 text-xl text-red-800">
                                    Total
                                </th>
                                <td class="py-4 px-6">
                                  <span class="text-blue-600 font-bold text-xl">{{ $participant_data['total_amount'] }}/-</span>
                                </td>
                            </tr>

                            @if ($participant_data['paid_amount'] )
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                              <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                  Already paid 
                              </th>
                              <td class="py-4 px-6">
                                {{ $participant_data['paid_amount'] }}
                              </td>
                          </tr>

                          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                              <th scope="row" class="py-4 px-6 text-xl text-red-800">
                                  Due
                              </th>
                              <td class="py-4 px-6">
                                <span class="text-blue-600 font-bold text-xl">{{ $participant_data['total_amount'] - $participant_data['paid_amount']}}/-</span>
                              </td>
                          </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
               </div>

           <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="event_id" value="{{ $participant_data['event']['id'] }}">
            <input type="hidden" name="participant_id" value="{{ $participant_data['participant']['id'] }}">
            <div class="lg:w-1/2 w-full md:w-2/3 mx-auto">
                <div class="flex flex-wrap -m-2 justify-center">
                  <div class="xs:w-8/12 sm:w-6/12 lg:w-7/12 w-full p-2">

                    <div class="relative mb-5">
                      <label class="font-semibold">
                          <p>Please Provide <span class="text-blue-600 font-bold text-xl"> Bkash </span> A/C No.</p>
                        </label>

                      <input type="text" name="account_number" autocomplete="off"
                      class="lg:w-full md:w-1/2 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out input-text-center" required>
                    </div>

                    <div class="relative mb-5">
                      <label class="font-semibold">
                        <span>Please provide your </span>
                        <span class="text-blue-600 font-bold text-xl"> Transaction ID </span>
                      </label>
                      <input type="text" name="transaction_id" autocomplete="off"
                      class="lg:w-full md:w-1/2 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out input-text-center" required>
                    </div>


                    <div class="relative mb-5">
                      <label class="font-semibold">
                        <span>Amount you have to</span>
                        <span class="text-blue-600 font-bold text-xl"> Pay </span>
                        <span style="font-size: 1.3em"> (&#x09F3;) </span>
                      </label>
                      <input type="text" name="paid_amount" autocomplete="off" value="{{ $participant_data['total_amount'] - $participant_data['paid_amount'] ?? old('paid_amount')}}"
                      class="lg:w-full md:w-1/2 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out input-text-center" required>
                    </div>


                    <div class="relative mb-5">
                      <label class="font-semibold">
                        <span>Note </span>
                      </label>
                      <textarea name="note" id="" cols="30" rows="3" class="lg:w-full md:w-1/2 bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"></textarea>
                    </div>

                  </div>

                  <div class="p-2 w-full">
                      <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Submit</button>

                  </div>

                </div>

              </div>
           </form>
          </div>
        </div>
</section>
@endsection
