@extends('layouts.userpanel.master')

@section('content')
    <section class="text-gray-600 body-font">
        <div class="bg-white sm:py-8">
            <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
                <!-- text - start -->
                <div class="mb-5 md:mb-8">
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
                <p id="numberExistMessage" class=" mx-auto  mb-3 text-center ">
                    An OTP cade has been send to <span class="text-xl font-bold"
                        style="color: #237bff;">{{ $email }}</span>
                </p>
                {{-- <form class="max-w-screen-md  gap-4 mx-auto" id="EventForm" style="visibility:;"
                    action="{{ route('otp-verification') }}" method="POST">
                    @csrf --}}

                <div class="max-w-screen-md  gap-4 mx-auto">

                    <div class="sm:col-span-2">
                        <label for="otp"
                            class="text-gray-800 text-sm sm:text-base mb-2 mx-auto flex justify-center items-center">Enter
                            OTP:
                        </label>
                        <input type="text" name="otp" id="otp" placeholder="Enter Your OTP"
                            class="w-full  bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2 input-text-center"
                            required />
                        <span class="font-bold text-red-600 hidden" id="otpNotification">Incorrect OTP</span>
                        <span class="font-bold text-red-600 hidden" id="otpNotificationLength">OTP has been send with 4
                            digits</span>

                    </div>
                    <div id="otp_buttons" class="sm:col-span-2 flex justify-center items-center mt-3 mb-5">
                        {{-- <a href="{{ route('home') }}" class="inline-block bg-gray-400 hover:bg-gray-500 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">Home
                            </a> --}}
                        <button onclick="OTPCheck()"
                            class="bg-blue-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">Confirm</button>
                    </div>

                    <div class="sm:col-span-2 mt-10 ">
                        <div class=" flex justify-center items-center">

                            <p class="mr-3">Did not get OTP? <span id="ResendOtpSection">Resend OTP after <span
                                        id="OTPtimer" class="text-purple-600"
                                        style="font-weight:800;font-size:25px;">120</span>s</span></p>

                            <button
                                class="bg-cyan-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline mr-1 mb-1 ease-linear transition-all duration-150 hidden"
                                id="ResendOtpButton" onclick="ResendOTP('{{ $phone }}')">Resend OTP</button>
                        </div>
                    </div>
                </div>

                <form action="{{ route('eventFormRegistration') }}" method="POST" style="visibility: hidden">
                    @csrf

                    <input type="text" name="user_name" id="user_name">
                    <input type="text" name="user_email" id="user_email">
                    <input type="text" name="user_emergency_name" id="user_emergency_name">
                    <input type="text" name="user_emergency_phone" id="user_emergency_phone">
                    <input type="text" name="user_gender" id="user_gender">
                    <input type="text" name="user_bmdc" id="user_bmdc">
                    <input type="text" name="participant_id" id="form_participated">
                    <input type="text" name="event_id" value="{{ $event->id }}" id="eventID">
                    <input type="text" name="phone" value="{{ $phone }}" id="phone">

                    <button type="submit" id="FORMBUTTON">Submit</button>
                </form>

                <form action="{{ route('eventFormRegistration') }}" method="POST" style="visibility: hidden">
                    @csrf


                    <input type="text" name="event_id" value="{{ $event->id }}" id="eventID">
                    <input type="text" name="phone" value="{{ $phone }}" id="phone">

                    <button type="submit" id="FORMBUTTONNewUser">Submit</button>
                </form>


                {{-- </form> --}}
                <!-- form - end -->
            </div>
        </div>
    </section>
@endsection

@section('footer_js')
    <script>
        const timeStorageKey = '{{ $token ?? '' }}_time_remaining';
        const time = localStorage.getItem(timeStorageKey);
        let countDown = time === null ? 120 : time;
        countDownTimer();
        // document.countDownTimer('ResendOtpSection').classList.add('hidden');
        function countDownTimer() {
            // console.log(countDown);
            if (countDown > 0) {
                setTimeout(() => {
                    countDown -= 1;
                    document.getElementById('OTPtimer').innerHTML = countDown;

                    localStorage.setItem(timeStorageKey, countDown);

                    countDownTimer()
                }, 1000)
            } else {
                document.getElementById('ResendOtpButton').classList.remove('hidden');
                document.getElementById('ResendOtpSection').classList.add('hidden');

            }
        }

        function ResendOTP(phone) {
            console.log(phone);
            axios.post('/otp-request/resend', {
                    phone,
                })
                .then(function(response) {
                    console.log(response.data);
                    countDown = 120;
                    localStorage.removeItem(timeStorageKey);

                    document.getElementById('ResendOtpButton').classList.add('hidden');
                    document.getElementById('ResendOtpSection').classList.remove('hidden');

                    countDownTimer();
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        function OTPCheck() {
            let eventID = document.getElementById('eventID').value
            let phone = document.getElementById('phone').value
            let OTP = document.getElementById('otp').value
            // console.log(OTP);

            if (OTP.length === 4) {
                axios.post('/otp-verification', {
                        phone,
                        eventID,
                        OTP

                    })
                    .then(function(response) {
                        console.log(response.data);
                        if (response.data.otp) {
                            if (response.data.user) {
                                document.getElementById('user_name').value = response.data.user.name ?? '';
                                document.getElementById('user_email').value = response.data.user.email ?? '';
                                document.getElementById('user_emergency_name').value = response.data.user
                                    .emergency_name ?? '';
                                document.getElementById('user_emergency_phone').value = response.data.user
                                    .emergency_phone ?? '';
                                document.getElementById('user_gender').value = response.data.user.gender;
                                document.getElementById('user_bmdc').value = response.data.user.bmdc ?? '';
                                document.getElementById('form_participated').value = response.data.participant_id;

                                document.getElementById("FORMBUTTON").click();
                            } else {
                                document.getElementById("FORMBUTTONNewUser").click();
                            }
                        } else {
                            document.getElementById('otpNotificationLength').classList.add('hidden');
                            document.getElementById('otpNotification').classList.remove('hidden');
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            } else {
                document.getElementById('otpNotificationLength').classList.remove('hidden');
                document.getElementById('otpNotification').classList.add('hidden');

            }




            // var phone = element.value; ///get id with value

            // var phonePattern =
            //     /^(\+88|0088|)01([123456789])([0-9]{8})$/; ////Regular expression
            // let numberExistMessage = document.getElementById('numberExistMessage')
            // let participantExistMessage = document.getElementById('participantExistMessage')
            // let otp_buttons = document.getElementById('otp_buttons')


            // if (phone.length == 0) {
            //     element.style.backgroundColor = '#fff';
            //     numberExistMessage.classList.add('hidden')
            //     otp_buttons.classList.add('hidden')
            // } else if (!phonePattern.test(phone)) {
            //     element.style.backgroundColor = '#fecaca';
            //     numberExistMessage.classList.add('hidden')
            //     otp_buttons.classList.add('hidden')
            // } else {
            //     numberExistMessage.classList.remove('hidden')
            //     otp_buttons.classList.remove('hidden')
            //     element.style.backgroundColor = '#fff';

            // }

        }
    </script>
@endsection
