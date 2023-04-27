@extends('layouts.userpanel.master')

@section('content')
    <section class="text-gray-600 body-font">
        <div class="bg-white sm:py-8">
            <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
                <!-- text - start -->
                <div class="mb-10 md:mb-16">
                    <h2 class="text-2xl lg:text-3xl font-bold text-center mb-2 md:mb-2" style="color:#237bff;">
                        {{ $event->name }}</h2>

                    @if (!empty($event->location))
                        <div class="flex items-center">
                            <div class="mx-auto">
                                <span class="text-xl lg:text-2xl font-bold text-center mb-1 md:mb-1"> <i
                                        class="fa fa-map-marker" aria-hidden="true"></i> &nbsp;{{ $event->location }}</span>
                            </div>
                        </div>
                    @endif

                    <p class="font-bold text-center mb-3 md:mb-3 "><i class="fa fa-calendar-check-o"
                            aria-hidden="true"></i>&nbsp;{{ date('d/m/y', $event->date) }} &nbsp;|&nbsp; <i
                            class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;{{ date('h:i a', $event->date) }} </p>

                    <p class="text-red-700 font-bold text-center mb-3 md:mb-3">Last Date of Reg:
                        {{ date('d/m/y | h:i a', $event->reg_last_date) }}</p>


                </div>
                <form class="max-w-screen-md  gap-4 mx-auto" id="EventForm" style="visibility:;"
                    action="{{ route('otp-request') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}" id="eventID">

                    <div class="sm:col-span-2">
                        <label for="phone" class="inline-block text-gray-800 text-sm sm:text-base mb-2">Cell Phone no.
                            <strong class="text-red-600">*</strong></label>
                        <div>
                            <input type="text" name="phone" id="phone" placeholder="017*******"
                                class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2 input-text-center"
                                required onkeyup="phoneCheck(this)" />
                        </div>
                    </div>

                     <div class="sm:col-span-2">
                        <label for="email" class="inline-block text-gray-800 text-sm sm:text-base mb-2">Email
                            <strong class="text-red-600">*</strong></label>
                        <div>
                            <input type="email" name="email" id="email" class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2 input-text-center" placeholder="xyz@gmail.com"
                                required />
                        </div>
                    </div>

                    <p id="numberRegisterToEvent" class=" mx-auto  mt-5 text-center font-bold hidden"
                        style="font-size: 1.5em; color: #237bff;">
                        Your registration has already been completed for this event
                    </p>

                    <p id="numberExistMessage" class=" mx-auto  mt-5 text-center font-bold  hidden"
                        style="font-size: 1.5em; color: #237bff;">
                        Please verify yourself
                    </p>


                    <div id="otp_buttons"
                        class="sm:col-span-2 flex justify-between items-center lg:m-10 md:m-10 m-5 hidden">
                        <a href="{{ route('home') }}">
                            <button
                                class="inline-block bg-gray-400 hover:bg-gray-500 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">Home</button>

                        </a>
                        <button type="submit" id="submitButton"
                            class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3 disabled">Send
                            OTP</button>
                    </div>

                </form>
                <!-- form - end -->
            </div>
        </div>
    </section>
@endsection

@section('footer_js')
    <script>
        function phoneCheck(element) {
            eventForm = document.getElementById('EventForm');

            eventForm.onsubmit = function() {
                console.log(eventForm);
                return false;
            };
            let eventID = document.getElementById('eventID').value
            var phone = element.value; ///get id with value

            var phonePattern =
                /^(\+88|0088|)01([123456789])([0-9]{8})$/; ////Regular expression
            let numberExistMessage = document.getElementById('numberExistMessage')
            let numberRegisterToEvent = document.getElementById('numberRegisterToEvent')
            let participantExistMessage = document.getElementById('participantExistMessage')
            let otp_buttons = document.getElementById('otp_buttons')



            if (phone.length == 0) {
                element.style.backgroundColor = '#fff';
                numberExistMessage.classList.add('hidden')
                otp_buttons.classList.add('hidden')
                otp_buttons.setAttribute("type", "div3")
                numberRegisterToEvent.classList.add('hidden')
            } else if (!phonePattern.test(phone)) {
                element.style.backgroundColor = '#fecaca';
                numberExistMessage.classList.add('hidden')
                otp_buttons.classList.add('hidden')
                numberRegisterToEvent.classList.add('hidden')

            } else {
                element.style.backgroundColor = '#fff';


                CheckParticipated(phone, eventID);

                function CheckParticipated(phone, eventID) {
                    console.log(phone, eventID);
                    // console.log(eventID);
                    axios.post('/check-participant', {
                            phone,
                            eventID
                        })
                        .then(function(response) {
                            console.log(response.data);
                            if (response.data.registered === 1) {
                                // console.log('already participated')
                                numberRegisterToEvent.classList.remove('hidden')
                            } else if (response.data.registered === 0) {
                                // console.log('not participated')
                                numberExistMessage.classList.remove('hidden')
                                otp_buttons.classList.remove('hidden')


                                eventForm.onsubmit = function() {
                                    console.log(eventForm);
                                    return true;
                                };
                            }


                        })
                        .catch(function(error) {
                            console.log(error);
                        });

                }

            }

            // console.log(element.value.indexOf('@') > -1 && element.value.indexOf('@') + 2 < element.value.indexOf('.'))
        }
    </script>
@endsection
