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

    <form method="POST" action="{{ route('analyze_link') }}">
        @csrf
        <div class="mb-4">
            {{--  <label for="url" class="block text-gray-700">Enter a URL:</label>  --}}
            <input type="url" hidden class="w-full rounded-lg mt-3" name="url" value="{{ env("APP_URL") }}" id="url" value="{{ old('url') }}"
                class="border border-gray-300 p-2 rounded-md">
        </div>
        <button type="submit" class="btn btn-success bg-green-300 border-2 p-2 rounded-md">Analyze
            Homepage Links</button>
    </form>

    <form method="POST" action="#">
        @csrf
        <div class="mb-4">
            {{--  <label for="url" class="block text-gray-700">Enter a URL:</label>  --}}
            <input type="url" hidden class="w-full rounded-lg mt-3" name="url" value="{{ env("APP_URL") }}" id="url" value="{{ old('url') }}"
                class="border border-gray-300 p-2 rounded-md">
        </div>
        <button type="submit" class="btn btn-info bg-red-300 border-2 p-2 rounded-md">Start hourly Crawling</button>
    </form>
</div>

