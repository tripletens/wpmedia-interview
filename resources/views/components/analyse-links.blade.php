<div class="p-6 mb-3 text-gray-900">
    @if ($errors->any())
        <div class="bg-red-100 mb-3 text-red-700 border border-red-400 p-2 mt-4 rounded-md">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 mb-3 text-green-700 border border-green-400 p-2 mt-4 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if (session('info'))
        <div class="bg-blue-100 mb-3 text-blue-700 border border-blue-400 p-2 mt-4 rounded-md">
            {{ session('info') }}
        </div>
    @endif


    <div class="mb-4">
        <form method="POST" action="{{ route('analyze_link') }}">
            @csrf
            <input type="url" hidden class="w-full rounded-lg mt-3" name="url" value="{{ env('APP_URL') }}"
                id="url" value="{{ old('url') }}" class="border border-gray-300 p-2 rounded-md">
            <button type="submit" class="btn btn-success bg-green-300 border-2 p-2 rounded-md">Analyze
                Homepage Links</button>
        </form>
    </div>


    {{--  over here is a post request   --}}
    <div class="mb-4">
        <form method="POST" action="{{ route('run_cron_job') }}">
            @csrf
            <button type="submit" class="btn btn-info bg-red-300 border-2 p-2 rounded-md">Start hourly
                Crawling</button>
        </form>
    </div>
</div>
