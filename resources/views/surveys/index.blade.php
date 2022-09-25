@extends('layout')

@section('body')
    <h1 class="text-xl font-bold">Surveys list</h1>

    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full">
                        <thead class="border-b">
                        <tr>
                            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">ID</th>
                            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Name</th>
                            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Metric</th>
                            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">Question</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($surveys as $survey)
                            <tr class="border-b">
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    <a href="{{url('surveys/' . $survey['id'] . '/ratings')}}" >
                                        <span class="underline text-blue-700 hover:text-blue-500">{{$survey['id']}}</span>
                                    </a>
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{$survey['name']}}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{$survey['metric']}}</td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{$survey['question']}}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
