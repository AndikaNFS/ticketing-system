
<x-app-layout>
    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        Edit Repair
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Update repair information and status
                    </p>
                </div>

                <a href="{{ route('assets.repairs.show', $repair) }}"
                   class="px-4 py-2 text-sm text-white bg-gray-500 rounded-lg hover:bg-gray-600">
                    Back
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-5 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Asset Information --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">
                    Asset Information
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">
                            Device
                        </label>
                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $repair->asset->inventory->device ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">
                            Brand
                        </label>
                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $repair->asset->inventory->brand ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">
                            Serial Number
                        </label>
                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $repair->asset->serial_number ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">
                            Asset Number
                        </label>
                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $repair->asset->asset_number ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">
                            Outlet
                        </label>
                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $repair->outlet->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400">
                            Placement
                        </label>
                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                            {{ $repair->asset->placement ?? '-' }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- Edit Repair Form --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <div class="flex justify-between border-b-2 border-gray-500">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">
                        Repair Information
                    </h3>

                    <div class="">
                        @if ($repair->status === 'Repair')
                        <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                            Repair
                        </span>

                        @elseif ($repair->status === 'Completed')

                            <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                Completed
                            </span>

                        @else

                            <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                {{ $repair->status }}
                            </span>

                        @endif
                    </div>

                </div>

                <form action="{{ route('assets.repairs.update', $repair) }}"
                      method="POST"
                      class="space-y-5">

                    @csrf
                    @method('PUT')

                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Start Date
                            </p>

                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->repair_date?->format('d-m-Y H:i') ?? '-' }}
                            </p>
                        </div>


                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Completion Date
                            </p>

                            
                            <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $repair->completed_at?->format('d-m-Y H:i') ?? '-' }}
                            </p>

                        </div>
                        {{-- <div> --}}
                            @if ($repair->completed_at && $repair->repair_date)
                                @php
                                    $totalMinutes = $repair->repair_date->diffInMinutes($repair->completed_at);
                                    $days = intdiv($totalMinutes, 1440);
                                    $hours = intdiv($totalMinutes % 1440, 60);
                                    $minutes = $totalMinutes % 60;
                                @endphp
    
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Repair Duration
                                        </p>
    
                                        <p class="mt-1 font-medium text-gray-900 dark:text-white">
                                            @if ($days > 0)
                                                {{ $days }} day
                                            @endif
    
                                            @if ($hours > 0)
                                                {{ $hours }} hour
                                            @endif
    
                                            @if ($minutes > 0)
                                                {{ $minutes }} minute
                                            @endif
    
                                            @if ($days === 0 && $hours === 0 && $minutes === 0)
                                                Less than 1 minute
                                            @endif
                                        </p>
                                    </div>
    
                            @endif
                        {{-- </div> --}}

                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Technician --}}
                        <div>
                            <label for="technician"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Technician / Vendor
                            </label>

                            <input type="text"
                                   name="technician"
                                   id="technician"
                                   value="{{ old('technician', $repair->technician) }}"
                                   class="w-full rounded-lg text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>

                        {{-- Cost --}}
                        <div>
                            <label for="cost"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Cost (Rp)
                            </label>

                            <input type="number"
                                   name="cost"
                                   id="cost"
                                   min="0"
                                   step="1"
                                   value="{{ old('cost', $repair->cost) }}"
                                   class="w-full rounded-lg text-sm font-medium border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>

                        {{-- Address --}}
                        <div>
                            <label for="address"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Address
                            </label>

                            <input type="text"
                                   name="address"
                                   id="address"
                                   value="{{ old('address', $repair->address) }}"
                                   class="w-full rounded-lg text-sm font-medium border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </div>

                        {{-- Description --}}
                        <div class="md:col-span-2">
                            <label for="description"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Description
                            </label>

                            <textarea name="description"
                                      id="description"
                                      rows="4"
                                      class="w-full rounded-lg text-sm font-medium border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('description', $repair->description) }}</textarea>
                        </div>

                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">

                        <a href="{{ route('assets.repairs.show', $repair) }}"
                           class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">
                            Cancel
                        </a>

                        <button type="submit"
                                class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Update Repair
                        </button>

                    </div>

                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const status = document.getElementById('status');
            const completedDate = document.getElementById('completed_at');
            const completedWrapper = document.getElementById('completedDateWrapper');

            function toggleCompletedDate() {
                const isCompleted = status.value === 'Completed';

                completedWrapper.style.display = isCompleted ? 'block' : 'none';
                completedDate.required = isCompleted;

                if (!isCompleted) {
                    completedDate.value = '';
                }
            }

            status.addEventListener('change', toggleCompletedDate);
            toggleCompletedDate();
        });
    </script>

</x-app-layout>
