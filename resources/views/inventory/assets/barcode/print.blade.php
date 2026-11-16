
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Asset Barcode</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #111;
        }

        .settings {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
        }

        .settings form {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: end;
        }

        .settings label {
            display: block;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .settings input {
            width: 90px;
            padding: 7px;
        }

        button {
            padding: 8px 15px;
            cursor: pointer;
        }

        .labels {
            display: grid;
            grid-template-columns: repeat({{ $columns }}, {{ $width }}mm);
            gap: {{ $gap }}mm;
            justify-content: start;
        }

        .label {
            width: {{ $width }}mm;
            height: {{ $height }}mm;
            border: 1px dashed #bbb;
            padding: 2mm;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 2mm;
            /* justify-content: space-around; */
            overflow: hidden;
            /* text-align: center; */
            page-break-inside: avoid;
        }

        .qr-code {
            width: 28%;
            height: 100%;
            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-code svg {
            width: 100%;
            height: 100%;
            max-width: 100%;
            max-height: 100%;
        }

        .barcode {
             width: 100%;
            height: 9mm;
            display: flex;
            justify-content: center;
        }

        .barcode svg {
            width: 100%;
            height: 100%;
        }
        .asset-info {
            flex: 1;
            min-width: 0;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1.5mm;
        }

        .asset-number {
            font-size: 8pt;
            font-weight: bold;
            /* letter-spacing: 0.3px; */
            text-align: center;
            overflow-wrap: anywhere;
        }

        .device {
            font-size: 7pt;
            /* max-width: 100%; */
            font-weight: 500;
            text-align: center;
            overflow-wrap: anywhere;
        }

        @media print {
            body {
                margin: 0;
            }

            .settings {
                display: none;
            }

            .label {
                border: none;
            }
        }
    </style>
</head>

<body>

    <div class="settings">
        <h3>Asset Barcode Print Settings</h3>

        <form method="GET"
              action="{{ route('assets.barcode.print') }}">

            @foreach(request()->input('ids', []) as $id)
                <input type="hidden" name="ids[]" value="{{ $id }}">
            @endforeach

            <div>
                <label>Label Width (mm)</label>
                <input type="number" name="width"
                       value="{{ $width }}" min="20" max="200">
            </div>

            <div>
                <label>Label Height (mm)</label>
                <input type="number" name="height"
                       value="{{ $height }}" min="15" max="150">
            </div>

            <div>
                <label>Gap (mm)</label>
                <input type="number" name="gap"
                       value="{{ $gap }}" min="0" max="20">
            </div>

            <div>
                <label>Columns</label>
                <input type="number" name="columns"
                       value="{{ $columns }}" min="1" max="6">
            </div>

            <button type="submit">Apply Size</button>
            <button type="button" onclick="window.print()">
                Print Barcode
            </button>
        </form>
    </div>

    <div class="labels">
        @foreach($labels as $label)
            <div class="label">

                {{-- QR Code sebelah kiri --}}
                <div class="qr-code">
                    {!! $label['qrCode'] !!}
                </div>

                {{-- Informasi sebelah kanan --}}
                <div class="asset-info">

                    {{-- Barcode --}}
                    @if($label['barcode'])
                        <div class="barcode">
                            {!! $label['barcode'] !!}
                        </div>
                    @endif

                    {{-- Asset Number --}}
                    <div class="asset-number">
                        {{ $label['asset']->asset_number ?? 'No Asset Number' }}
                    </div>

                    {{-- Device --}}
                    <div class="device">
                        {{ $label['asset']->inventory->device ?? '-' }}
                    </div>

                </div>

            </div>
        @endforeach
    </div>

</body>
</html>
