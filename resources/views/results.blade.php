<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sitemap Links') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('Welcome Admin!') }} <a href="{{ route('dashboard') }}">
                        <button class="btn btn-info bg-blue-300 border-2 p-2 rounded-md">
                            Crawl Homepage </button> </a>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="p-6 text-3xl my-3">Here is the list of the last saved Crawled URLs: </h2>

                @if(count($results) > 0)
                @foreach ($results as $result)
                    <li><a href="{{ $result->url }}">{{ $result->url }}</a></li>
                @endforeach
                @else
                    <span class="p-6 m-6 bg-color-300 text-blue-600 border-blue-600 border-2 rounded-lg"> No Site map url available at the moment. Kindly start an analysis <a href="{{ route('dashboard') }}" class="font-bold cursor-pointer">here</a> </span>
                @endif
            </div>
            <br/>
        </div>
    </div>
</x-app-layout>
