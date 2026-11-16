
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Asset Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #333;
        }

        h2 {
            margin-bottom: 5px;
        }

        .subtitle {
            margin-bottom: 15px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #e5e7eb;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .text-center {
            text-align: center;
        }
        .asset-image {
            width: 80px;
            height: 65px;
            object-fit: contain;
        }

        .image-cell {
            text-align: center;
            vertical-align: middle;
        }

        .no-image {
            color: #999;
            font-size: 8px;
        }
    </style>
</head>
<body>

    <h2>Asset Report</h2>

    <div class="subtitle">
        Outlet: {{ $outlet->name }} <br>
        Generated: {{ now()->format('d-m-Y H:i') }} <br>
        Total Assets: {{ $assets->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Asset Number</th>
                <th>Device</th>
                <th>Brand</th>
                <th>Type</th>
                <th>Image</th>
                <th>Image SN</th>
                <th>Serial Number</th>
                <th>Category</th>
                <th>Outlet</th>
                <th>Source Site</th>
                <th>Status</th>
                <th>Placement</th>
                <th>Entry Date</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($assets as $asset)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $asset->asset_number ?? '-' }}</td>
                    <td>{{ $asset->inventory?->device ?? '-' }}</td>
                    <td>{{ $asset->inventory?->brand ?? '-' }}</td>
                    <td>{{ $asset->inventory?->type ?? '-' }}</td>
                    <td class="image-cell">
                        @php
                            $physicalImage = $asset->images
                                ->where('image_type', 'physical')
                                ->first();  
                        @endphp

                        @if ($physicalImage && file_exists(public_path('storage/' . $physicalImage->image_path)))
                            <img src="{{ public_path('storage/' . $physicalImage->image_path) }}" class="asset-image" alt="">
                        
                        @else
                            <span class="no-image">No Image</span>
                        @endif
                    </td>
                    <td class="image-cell">
                        @php
                            $serialImage = $asset->images
                                ->where('image_type', 'serial_number')
                                ->first();
                        @endphp

                        @if ($serialImage && file_exists(public_path('storage/' . $serialImage->image_path)))
                            <img
                                src="{{ public_path('storage/' . $serialImage->image_path) }}"
                                class="asset-image"
                            >
                        @else
                            <span class="no-image">No Image</span>
                        @endif
                    </td>
                    <td>{{ $asset->serial_number ?? '-' }}</td>
                    <td>{{ $asset->inventory?->category?->name ?? '-' }}</td>
                    <td>{{ $asset->outlet?->name ?? '-' }}</td>
                    <td>{{ $asset->latestTransfer?->fromOutlet?->name ?? '-' }}</td>
                    <td>{{ $asset->status ?? '-' }}</td>
                    <td>{{ $asset->placement ?? '-' }}</td>
                    <td>
                        {{ $asset->entry_date?->format('d-m-Y') ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">
                        No asset data found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
