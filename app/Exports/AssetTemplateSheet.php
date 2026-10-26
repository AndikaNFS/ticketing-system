<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Override;

class AssetTemplateSheet implements FromArray, WithHeadings, WithEvents
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
        return 'Asset';
    }

    public function headings(): array
    {
        return [
            'Inventory Ref',
            'Serial Number',
            'Asset Number',
            'Status',
            'Placement',
            'Entry Date',
        ];
    }

    public function array(): array
    {
        return array_fill(0, 500, array_fill(0, 6, null));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->freezePane('A2');
                $sheet->getStyle('A1:F1')->getFont()->setBold(true);

                foreach (range('A', 'F') as $column) {
                    $sheet->getColumnDimension($column)
                        ->setAutoSize(true);           
                }

                $sheet->getStyle('F2:F501')
                    ->getNumberFormat()
                    ->setFormatCode('yyyy-mm-dd');
                
                // for ($row = 2; $row <= 501; $row++) {
                //     $validation = $sheet
                //         ->getCell('D' . $row)
                //         ->getDataValidation();

                //     $validation->setType(
                //         \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST
                //     );
                //     $validation->setErrorStyle(
                //         \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP
                //     );
                //     $validation->setAllowBlank(false);
                //     $validation->setShowDropDown(true);
                //     $validation->setShowErrorMessage(true);
                //     $validation->setFormula1('=StatusList');
                //     $validation->setErrorTitle('Status tidak valid');
                //     $validation->setError(
                //         'Silakan pilih status dari daftar dropdown.'
                //     );
                // }

                $dropdowns = [
                    'A' => [
                        'formula' => '=InventoryRefList',
                        'blank' => true,
                        'errorTitle' => 'Inventory Ref tidak valid',
                        'error' => 'Silakan pilih Inventory Ref dari daftar.',
                    ],
                    'D' => [
                        'formula' => '=StatusList',
                        'blank' => false,
                        'errorTitle' => 'Status tidak valid',
                        'error' => 'Silakan pilih status dari daftar dropdown.',
                    ],
                ];

                foreach ($dropdowns as $column => $config) {
                    for ($row = 2; $row <= 501; $row++) {
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
                        $validation->setShowDropDown(false);

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
