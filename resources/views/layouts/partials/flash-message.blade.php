@if (Session::has('success'))
    <div class="text-md text-center text-green-700 font-semibold">
        {{ Session::get('success') }}
    </div>
@elseif (Session::has('error'))
    <div class="text-md text-center text-red-700 font-semibold">
        {{ Session::get('error') }}
    </div>
@endif
