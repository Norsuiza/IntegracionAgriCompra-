<x-app-layout>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-white">
                    <div class="container mx-auto p-6">

                        <h2 class="text-2xl font-semibold mb-4">Requests Agro</h2>

                        <div class="overflow-x-auto">
                            <table id="requestsTable" class="min-w-full border border-gray-300 dark:border-gray-600 rounded-lg shadow-md">
                                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white">
                                <tr>
                                    <th class="py-2 px-4 border">ID</th>
                                    <th class="py-2 px-4 border">Número de Órdenes</th>
                                    <th class="py-2 px-4 border">Fecha de Solicitud</th>
                                </tr>
                                </thead>
                                <tbody class="text-gray-900 dark:text-black">
                                @foreach($requestsAgro as $request)
                                    <tr class="bg-white dark:bg-gray-700 ">
                                        <td class="py-2 px-4 border text-center">{{ $request->id }}</td>
                                        <td class="py-2 px-4 border text-center">{{ $request->ordenes }}</td>
                                        <td class="py-2 px-4 border text-center">{{ \Carbon\Carbon::parse($request->request_date)->format('Y-m-d') }}</td>
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
                                    <tr class="bg-white dark:bg-gray-700">
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
    </body>

</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>

   $(document).ready(function()
   {
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
   });


</script>




