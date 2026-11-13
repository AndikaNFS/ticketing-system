<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Override;

class AssetTemplateSheet implements FromArray, WithHeadings, WithEvents, WithTitle
{
    /**
     * Create a new class instance.
     */
    protected array $inventoryRefs;
    protected array $assetRefs;

    public function __construct(array $inventoryRefs, array $assetRefs)
    {
        $this->inventoryRefs = array_values($inventoryRefs);
        $this->assetRefs = array_values($assetRefs);
    }

    public function title(): string
    {
        return 'Asset';
    }

    public function headings(): array
    {
        return [
            'Asset Ref',
            'Inventory Ref',
            'Serial Number',
            'Asset Number',
            'Status',
            'Placement',
            'Description',
            'Entry Date',
        ];
    }

    public function array(): array
    {
        $rows = [];

        for ($i = 0; $i < 100; $i++) {
            $rows[] = [
                $this->assetRefs[$i] ?? null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
            ];
        }

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->freezePane('A2');
                $sheet->getStyle('A1:H1')->getFont()->setBold(true);

                foreach (range('A', 'H') as $column) {
                    $sheet->getColumnDimension($column)
                        ->setAutoSize(true);           
                }

                $sheet->getStyle('H2:H101')
                    ->getNumberFormat()
                    ->setFormatCode('yyyy-mm-dd');
                
                
                $dropdowns = [
                    'B' => [
                        'formula' => '=InventoryRefList',
                        'blank' => true,
                        'errorTitle' => 'Inventory Ref tidak valid',
                        'error' => 'Silakan pilih Inventory Ref dari daftar.',
                    ],
                    'E' => [
                        'formula' => '=StatusList',
                        'blank' => false,
                        'errorTitle' => 'Status tidak valid',
                        'error' => 'Silakan pilih status dari daftar dropdown.',
                    ],
                ];

                foreach ($dropdowns as $column => $config) {
                    for ($row = 2; $row <= 101; $row++) {
                        $validation = $sheet
                            ->getCell($column . $row)
                            ->getDataValidation();

                        $validation->setType(
                            \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST
                        );

                        $validation->setErrorStyle(
                            \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP
                        );

                        $validation->setAllowBlank($config['blank']);

                        // false agar panah dropdown tidak disembunyikan.
                        $validation->setShowDropDown(true);

                        $validation->setShowErrorMessage(true);
                        $validation->setFormula1($config['formula']);
                        $validation->setErrorTitle($config['errorTitle']);
                        $validation->setError($config['error']);
                    }
                }
            },
        ];
    }
}
