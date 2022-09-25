@extends('layout')

@section('body')
    <h1 class="text-xl font-bold mb-6">Create new rating (Survey {{ $surveyId }})</h1>

    @if (session('error'))
        <div class="bg-red-100 rounded-lg py-5 px-6 mb-6 text-base text-red-700 mb-6 w-1/3" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 rounded-lg py-5 px-6 mb-4 text-base text-red-700 mb-6 w-1/3" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <form class="w-full max-w-lg" action="{{ url('surveys/' . $surveyId . '/ratings') }}" method="POST">
            @csrf

            <input type="hidden" name="survey_id" id="survey_id" value="{{ $surveyId }}">

{{--            <div class="flex flex-wrap -mx-3 mb-6">--}}
{{--                <div class="w-full px-3">--}}
{{--                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="username">--}}
{{--                        User name--}}
{{--                    </label>--}}
{{--                    <input type="text" id="username" name="username" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-gray-500 focus:outline-none" value="{{ old('username') }}">--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="score">
                        Score
                    </label>
                    <input type="text" id="score" name="score" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-gray-500 focus:outline-none" value="{{ old('score') }}">
                </div>
            </div>

            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="comment">
                        Comment
                    </label>
                    <textarea class="no-resize appearance-none block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 h-48 resize-none" id="comment" name="comment" placeholder="Please, tell us more..."></textarea>
                </div>
            </div>

            <div class="md:flex md:items-center mx-4">
                <div class="md:w-1/3 flex space-x-2 justify-center">
                    <a href="{{ url('surveys/' . $surveyId . '/ratings') }}">
                        <button type="button" class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out">Cancel</button>
                    </a>

                    <input type="submit" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out" value="Submit">

                </div>
                <div class="md:w-2/3"></div>
            </div>
        </form>

    </div>

@endsection
