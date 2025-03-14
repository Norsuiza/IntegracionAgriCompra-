<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-white leading-tight">
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
                                <tbody id="previous-requests">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <button id="prev" class="bg-gray-200 px-3 py-1 rounded">Anterior</button>
                        <button id="next" class="bg-gray-200 px-3 py-1 rounded">Siguiente</button>
                      </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
 async function fetchPedidos() {
  try {
    // CORREGIR : NO DETECTA LAS CREDENCIALES PARA LLAMAR LA API
    const username = '';
    const password = '';
    const credentials = btoa(`${username}:${password}`); // Codifica "usuario:contraseña" en base64

    // Realiza la petición a la API incluyendo el header Authorization
    const response = await fetch('http://localhost:3100/api/getAllOrders', {
      headers: {
        'Authorization': `Basic ${credentials}`,
        'Content-Type': 'application/json'
      }
    });

    const data = await response.json();

    // Procesamos el array para agrupar pedidos por mes usando la fecha_compra
    const pedidosPorMes = {};

    data.forEach(pedido => {
      // Se asume que 'pedido.fecha_compra' es una cadena de fecha (ISO o similar)
      const fecha = new Date(pedido.fecha_compra);
      // Obtén el nombre del mes; puedes ajustar la configuración regional si lo deseas
      const mes = fecha.toLocaleString('default', { month: 'long' });
      // Inicializar si no existe y sumar uno (o acumular otro valor, por ejemplo el total)
      if (!pedidosPorMes[mes]) {
        pedidosPorMes[mes] = 0;
      }
      pedidosPorMes[mes]++;
    });

    // Convertir el objeto a un array de objetos
    return Object.keys(pedidosPorMes).map(mes => ({
      mes: mes,
      cantidad: pedidosPorMes[mes]
    }));
  } catch (error) {
    console.error('Error al obtener los datos de la API:', error);
    return [];
  }
}


    let startIndex = 0;
    const visibleCount = 3;
    const tableBody = document.getElementById("previous-requests");
    let pedidosPorMesData = [];

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


    fetchPedidos().then(data => {
        pedidosPorMesData = data;
        updateTable();
    });
</script>



