@props(['active' => false])

<a {{ $attributes->merge(['class' => ($active ? 'bg-gray-700 text-white' : 'text-gray-100 hover:bg-gray-700') . ' flex items-center px-4 py-2 mt-2 transition duration-150 ease-in-out rounded-md'
])}}>
    {{ $slot }}
</a>
