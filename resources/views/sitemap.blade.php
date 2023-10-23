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
                    {{ __('Welcome Admin!') }} <a href="{{route('dashboard')}}">
                        <button class="btn btn-info bg-blue-300 border-2 p-2 rounded-md">
                            Crawl Homepage </button> </a>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">

                @foreach ($results as $result)
                    <li><a href="{{ $result }}">{{ $result }}</a></li>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
