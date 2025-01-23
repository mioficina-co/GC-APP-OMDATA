<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Lista de Visitantes</h2>
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Nombre</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Apellido</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Documento</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Teléfono</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Género</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Placa Vehículo</th>
                        <th class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($visitantes as $visitante)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $visitante->id }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $visitante->nombre }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $visitante->apellido }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $visitante->numero_documento }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $visitante->telefono }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $visitante->email }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $visitante->genero }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">{{ $visitante->placa_vehiculo }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-sm text-gray-600">
                            <div class="flex space-x-2">
                                <button class="text-blue-500 hover:underline" wire:click="editar({{ $visitante->id }})">Editar</button>
                                <button class="text-red-500 hover:underline" wire:click="eliminar({{ $visitante->id }})">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="mt-4">
            {{ $visitantes->links() }}
        </div> --}}
    </div>
</div>
