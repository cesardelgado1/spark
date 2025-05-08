 resources/views/errors/500.blade.php
<x-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
        <h1 class="text-5xl font-bold text-red-600">500</h1>
        <p class="mt-4 text-xl text-gray-700">Oops! Something went wrong on our end.</p>
        <p class="mt-2 text-sm text-gray-500">Please report this error to the SPARK development team.</p>
        <a href="{{ url('/') }}" class="mt-6 text-blue-600 underline">Return to Home</a>
    </div>
</x-layout>
