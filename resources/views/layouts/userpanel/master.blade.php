<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
      <link rel="icon" type="image/x-icon" href="{{ asset('logo/brand.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .input-text-center {
            text-align: center;
        }
        /* ::-webkit-input-placeholder {
            text-align: center;
        }
        :-moz-placeholder {
            text-align: center;
        } */
    </style>
    
</head>

<body>

    <div class="bg-white pb-6 sm:pb-8 lg:pb-12">
        <div class="max-w-screen-2xl px-4 md:px-8 mx-auto">
            <header class="flex justify-between items-center border-b py-4 md:py-8 mb-8 md:mb-12 xl:mb-16">
                <!-- logo - start -->
                <a href="/" class="inline-flex items-center text-black-800 text-2xl md:text-3xl font-bold gap-2.5"
                    aria-label="logo">
                    <img src="{{ asset('logo/brand.png') }}" style="max-width:2em;height:auto;" alt="Logo">
                   <span style="color:black;">Event Management</span>
                </a>
                <!-- logo - end -->

                <!-- nav - start -->
                <nav class="hidden lg:flex gap-12">
                    <!-- <a href="#" class="text-indigo-500 text-lg font-semibold">Home</a>
                    <a href="#"
                        class="text-gray-600 hover:text-indigo-500 active:text-indigo-700 text-lg font-semibold transition duration-100">Features</a>
                    <a href="#"
                        class="text-gray-600 hover:text-indigo-500 active:text-indigo-700 text-lg font-semibold transition duration-100">Pricing</a>
                    <a href="#"
                        class="text-gray-600 hover:text-indigo-500 active:text-indigo-700 text-lg font-semibold transition duration-100">About</a> -->
                </nav>
                <!-- nav - end -->

                <!-- buttons - start -->


                <button type="button"
                    class="inline-flex items-center lg:hidden bg-gray-200 hover:bg-gray-300 focus-visible:ring ring-indigo-300 text-gray-500 active:text-gray-700 text-sm md:text-base font-semibold rounded-lg gap-2 px-2.5 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd" />
                    </svg>

                    Menu
                </button>
                <!-- buttons - end -->
            </header>

           @yield('content')

        </div>
    </div>



    <footer class="text-gray-600 body-font ">

        <div class="bg-white">
            <div class="container mx-auto py-4 px-5 flex flex-wrap flex-col sm:flex-row">
                <p class="text-gray-500 text-sm text-center sm:text-left mx-auto">© 2023 Event Management —
                    <a href="#" rel="noopener noreferrer" class="text-gray-600 ml-1"
                        target="_blank">Developed by <strong>TEAM</strong></a>
                </p>

            </div>
        </div>
    </footer>


   <!-- All scripts -->
    {{-- <script src="https://unpkg.com/axios/dist/axios.min.js" defer></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script> --}}
    <script src="https://unpkg.com/axios/dist/axios.min.js" defer></script>
    @yield('footer_js')
</body>

</html>
