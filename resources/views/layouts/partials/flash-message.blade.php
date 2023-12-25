@if (Session::has('success'))
    <div class="p-2 text-md text-center text-green-700 bg-green-100 border border-green-300 rounded-lg">
        {{ Session::get('success') }}
    </div>
@elseif (Session::has('error'))
    <div class="p-2 text-md text-center text-red-700 bg-red-100 border border-red-300 rounded-lg">
        {{ Session::get('error') }}
    </div>
@endif
