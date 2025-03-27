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
                            <table id="companiesTable" class="min-w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-md">
                                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white">
                                <tr>
                                    <th class="py-2 px-4 border">ID</th>
                                    <th class="py-2 px-4 border">Nombre</th>
                                    <th class="py-2 px-4 border">URL</th>
                                    <th class="py-2 px-4 border">
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createCompanyModal">
                                            Nueva Compañía
                                        </button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-900 dark:text-black">
                                @foreach ($companies as $company)
                                    <tr class="bg-white dark:bg-gray-700">
                                        <td class="py-2 px-4 border text-center">{{ $company->id }}</td>
                                        <td class="py-2 px-4 border text-center">{{ $company->name }}</td>
                                        <td class="py-2 px-4 border text-center">
                                            <a target="_blank" href="{{ $company->url }}">Ver enlace</a>
                                        </td>
                                        <td class="py-2 px-4 border text-center">
                                            <!-- Botón de Editar -->
                                            <button class="btn btn-warning btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editModal"
                                                    data-id="{{ $company->id }}"
                                                    data-name="{{ $company->name }}"
                                                    data-url="{{ $company->url }}">
                                                Editar
                                            </button>
                                            <!-- Botón de Eliminar -->
                                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta compañía?')">
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
    <div id="modalCompany" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCompanyModalLabel">Crear Nueva Compañía</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createCompanyForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="url" class="form-label">URL</label>
                            <input type="url" class="form-control" id="url" name="url" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Compañía</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar compañía -->
    <div id="modalUser" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Compañía</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCompanyForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-url" class="form-label">URL</label>
                            <input type="url" class="form-control" id="edit-url" name="url" required>
                        </div>
                        <button type="submit" class="btn" style="background:#2a3749; color: whitesmoke">
                            Guardar cambios
                        </button>
                    </form>
                </div>
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
        // Inicializa DataTables para la tabla de compañías
        $('#companiesTable').DataTable({
            ordering: true,
            paging: true,
            searching: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json'
            }
        });

        // Inyección de datos en el modal de edición
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var companyId = button.data('id');
            var companyName = button.data('name');
            var companyUrl = button.data('url');
            var modal = $(this);
            modal.find('.modal-title').text('Editar Compañía: ' + companyName);
            modal.find('#edit-name').val(companyName);
            modal.find('#edit-url').val(companyUrl);
            $('#editCompanyForm').attr('action', '/companies/' + companyId);
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

        // Envío del formulario vía AJAX para crear compañía
        $('#createCompanyForm').submit(function(e) {
            e.preventDefault();

            let formData = {
                name: $('#name').val(),
                url: $('#url').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "{{ route('companies.store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    alert("Compañía creada exitosamente");
                    $('#createCompanyModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    if (errors) {
                        Object.keys(errors).forEach(function(key) {
                            errorMessages += errors[key][0] + "\n";
                        });
                        alert("Errores:\n" + errorMessages);
                    } else {
                        alert("Ocurrió un error inesperado.");
                    }
                }
            });
        });
    });
</script>
