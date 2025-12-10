<x-dashboard-layout>
    
<div class="min-h-full">
    @include('components.guest.navbar')
    <div class="p-6 mt-10 bg-gray-400 rounded-xl">
    
        <h1 class="text-center text-xl font-bold mb-6">
            LEADERS AREA NOVEMBER 2025 THE RR CHOCOLATE
        </h1>
    
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-400 text-sm">
    
                {{-- Header --}}
                <thead>
                    <tr class="bg-green-500 text-black font-bold text-center">
                        <th class="border border-gray-500 px-2 py-2 w-10">NO</th>
                        <th class="border border-gray-500 px-2 py-2 w-48">OPERATIONS MANAGER</th>
                        <th class="border border-gray-500 px-2 py-2">OUTLET</th>
                    </tr>
                </thead>
    
                <tbody>
    
                    @php
                        $leaders = [
                            [
                                'no' => 1,
                                'manager' => 'Lila Handayani',
                                'outlets' => [
                                    'Sudirman', 'Lotte Avenue', 'Plaza Indonesia',
                                    'Senopati', 'Plaza Senayan', 'Pacific Place'
                                ]
                            ],
                            [
                                'no' => 2,
                                'manager' => 'Nanda Adi S',
                                'outlets' => [
                                    'MOI', 'Gafoy', 'AEON Deltamas', 'Taman Anggrek',
                                    'AEON JGC', 'SMB'
                                ]
                            ],
                            [
                                'no' => 3,
                                'manager' => 'Syaiful Bakhri',
                                'outlets' => [
                                    'AEON Sentul','Puri Indah Mall 2','SMS',
                                    'AEON BSD','Bintaro Xchange 2'
                                ]
                            ],
                            [
                                'no' => 4,
                                'manager' => 'Vacant',
                                'outlets' => [
                                    'PIK','Citos','Gancit','T3 Domestic - International',
                                    'Kualanamu'
                                ]
                            ],
                            [
                                'no' => 5,
                                'manager' => 'Vivianti Citra',
                                'outlets' => [
                                    'IGN','Kuta Beachwalk','Icon Mall Bali','Ubud',
                                    'Pakuwon Mall Surabaya','Pakuwon City Mall Surabaya',
                                    'Galaxy Mall Surabaya'
                                ]
                            ],
                        ];
                    @endphp
    
                    {{-- Loop Data --}}
                    @foreach ($leaders as $leader)
                    <tr>
    
                        {{-- Kolom NO --}}
                        <td class="border border-gray-500 text-center align-top px-2 py-2"
                            rowspan="{{ count($leader['outlets']) }}">
                            {{ $leader['no'] }}
                        </td>
    
                        {{-- Kolom Manager --}}
                        <td class="border border-gray-500 text-center content-center align-top px-2 py-2"
                            rowspan="{{ count($leader['outlets']) }}">
                            {{ $leader['manager'] }}
                        </td>
    
                        {{-- Kolom Outlet (baris pertama) --}}
                        <td class="border border-gray-500 px-2 py-2">
                            {{ $leader['outlets'][0] }}
                        </td>
                    </tr>
    
                    {{-- Sisa outlet --}}
                    @foreach (array_slice($leader['outlets'], 1) as $outlet)
                    <tr>
                        <td class="border border-gray-500 px-2 py-1">
                            {{ $outlet }}
                        </td>
                    </tr>
                    @endforeach
    
                    @endforeach
    
                </tbody>
    
            </table>
        </div>
    
    </div>

</div>

</x-dashboard-layout>