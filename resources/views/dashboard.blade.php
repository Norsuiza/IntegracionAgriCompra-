<x-app-layout>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

@section('styles')
        <style>

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

                        <h2 class="text-2xl font-semibold mb-4">Peticiones Agro</h2>

                        <div class="overflow-x-auto">
                            <table id="requestsTable" class="min-w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-md">
                                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white">
                                <tr>
                                    <th class="py-2 px-4 border">ID</th>
                                    <th class="py-2 px-4 border">Número de Órdenes</th>
                                    <th class="py-2 px-4 border">Fecha de Solicitud</th>
                                    <th class="py-2 px-4 border">Estado</th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-900 dark:text-black">
                                @foreach($requestsAgro as $request)
                                    <tr class="bg-white dark:bg-gray-700 clickable-row" data-id="{{ $request->id }}">
                                        <td class="py-2 px-4 border text-center">{{ $request->id }}</td>
                                        <td class="py-2 px-4 border text-center">{{ $request->ordenes }}</td>
                                        <td class="py-2 px-4 border text-center">{{ \Carbon\Carbon::parse($request->request_date)->format('Y-m-d') }}</td>
                                        <td class="py-2 px-4 border text-center">                  
                                        <button onclick="reactivateRequest(event, {{ $request->id }})" class="bg-blue-500 text-white hover:bg-yellow-600 font-bold py-2 px-4 rounded">Encender</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr class="my-6 border-t-2 border-gray-300 dark:border-gray-600">

                        <h2 class="text-2xl font-bold mb-4">Ordenes de Compras</h2>
                        <div class="overflow-x-auto">
                            <table id="ordersTable" class="min-w-full border border-gray-300 dark:border-gray-600 dark:bg-[#0a0a0a] rounded-lg shadow-md">
                                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white">
                                <tr>
                                    <th class="py-2 px-4 border">Orden Compra</th>
                                    <th class="py-2 px-4 border">Días Crédito</th>
                                    <th class="py-2 px-4 border">Fecha Compra</th>
                                    <th class="py-2 px-4 border">Total General</th>
                                    <th class="py-2 px-4 border">Sucursal</th>
                                    <th class="py-2 px-4 border">Proveedor</th>
                                    <th class="py-2 px-4 border">RFC Proveedor</th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-900 dark:text-black">
                                @foreach($orders as $order)
                                    <tr class="bg-white dark:bg-gray-700 clickable-order-row" data-id="{{ $order->id }}">
                                    <td class="py-2 px-4 border text-center">{{ $order->orden_compra }}</td>
                                        <td class="py-2 px-4 border text-center">{{ $order->dias_credito }}</td>
                                        <td class="py-2 px-4 border text-center">{{ \Carbon\Carbon::parse($order->fecha_compra)->format('Y-m-d') }}</td>
                                        <td class="py-2 px-4 border text-center">${{ number_format($order->total_general, 2) }}</td>
                                        <td class="py-2 px-4 border">{{ $order->sucursal_nombre }}</td>
                                        <td class="py-2 px-4 border">{{ $order->proveedor_nombre }}</td>
                                        <td class="py-2 px-4 border">{{ $order->proveedor_rfc }}</td>
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

    <!-- Modals -->
    <div id="requestDetailsModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-3/4 max-w-lg">
            <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Detalles de la Petición</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-md">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white">
                    <tr>
                        <th class="py-2 px-4 border">ID Orden</th>
                    </tr>
                    </thead>
                    <tbody id="modalRequestDetails" class="text-gray-900 dark:text-white">
                    <!-- Los detalles se llenarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>

            <button onclick="closeModal()" class="mt-4 px-4 py-2 bg-red-500 text-white rounded">Cerrar</button>
        </div>
    </div>

    <div id="orderDetailsModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-3/4">
            <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Detalles de la Orden</h2>
            <table class="min-w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-md">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white">
                <tr>
                    <th class="py-2 px-4 border">Artículo</th>
                    <th class="py-2 px-4 border">Cantidad</th>
                    <th class="py-2 px-4 border">Precio</th>
                    <th class="py-2 px-4 border">Subtotal</th>
                </tr>
                </thead>
                <tbody id="modalOrderDetails" class="text-gray-900 dark:text-white">
                <!-- Aquí se insertarán los detalles dinámicamente -->
                </tbody>
            </table>
            <button id="closeOrderModal" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Cerrar</button>
        </div>
    </div>


    </body>

</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>

    function loadPendingOrders(){
        $.ajax({
            url: '/orders/getPendingOrders',
            type: "GET",
            success: function (response){
                console.log(response);
            },
            error: function(){
                alert("ta mal");
            }
        });
    }

    function reactivateRequest(e, requestId){
       e.preventDefault();
        $.ajax({
           url: `/requests/${requestId}/reactivate`, 
           type: "PUT",
           data: {
             _token: '{{ csrf_token() }}'
            },
           success: function(response) {
                alert(response);
           },
           error: function() {
               alert("Error al obtener los detalles.");
           }
       });
    }

   $(document).ready(function()
   {
            loadPendingOrders();

           let orders = @json($orders);
           let requestsAgro = @json($requestsAgro);

           console.log("Orders:", orders);
           console.log("Requests Agro:", requestsAgro);

           console.log('Listo');

               $('#ordersTable').DataTable({
                   "ordering": true,
                   "paging": true,
                   "searching": true,
                   "language": {
                       "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
                   }
               });

               $('#requestsTable').DataTable({
                   "ordering": true,
                   "paging": true,
                   "searching": true,
                   "language": {
                       "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
                   }
               });

       $(".clickable-row").on("click", function() {
           let requestId = $(this).data("id"); // Obtener el ID de la petición
           loadRequestDetails(requestId);
       });
   });

   //Funciones Para el Modal de Requests

   function loadRequestDetails(requestId) {
       // Realizar la petición AJAX
       $.ajax({
           url: `/requests/${requestId}/details`,  // Ruta para obtener detalles
           type: "GET",
           success: function(response) {
               let detailsHtml = "";
               response.forEach(detail => {
                   detailsHtml += `
                    <tr>
                        <td class="py-2 px-4 border text-center">${detail.order_id}</td>
                    </tr>`;
               });

               $("#modalRequestDetails").html(detailsHtml);
               openModal(); // Abre el modal
           },
           error: function() {
               alert("Error al obtener los detalles.");
           }
       });
   }

   // Función para abrir el modal
   function openModal() {
       document.getElementById("requestDetailsModal").classList.remove("hidden");
   }

   // Función para cerrar el modal
   function closeModal() {
       document.getElementById("requestDetailsModal").classList.add("hidden");
   }

   //Funciones para el modal de Ordenes de Compras

   $(document).ready(function() {
       $(document).on("click", ".clickable-order-row", function() {
           let orderId = $(this).data("id");
           console.log("Orden clickeada, ID:", orderId);

           $.ajax({
               url: `/orders/${orderId}/details`,
               type: "GET",
               success: function(response) {
                   console.log("Detalles recibidos:", response);

                   if (response.length === 0) {
                       $("#modalOrderDetails").html("<tr><td colspan='4' class='text-center py-2 px-4 border'>No hay detalles</td></tr>");
                   } else {
                       let detailsHtml = "";
                       response.forEach(detail => {
                           detailsHtml += `<tr>
                            <td class="py-2 px-4 border text-center">${detail.articulo_nombre}</td>
                            <td class="py-2 px-4 border text-center">${detail.cantidad}</td>
                            <td class="py-2 px-4 border text-center">${detail.precio}</td>
                            <td class="py-2 px-4 border text-center">${detail.subtotal}</td>
                        </tr>`;
                       });

                       $("#modalOrderDetails").html(detailsHtml);
                   }

                   $("#orderDetailsModal").removeClass("hidden");
               },
               error: function(xhr, status, error) {
                   console.error("Error en AJAX:", error);
                   alert("Error al obtener los detalles.");
               }
           });
       });

       // Cerrar el modal
       $("#closeOrderModal").on("click", function() {
           $("#orderDetailsModal").addClass("hidden");
       });
   });



</script>




