<x-app-layout>
    <!-- Enlaces a DataTables y Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('styles')
        <style>
            /* Agrega estilos personalizados aquí si es necesario */
        </style>
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
            {{ __('Integracion Agricompras') }}
        </h2>
    </x-slot>

    <body class="bg-white text-gray-900 dark:bg-gray-800 dark:text-white">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-300 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mx-auto p-6">
                        <h2 class="text-2xl font-semibold mb-4">Listado de Compañías</h2>
                        <div class="overflow-x-auto">
                            <button id="openModal" class="bg-green-300 text-black hover:bg-blue-500 font-bold py-2 px-4 rounded mb-4">
                                Nueva Compañía
                            </button>
                            <table id="companiesTable" class="min-w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-md">
                                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white">
                                <tr>
                                    <th class="py-2 px-4 border">ID</th>
                                    <th class="py-2 px-4 border">Nombre</th>
                                    <th class="py-2 px-4 border">Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-900 dark:text-black">
                                @foreach ($companies as $company)
                                    <tr class="bg-white dark:bg-gray-700">
                                        <td class="py-2 px-4 border text-center">{{ $company->id }}</td>
                                        <td class="py-2 px-4 border text-center">{{ $company->name }}</td>
                                        <td class="py-2 px-4 border text-center">
                                            <!-- Botón de Editar -->
                                            <button class="bg-blue-300 text-black hover:bg-blue-500 font-bold py-2 px-4 rounded openEditModal" type="button"
                                                    data-id="{{ $company->id }}"
                                                    data-name="{{ $company->name }}">
                                                Editar
                                            </button>
                                            <!-- Botón de Eliminar -->
                                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-orange-400 text-black hover:bg-red-500 font-bold py-2 px-4 rounded" type="submit"  onclick="return confirm('¿Estás seguro de eliminar esta compañía?')">
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
        </div>
    </div>

    <!-- Modal para crear compañía -->
    <div id="modalCompany" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2">
            <div class="flex justify-between items-center p-4 border-b">
                <h5 class="text-xl font-bold">Crear Nueva Compañía</h5>
                <button id="closeModal" class="text-gray-600 hover:text-gray-800 text-2xl">&times;</button>
            </div>
            <div class="p-4">
                <form id="createCompanyForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md" id="name" name="name" required>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Crear Compañía
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para editar compañía -->
    <div id="editModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2">
            <div class="flex justify-between items-center p-4 border-b">
                <h5 class="modal-title text-xl font-bold" id="editModalLabel">Editar Compañía</h5>
                <button type="button" id="closeEditModal" class="text-gray-600 hover:text-gray-800">&times;</button>
            </div>
            <div class="p-4">
                <form id="editCompanyForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit-name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" class="mt-1 block w-full border-gray-300 rounded-md" id="edit-name" name="name" required>
                    </div>
                    <!-- Puedes agregar más campos si lo necesitas, por ejemplo para la URL -->
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Guardar cambios
                    </button>
                </form>
            </div>
        </div>
    </div>

    </body>
</x-app-layout>

<!-- Scripts: jQuery, DataTables y Bootstrap Bundle -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        const modal = document.getElementById("modalCompany");
        const openModal = document.getElementById("openModal");
        const closeModal = document.getElementById("closeModal");

        openModal.addEventListener("click", function () {
            modal.classList.remove("hidden");
        });

        // Función para cerrar el modal
        closeModal.addEventListener("click", function () {
            modal.classList.add("hidden");
        });

        // Cerrar modal al hacer clic fuera de él
        modal.addEventListener("click", function (e) {
            if (e.target === modal) {
                modal.classList.add("hidden");
            }
        });



        // Inicializa DataTables para la tabla de compañías
        $('#companiesTable').DataTable({
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

        $(document).on('click', '.openEditModal', function() {
            var button = $(this);
            var companyId = button.data('id');
            var companyName = button.data('name');
            // Si necesitas la URL: var companyUrl = button.data('url');

            var modal = $('#editModal');
            modal.find('.modal-title').text('Editar Compañía: ' + companyName);
            modal.find('#edit-name').val(companyName);
            // Actualiza la acción del formulario para enviar la petición al endpoint correspondiente
            $('#editCompanyForm').attr('action', '/companies/' + companyId);

            // Muestra el modal quitando la clase 'hidden'
            modal.removeClass('hidden');
        });

        $('#closeEditModal').on('click', function() {
            $('#editModal').addClass('hidden');
        });

        // Envío del formulario vía AJAX para editar compañía
        $('#editCompanyForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var actionUrl = form.attr('action');
            var formData = form.serialize();

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#editModal').modal('hide');
                    alert('Compañía actualizada con éxito.');
                    location.reload();
                },
                error: function (response) {
                    alert('Hubo un error al actualizar la compañía.');
                }
            });
        });

        document.getElementById("createCompanyForm").addEventListener("submit", function (e) {
            e.preventDefault();

            let formData = {
                name: document.getElementById("name").value,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            };

            fetch("{{ route('companies.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": formData._token
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    alert("Compañía creada exitosamente");
                    modal.classList.add("hidden"); // Cierra el modal
                    location.reload(); // Recarga la página
                })
                .catch(error => {
                    alert("Ocurrió un error al crear la compañía.");
                    console.error(error);
                });
        });

    });
</script>
