@extends('layout')

@section('body')
    <h1 class="text-xl font-bold mb-6">Ratings (Survey {{$surveyId}})</h1>

    @if (session('success'))
        <div class="bg-green-100 rounded-lg py-5 px-6 mb-6 text-base text-green-700 mb-6 w-1/3" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 rounded-lg py-5 px-6 mb-6 text-base text-red-700 mb-6 w-1/3" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="border-b">
                        <tr>
                            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Score</th>
                            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Survey Name</th>
                            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">User name</th>
                            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Comment</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ratings as $rating)
                            <tr class="border-b">
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    {{$rating['score']}}
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{$rating['survey']['metric']}}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{optional($rating['user'])['username']}}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{$rating['comment']}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="md:flex md:items-center">
        <div class="md:w-1/3">
            <a href="{{ url('surveys') }}">
                <button type="button" class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out"><i class="fas fa-arrow-left pr-1"></i>Surveys</button>
            </a>
            <a href="{{url('surveys/' . $surveyId  . '/ratings/create')}}">
                <button class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                    Add rating
                </button>
            </a>
        </div>
        <div class="md:w-2/3"></div>
    </div>


@endsection
