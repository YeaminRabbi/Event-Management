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

                    <p class="font-bold text-center mb-3 md:mb-3"><i class="fa fa-calendar-check-o"
                            aria-hidden="true"></i>&nbsp;{{ date('d/m/y', $event->date) }} &nbsp;|&nbsp; <i
                            class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;{{ date('h:i a', $event->date) }} </p>

                    <p class="text-red-700 font-bold text-center mb-3 md:mb-3">Last Date of Reg:
                        {{ date('d/m/y | h:i a', $event->reg_last_date) }}</p>


                </div>
                <form class="max-w-screen-md  gap-4 mx-auto" id="EventForm" style="visibility:;"
                    action="{{ route('formSubmission') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}" id="eventID">
                    <input type="hidden" name="phone" value="{{ $phone }}" id="phone">

                    <div class="sm:col-span-2">
                        <label for="phone" class="inline-block text-gray-800 text-sm sm:text-base mb-2">Cell Phone no.
                            <strong class="text-red-600">*</strong></label>
                        <div>
                            <input type="text"
                                class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2"
                                required disabled  value="{{ $phone }}"/>


                            {{-- <img id="validatePhone" class="hidden" src="/logo/icons8-checkmark.gif" alt="logo"
                                style="width: 5%">
                            <img id="invalidPhone" class="hidden" src="/logo/icons8-error.gif" alt="logo"
                                style="width: 5%"> --}}
                            {{-- <p class="text-red-600 font-bold" id="InvalidPhoneCheck"></p> --}}
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4 mx-auto mt-5" id="formVisibility">
                        <div class="sm:col-span-2">
                            <label for="name" class="inline-block text-gray-800 text-sm sm:text-base mb-2">Full Name
                                <strong class="text-red-600">*</strong> </label>
                            <input type="text" name="name" id="name" placeholder="Enter Name" value="{{ $name ?? ''}}"
                                class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2"
                                required />
                        </div>

                        <div class="sm:col-span-2">
                            <p class="text-gray-800 text-sm sm:text-base">Gender <strong class="text-red-600">*</strong></p>
                        </div>
                        @if (isset($gender))
                            <div class="flex items-center pl-4 rounded border border-gray-200 dark:border-gray-700">
                                    
                                <input id="bordered-radio-1" type="radio" value="male" name="gender"  @if ($gender == 'male')checked @endif
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 ">
                                <label for="bordered-radio-1"
                                    class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">Male</label>
                            </div>
                            <div class="flex items-center pl-4 rounded border border-gray-200 dark:border-gray-700">
                                <input id="bordered-radio-2" type="radio" value="female" name="gender"  @if ($gender == 'female')checked @endif
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 ">
                                <label for="bordered-radio-2"
                                    class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
                            </div>  
                        @else
                            <div class="flex items-center pl-4 rounded border border-gray-200 dark:border-gray-700">
                                
                                <input id="bordered-radio-1" type="radio" value="male" name="gender"  
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 ">
                                <label for="bordered-radio-1"
                                    class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">Male</label>
                            </div>
                            <div class="flex items-center pl-4 rounded border border-gray-200 dark:border-gray-700">
                                <input id="bordered-radio-2" type="radio" value="female" name="gender"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 ">
                                <label for="bordered-radio-2"
                                    class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">Female</label>
                            </div>  
                        @endif
                        


                        <div class="sm:col-span-2 mb-3">
                            <label for="emergency_contact_name"
                                class="inline-block text-gray-800 text-sm sm:text-base mb-2">Emergency Contact Name<strong
                                    class="text-red-600">*</strong></label>
                            <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ $emergency_contact_name ?? ''}}"
                                class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2"
                                required />
                        </div>


                        <div class="sm:col-span-2 mb-3">
                            <label for="emergency_contact"
                                class="inline-block text-gray-800 text-sm sm:text-base mb-2">Emergency
                                Contact No. </label><strong class="text-red-600">*</strong>
                            <input type="text" id="emergency_contact" name="emergency_contact" placeholder="017*******" value="{{ $emergency_contact_phone ?? ''}}"
                                class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2"
                                required />
                        </div>

                        <div class="sm:col-span-2 mb-3">
                            <label for="email" class="inline-block text-gray-800 text-sm sm:text-base mb-2">Email
                                Address<strong class="text-red-600">*</strong></label>
                            <div style="display: flex">
                                <input type="email" name="email" id="email" placeholder="john12@gmail.com"
                                    class="w-full bg-gray-50 text-gray-800 border focus:ring ring-indigo-300 rounded outline-none transition duration-100 px-3 py-2"
                                    required onkeyup="mailCheck(this)" value="{{ $email ?? ''}}" />
                                <img id="validateEmail" class="hidden" src="/logo/icons8-checkmark.gif" alt="logo"
                                    style="width: 5%">
                                <img id="invalidEmail" class="hidden" src="/logo/icons8-error.gif" alt="logo"
                                    style="width: 5%">
                            </div>
                        </div>
                        
                       


                        
                        @if (isset($event->fee))
                            <style>
                                .special_chack {
                                    accent-color: green;
                                }
                            </style>
                            <div class="sm:col-span-2 mb-3">
                                <label class="inline-block text-gray-800 text-sm sm:text-base mb-2">Event Fee</label>
                                @foreach ($event->fee as $key => $item)
                                    <span class="text-red-500 font-bold flex hidden" id="alert{{ $key }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6  pr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>

                                        {{ $key }} is mandatory
                                    </span>
                                    <div class="flex"
                                        @if ($item < 0) onclick="vibrate('{{ $key }}')" @endif>
                                        <div class="my-auto"
                                            @if ($item < 0) style="cursor: not-allowed;" @endif>
                                            <input type="checkbox" id="fee-{{ $key }}"
                                                name="optional_selected_fee[]"
                                                @if ($item < 0) style="pointer-events:none ;" @endif
                                                value="{{ $key }}:{{ abs($item) }}"
                                                class="w-auto mr-3 {{ $item < 0 ? 'special_chack' : 'cursor-pointer' }}"
                                                @if ($item < 0) checked @endif />
                                        </div>

                                        <div class="my-auto"
                                            @if ($item < 0) style="cursor: not-allowed;" @endif>
                                            <label for="fee-{{ $key }}"
                                                @if ($item < 0) style="pointer-events:none" @endif
                                                class="inline-block text-gray-800 text-sm sm:text-base mb-2 mt-2 cursor-pointer">{{ $key }}
                                                :
                                                {{ abs($item) }}</label>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="sm:col-span-2 flex justify-between items-center">
                            <button type="submit"
                                class="inline-block bg-indigo-500 hover:bg-indigo-600 active:bg-indigo-700 focus-visible:ring ring-indigo-300 text-white text-sm md:text-base font-semibold text-center rounded-lg outline-none transition duration-100 px-8 py-3">Submit</button>
                        </div>
                    </div>
                    


                </form>
                <!-- form - end -->
            </div>
        </div>
    </section>


@endsection

@section('footer_js')
    <script>


        function vibrate(item = "This content") {
            console.log(item);
            window.navigator.vibrate(100);

            document.getElementById(`alert${item}`).classList.remove('hidden')
            document.getElementById(`alert${item}`).classList.add('animate-bounce')

            setTimeout(() => {
                document.getElementById(`alert${item}`).classList.add('hidden')
                document.getElementById(`alert${item}`).classList.remove('animate-bounce')
            }, 2000);

            // console.log('Test Vibrate');


        }
    </script>

    <script>
        phoneCheck();
        function mailCheck(element) {
            var email = element.value; ///get id with value
            var emailpattern =
                /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/; ////Regular expression
            let validateEmail = document.getElementById('validateEmail')
            let invalidEmail = document.getElementById('invalidEmail')


            if (email.length == 0) {
                element.style.backgroundColor = '#fff';
                validateEmail.classList.add('hidden')
                invalidEmail.classList.add('hidden')
            } else if (!emailpattern.test(email)) {
                element.style.backgroundColor = '#fecaca';
                validateEmail.classList.add('hidden')
                invalidEmail.classList.add('hidden')
            } else {
                axios.post('/mail-check', {
                        email
                    })
                    .then(function(response) {
                        let color = response.data ? '#fecaca' : '#fff';
                        if (response.data) {
                            validateEmail.classList.add('hidden')
                            invalidEmail.classList.remove('hidden')
                        } else {
                            invalidEmail.classList.add('hidden')
                            validateEmail.classList.remove('hidden')

                        }
                        response.data ? invalidEmail.classList.remove('inbalidEmail') : '#fff';
                        element.style.backgroundColor = color;
                        console.log(color);
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }

            // console.log(element.value.indexOf('@') > -1 && element.value.indexOf('@') + 2 < element.value.indexOf('.'))
        }

        function phoneCheck() {
            var phone = document.getElementById('phone').value; ///get id with value
            console.log(phone)
            // var phonePattern =
            //     /^(\+88|0088|)01([123456789])([0-9]{8})$/; ////Regular expression
            // let invalidPhoneCheck = document.getElementById('InvalidPhoneCheck')
            // let eventID = document.getElementById('eventID').value
            // let formVisibility = document.getElementById('formVisibility')
            // let name = document.getElementById('name')
            // let gender = document.querySelectorAll('[name="gender"]');
            // let emergency_contact_name = document.querySelector('[name="emergency_contact_name"]');
            // let emergency_contact = document.querySelector('[name="emergency_contact"]');
            // let email = document.getElementById('email')
            // let bmds = document.getElementById('bmdx')


            // if (phone.length == 0) {
            //     element.style.backgroundColor = '#fff';
            //     // invalidPhoneCheck.innerHTML = ''
            //     document.getElementById('InvalidPhoneCheck').text("Not in length");
            //     console.log('not in length');
            // } else if (!phonePattern.test(phone)) {
            //     element.style.backgroundColor = '#fecaca';
            //     formVisibility.classList.add('hidden')
            //     // invalidPhoneCheck.innerHTML = ''
            //     console.log('Not in phone pattern')
            // } else {

            //     console.log('Axios start')
            //     axios.post('/fetch-user', {
            //             phone,
            //             eventID

            //         })
            //         .then(function(response) {
            //             console.log(response.data);
            //             let color = '#fff';
            //             // let color = response.data ? '#fecaca' : '#fff';
            //             if (response.data && response.data.user) {
            //                 console.log('Valid Number');
            //                 let user = response.data.user
            //                 name.value = user.name;
            //                 emergency_contact_name.value = user.emergency_name;
            //                 emergency_contact.value = user.emergency_phone;
            //                 email.value = user.email;
            //                 bmdc.value = user.bmdc;
            //                 gender.forEach(element => {
            //                     element.checked = element.value == user.gender;
            //                 });

            //             } else {
            //                 console.log('Invalid Number');
            //                 name.value = ''
            //                 emergency_contact_name.value = ''
            //                 emergency_contact.value = ''
            //                 email.value = '';
            //                 bmdc.value = '';
            //                 gender.forEach(element => {
            //                     element.checked = false
            //                 });
            //             }
            //             // response.data ? invalidPhone.classList.remove('inbalidEmail') : '#fff';
            //             // element.style.backgroundColor = color;
            //             // console.log(color);
            //             // formVisibility.classList.remove('hidden')

            //         })
            //         .catch(function(error) {
            //             console.log(error);
            //         });
            // }

            // console.log(element.value.indexOf('@') > -1 && element.value.indexOf('@') + 2 < element.value.indexOf('.'))
        }
    </script>
@endsection
