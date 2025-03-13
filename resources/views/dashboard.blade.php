<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Integracion Agricompras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mx-auto p-6">
                        <h2 class="text-2xl font-bold mb-4">Listados</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tarjeta: Pedidos del mes -->
                            <div class="bg-white shadow-lg rounded-lg p-6">
                                <h3 class="text-lg font-semibold mb-4">Peticiones realizadas por mes</h3>
                                <div class="relative">
                                    <!-- Botón Izquierdo -->
                                    <button id="prev" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-200 p-2 rounded-full shadow-md hover:bg-gray-300">
                                        &#10094;
                                    </button>

                                    <div class="overflow-hidden w-full">
                                        <div id="slider" class="flex transition-transform duration-300">
                                            <!-- Meses y pedidos -->
                                            <table class="w-full border border-gray-300">
                                                <thead>
                                                <tr class="bg-gray-100">
                                                    <th class="border p-2">Mes</th>
                                                    <th class="border p-2">Peticiones</th>
                                                </tr>
                                                </thead>
                                                <tbody id="table-body">
                                                <!-- Datos insertados dinámicamente -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Botón Derecho -->
                                    <button id="next" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-200 p-2 rounded-full shadow-md hover:bg-gray-300">
                                        &#10095;
                                    </button>
                                </div>
                            </div>


                            <!-- Tarjeta: Pedidos recientes -->
                            <div class="bg-white shadow-lg rounded-lg p-6">
                                <h3 class="text-lg font-semibold">Peticiones más recientes</h3>
                                <ul class="mt-2">
                                    <li class="border-b py-2">Peticion #1023 - <span class="text-gray-600">5 de marzo</span></li>
                                    <li class="border-b py-2">Peticion #1022 - <span class="text-gray-600">3 de marzo</span></li>
                                    <li class="border-b py-2">Peticion #1021 - <span class="text-gray-600">1 de marzo</span></li>
                                    <li class="border-b py-2">Peticion #1020 - <span class="text-gray-600">27 de febrero</span></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Tabla de pedidos -->
                        <div class="bg-white shadow-lg rounded-lg mt-6 p-6">
                            <h3 class="text-lg font-semibold mb-4">Listado de Peticiones</h3>
                            <table class="w-full border-collapse border border-gray-300">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="border p-2">ID</th>
                                    <th class="border p-2">Cliente</th>
                                    <th class="border p-2">Fecha</th>
                                    <th class="border p-2">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="border p-2">1023</td>
                                    <td class="border p-2">Juan Pérez</td>
                                    <td class="border p-2">5 de marzo</td>
                                    <td class="border p-2">
                                        <a href="#" class="text-blue-500 hover:underline">Descargar</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border p-2">1022</td>
                                    <td class="border p-2">María López</td>
                                    <td class="border p-2">3 de marzo</td>
                                    <td class="border p-2">
                                        <a href="#" class="text-blue-500 hover:underline">Descargar</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border p-2">1021</td>
                                    <td class="border p-2">Carlos Gómez</td>
                                    <td class="border p-2">1 de marzo</td>
                                    <td class="border p-2">
                                        <a href="#" class="text-blue-500 hover:underline">Descargar</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const pedidosPorMes = [
        { mes: "Enero", cantidad: 40 },
        { mes: "Febrero", cantidad: 35 },
        { mes: "Marzo", cantidad: 50 },
        { mes: "Abril", cantidad: 42 },
        { mes: "Mayo", cantidad: 30 },
        { mes: "Junio", cantidad: 45 },
        { mes: "Julio", cantidad: 39 },
        { mes: "Agosto", cantidad: 41 },
        { mes: "Septiembre", cantidad: 48 },
        { mes: "Octubre", cantidad: 52 },
        { mes: "Noviembre", cantidad: 37 },
        { mes: "Diciembre", cantidad: 60 }
    ];

    let startIndex = 0;
    const visibleCount = 3;
    const tableBody = document.getElementById("table-body");

    function updateTable() {
        tableBody.innerHTML = "";
        for (let i = startIndex; i < startIndex + visibleCount; i++) {
            if (pedidosPorMes[i]) {
                const row = `<tr>
                    <td class="border p-2 text-center">${pedidosPorMes[i].mes}</td>
                    <td class="border p-2 text-center text-blue-600 font-bold">${pedidosPorMes[i].cantidad}</td>
                </tr>`;
                tableBody.innerHTML += row;
            }
        }
    }

    document.getElementById("prev").addEventListener("click", () => {
        if (startIndex > 0) {
            startIndex--;
            updateTable();
        }
    });

    document.getElementById("next").addEventListener("click", () => {
        if (startIndex + visibleCount < pedidosPorMes.length) {
            startIndex++;
            updateTable();
        }
    });

    updateTable();
</script>



