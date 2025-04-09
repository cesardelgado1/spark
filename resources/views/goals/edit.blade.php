<x-layout>
    <x-slot:heading>
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Editar Meta #{{ $goal->g_num }}
        </h1>
    </x-slot:heading>

    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form method="POST" action="{{ route('goals.update', $goal) }}">
        @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="g_num" class="block text-gray-700 font-bold">Número de la Meta</label>
                <input type="number" id="g_num" name="g_num" value="{{ $goal->g_num }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            @error('g_num')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror


            <div class="mb-4">
                <label for="g_text" class="block text-gray-700 font-bold">Texto de la Meta</label>
                <textarea id="g_text" name="g_text" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $goal->g_text }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('topics.goals', ['topic' => $goal->t_id]) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-layout>
