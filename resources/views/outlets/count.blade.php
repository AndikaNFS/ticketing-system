                
<div class="relative p-4 w-full max-w-2xl max-h-full">

<!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Total IT Name Handle Area
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="flex justify-center p-4">
                    <div class="flex-wrap gap-5 justify-center items-end mb-6 mt-5">
                        
                        <div class=" relative overflow-x-auto overflow-y-auto w-full h-72">
                            
                                <table class="w-full h-28 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="uppercase sticky top-0 z-8"> 
                                        <tr class="bg-gray-100 dark:bg-gray-800">
                                            <th scope="col" class="px-6 py-3">Area</th>
                                            <th scope="col" class="px-6 py-3">IT Name</th>
                                            <th scope="col" class="px-6 py-3">Total Outlet</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($countOutlets as $count)
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $count->area}}</td>
                                            <td class="px-6 py-4 text-gray-900 dark:text-white">{{ $count->employee->name ?? 'Belum ada'}}</td>
                                            <td class="px-6 py-4 text-center text-gray-900 dark:text-white">{{ $count->total}}</td>
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>
                        </div>

                        <!-- <div class="flex items-center ">
                            <button data-modal-hide="add-modal" type="submit" class="text-white bg-blue-700 w-full hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div> -->
                    </div>

                </div>
            </div>



</div>                
                