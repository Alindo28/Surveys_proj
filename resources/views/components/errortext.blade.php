@if ($errors->any())
    <ul class="flex flex-col gap-1 p-2 text-red-800 text-sm">
        @foreach ($errors->all() as $error)
            <li>• {{ $error }}</li>
        @endforeach
    </ul>
@endif
