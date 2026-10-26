<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Override;

class InventoryTemplateSheet implements FromArray, WithHeadings, WithEvents
{
    /**
     * Create a new class instance.
     */
    protected array $refs;
    
    public function __construct(array $refs)
    {
        $this->refs = array_values($refs);
    }

    public function title(): string
    {
        return 'Inventory';
    }

    public function headings(): array
    {
        return [
            'Inventory Ref',
            'Device',
            'Brand',
            'Type',
            'Category',
            'Outlet',
            'Source Outlet',
            'Is Tracked',
            'Quantity',
            'Placement',
            'Entry Date',
            'Description',
        ];
    }

    public function array(): array
    {
        // return array_fill(0, 100, array_fill(0, 12, null));
        
        $rows = [];

         for ($i = 0; $i < 100; $i++) {
            $rows[] = [
                $this->refs[$i] ?? null, // Inventory Ref
                null,                    // Device
                null,                    // Brand
                null,                    // Type
                null,                    // Category
                null,                    // Outlet
                null,                    // Source Outlet
                null,                    // Is Tracked
                null,                    // Quantity
                null,                    // Placement
                null,                    // Entry Date
                null,                    // Description
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
                $sheet->getStyle('A1:L1')->getFont()->setBold(true);

                foreach (range('A', 'L') as $column) {
                    $sheet->getColumnDimension($column)
                        ->setAutoSize(true);
                }

                $sheet->getStyle('K2:K101')
                    ->getNumberFormat()
                    ->setFormatCode('yyyy-mm-dd');

                $dropdowns = [
                    'E' => ['formula' => '=CategoryList', 'blank' => false],
                    'F' => ['formula' => '=OutletList', 'blank' => false],
                    'G' => ['formula' => '=OutletList', 'blank' => true],
                    'H' => ['formula' => '=TrackedList', 'blank' => false],
                ];

                foreach ($dropdowns as $column => $config) {
                    for($row = 2; $row <= 101; $row++) {
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
                        $validation->setShowDropDown(true);
                        $validation->setShowErrorMessage(true);
                        $validation->setFormula1($config['formula']);
                        $validation->setErrorTitle('Pilihan tidak valid');
                        $validation->setError(
                            'Silakan pilih nilai dari daftar dropdown.'
                        );
                    }
                }
            },
        ];
    }
}
