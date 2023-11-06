@if (Session::has('success'))
    <div class="p-2 text-md text-center text-green-700 bg-green-100 border border-green-300 rounded-lg">
        {{ Session::get('success') }}
    </div>
@endif
