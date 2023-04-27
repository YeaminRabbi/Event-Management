@extends('layouts.userpanel.master')
@section('content')
<section class="text-gray-600 body-font relative">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-col text-center w-full mb-5">
            <h2 class="sm:text-3xl text-2xl font-medium title-font  text-gray-900">Thanks for your response</h2>
        </div>
        
        <div class="w-full">
           <a href="{{ route('home') }}">
             <button
                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Homepage</button>
           </a>
        </div>
    </div>
</section>
@endsection