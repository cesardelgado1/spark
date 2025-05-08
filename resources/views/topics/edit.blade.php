<x-layout>
    <x-slot:heading>
        Editar Asunto #{{ $topic->t_num }}
    </x-slot:heading>

    <div class="bg-white border border-gray-300 rounded-lg shadow-md px-6 py-4">
        <form method="POST" action="{{ route('topics.update', $topic->t_id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="t_num" class="block text-gray-700 font-bold">Número del Asunto</label>
                <input type="text" id="t_num" name="t_num" value="{{ $topic->t_num }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('t_num')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

            </div>

            <div class="mb-4">
                <label for="t_text" class="block text-gray-700 font-bold">Texto del Asunto</label>
                <textarea id="t_text" name="t_text" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ $topic->t_text }}</textarea>
                @error('t_text')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('topics.index', ['strategicplan' => $topic->sp_id]) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</x-layout>
