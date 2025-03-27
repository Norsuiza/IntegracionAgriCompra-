<x-app-layout>
    <!-- Enlace a DataTables y meta CSRF -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
            {{ __('Integracion Agricompras') }}
        </h2>
    </x-slot>

    <!-- Contenedor principal -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-300 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4 text-center">Administración de Usuarios</h2>
                <div class="overflow-x-auto">
                    <table id="usersTable" class="min-w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-md">
                        <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white">
                        <tr>
                            <th class="py-2 px-4 border">ID</th>
                            <th class="py-2 px-4 border">Nombre</th>
                            <th class="py-2 px-4 border">Email</th>
                            <th class="py-2 px-4 border">Compañía</th>
                            <th class="py-2 px-4 border">Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-900 dark:text-black">
                        @foreach ($users as $user)
                            <tr class="bg-white dark:bg-gray-700">
                                <td class="py-2 px-4 border text-center">{{ $user->id }}</td>
                                <td class="py-2 px-4 border text-center">{{ $user->name }}</td>
                                <td class="py-2 px-4 border text-center">{{ $user->email }}</td>
                                <td class="py-2 px-4 border text-center">
                                    @if($user->company_id)
                                        @php
                                            $company = $companies->firstWhere('id', $user->company_id);
                                        @endphp
                                        {{ $company ? $company->name : '' }}
                                    @endif
                                </td>
                                <td class="py-2 px-4 border text-center">
                                    <!-- Botón de Editar -->
                                    <button class="bg-blue-300 text-black hover:bg-blue-500 font-bold py-2 px-4 rounded openEditUserModal"
                                            type="button"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-company="{{ $user->company_id }}">
                                        Editar
                                    </button>
                                    <!-- Botón de Eliminar -->
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-orange-400 text-black hover:bg-red-500 font-bold py-2 px-4 rounded" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edición de Usuario (con Tailwind) -->
    <div id="editUserModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2">
            <div class="flex justify-between items-center p-4 border-b">
                <h5 class="modal-title text-xl font-bold" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" id="closeEditUserModal" class="text-gray-600 hover:text-gray-800">&times;</button>
            </div>
            <div class="p-4">
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit-user-company" class="block text-sm font-medium text-gray-700">Compañía</label>
                        <input id="edit-user-name" name="name" type="text">
                        <select class="mt-1 block w-full border-gray-300 rounded-md" id="edit-user-company" name="company_id" required>
                            <option value="">Seleccione una compañía</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Guardar cambios
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>

<!-- Scripts: jQuery y DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            ordering: true,
            paging: true,
            searching: true,
            language: {
                processing:     "Procesando...",
                search:         "Buscar:",
                lengthMenu:     "Mostrar _MENU_ registros",
                info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered:   "(filtrado de un total de _MAX_ registros)",
                infoPostFix:    "",
                loadingRecords: "Cargando...",
                zeroRecords:    "No se encontraron resultados",
                emptyTable:     "Ningún dato disponible en esta tabla",
                paginate: {
                    first:      "Primero",
                    previous:   "Anterior",
                    next:       "Siguiente",
                    last:       "Último"
                },
                aria: {
                    sortAscending:  ": Activar para ordenar la columna de manera ascendente",
                    sortDescending: ": Activar para ordenar la columna de manera descendente"
                }
            },
            initComplete: function() {
                $('.dataTables_length select').css({
                    'width': 'auto',
                    'min-width': '60px',
                    'padding': '5px'
                });
            }
        });

        // Abrir modal de edición de usuario
        $(document).on('click', '.openEditUserModal', function() {
            var button = $(this);
            var userId = button.data('id');
            var userName = button.data('name');
            var userCompany = button.data('company');

            var modal = $('#editUserModal');
            modal.find('.modal-title').text('Editar Usuario: ' + userName);
            modal.find('#edit-user-name').val(userName);
            modal.find('#edit-user-company').val(userCompany);
            $('#editUserForm').attr('action', '/users/' + userId);
            modal.removeClass('hidden');
        });

        // Cerrar modal de edición
        $('#closeEditUserModal').on('click', function() {
            $('#editUserModal').addClass('hidden');
        });

        // Envío del formulario de edición vía AJAX
        $('#editUserForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var actionUrl = form.attr('action');
            var formData = form.serialize();

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert('Usuario actualizado con éxito.');
                    location.reload();
                },
                error: function(response) {
                    console.log(formData)
                    alert('Hubo un error al actualizar el usuario.');
                    console.log(this.error)
                }
            });
        });
    });
</script>
