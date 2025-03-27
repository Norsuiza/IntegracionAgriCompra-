<x-app-layout>

    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- jsGrid CSS (puedes mantenerlo si lo usas en otra parte) -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/jsgrid@1.5.3/dist/jsgrid.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/jsgrid@1.5.3/dist/jsgrid-theme.min.css">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
            {{ __('Integracion Agricompras') }}
        </h2>
    </x-slot>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-light shadow-sm rounded">
                    <div class="card-header text-center text-white" style="font-size: 23px; padding-top: 18px; background: #2a3749">
                        Administración de Usuarios
                    </div>
                    <div class="card-body" style="padding-bottom: 0;">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered shadow-sm">
                                        <thead style="background:#2a3749">
                                        <tr>
                                            <th style="color: #fdfdfe;">ID</th>
                                            <th style="color: #fdfdfe;">Nombre</th>
                                            <th style="color: #fdfdfe;">Email</th>
                                            <th style="color: #fdfdfe;">Compañía</th>
                                            <th style="color: #fdfdfe;">Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if($user->company_id)
                                                        @php
                                                            $company = $companies->firstWhere('id', $user->company_id);
                                                        @endphp
                                                        {{ $company ? $company->name : '' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Botón de Editar -->
                                                    <button class="btn btn-warning btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal"
                                                            data-id="{{ $user->id }}"
                                                            data-name="{{ $user->name }}"
                                                            data-company="{{ $user->company_id }}">
                                                        Editar
                                                    </button>
                                                    <!-- Botón de Eliminar -->
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
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
        </div>
    </div>

    <!-- Modal de Edición de Usuario -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-company" class="form-label">Compañía</label>
                            <select class="form-select" id="edit-company" name="company_id" required>
                                <option value="">Seleccione una compañía</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" style="background:#2a3749; color: whitesmoke" class="btn">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

    <!-- jQuery (para AJAX y manejo del DOM) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jsGrid JS (si se usa en otra parte) -->
    <script src="https://cdn.jsdelivr.net/npm/jsgrid@1.5.3/dist/jsgrid.min.js"></script>
    <!-- List.js -->
    <script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
    <!-- Popper y Bootstrap Bundle (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!-- Swiper Slider -->
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <!-- ApexCharts -->
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Dashboard Doctor Init -->
    <script src="{{ URL::asset('build/js/pages/dashboard-doctor.init.js') }}"></script>
    <!-- App.js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        // Al abrir el modal, se inyectan los datos correspondientes
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('id');
            var userName = button.data('name');
            var userCompany = button.data('company');
            var modal = $(this);
            modal.find('.modal-title').text('Editar Usuario: ' + userName);
            modal.find('#edit-name').val(userName);
            modal.find('#edit-company').val(userCompany);
            $('#editUserForm').attr('action', '/users/' + userId);
        });

        $('#editUserForm').on('submit', function (e) {
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
                    alert('Usuario actualizado con éxito.');
                    location.reload();
                },
                error: function (response) {
                    alert('Hubo un error al actualizar el usuario.');
                    console.log(data);
                }
            });
        });
    </script>
