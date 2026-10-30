<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryReferenceSheet implements
    FromArray,
    WithHeadings,
    WithTitle,
    WithEvents
{
    protected array $categories;
    protected array $outlets;
    protected array $refs;

    public function __construct(array $categories, array $outlets, array $refs)
    {
        $this->categories = array_values($categories);
        $this->outlets = array_values($outlets);
        $this->refs = array_values($refs);
    }

    public function title(): string
    {
        return 'Referensi';
    }

    public function headings(): array
    {
        return ['Category', 'Outlet', 'Tracked', 'Status', 'ImportRef'];
    }

    public function array(): array
    {
        $rows = [];
        $total = max(
            count($this->categories),
            count($this->outlets),
            count($this->refs),
            5
        );

        $trackedOptions = ['Yes', 'No'];

        $statusOptions = [
            'Available',
            'In Use',
            'Repair',
            'Lost',
            'Broken',
            'Disposed',
        ];

        for ($i = 0; $i < $total; $i++) {
            $rows[] = [
                $this->categories[$i] ?? null,
                $this->outlets[$i] ?? null,
                $trackedOptions[$i] ?? null,
                $statusOptions[$i] ?? null,
                $this->refs[$i] ?? null,
            ];
        }

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $spreadsheet = $sheet->getParent();

                $categoryEnd = max(2, count($this->categories) + 1);
                $outletEnd = max(2, count($this->outlets) + 1);

                $spreadsheet->addNamedRange(
                    new NamedRange(
                        'CategoryList',
                        $sheet,
                        '$A$2:$A$' . $categoryEnd
                    )
                );

                $spreadsheet->addNamedRange(
                    new NamedRange(
                        'OutletList',
                        $sheet,
                        '$B$2:$B$' . $outletEnd
                    )
                );

                $spreadsheet->addNamedRange(
                    new NamedRange(
                        'TrackedList',
                        $sheet,
                        '$C$2:$C$3'
                    )
                );

                $spreadsheet->addNamedRange(
                    new NamedRange(
                        'StatusList',
                        $sheet,
                        '$D$2:$D$6'
                    )
                );

                $spreadsheet->addNamedRange(
                    new NamedRange(
                        'InventoryRefList',
                        $sheet,
                        '$E$2:$E$' . (count($this->refs) + 1)
                    )
                );

            

                // $inventorySheet = $spreadsheet->getSheetByName('Inventory');
                // $assetSheet = $spreadsheet->getSheetByName('Asset');

                // if ($inventorySheet === null || $assetSheet === null) {
                //     throw new \RuntimeException(
                //         'Sheet Inventory atau Asset tidak ditemukan. Periksa nama dan urutan sheet pada InventoryTemplateExport.'
                //     );
                // }

                // $this->applyDropdown(
                //     $inventorySheet,
                //     'D',
                //     2,
                //     101,
                //     '=CategoryList',
                //     false
                // );

                // $this->applyDropdown(
                //     $inventorySheet,
                //     'E',
                //     2,
                //     101,
                //     '=OutletList',
                //     false
                // );

                // $this->applyDropdown(
                //     $inventorySheet,
                //     'F',
                //     2,
                //     101,
                //     '=OutletList',
                //     true
                // );

                // $this->applyDropdown(
                //     $inventorySheet,
                //     'G',
                //     2,
                //     101,
                //     '=TrackedList',
                //     false
                // );

                // $this->applyDropdown(
                //     $assetSheet,
                //     'C',
                //     2,
                //     501,
                //     '=StatusList',
                //     false
                // );

                $sheet->setSheetState(
                    Worksheet::SHEETSTATE_HIDDEN
                );
            },
        ];
    }

    // private function applyDropdown(
    //     Worksheet $sheet,
    //     string $column,
    //     int $startRow,
    //     int $endRow,
    //     string $formula,
    //     bool $allowBlank
    // ): void {
    //     for ($row = $startRow; $row <= $endRow; $row++) {
    //         $validation = $sheet
    //             ->getCell($column . $row)
    //             ->getDataValidation();

    //         $validation->setType(DataValidation::TYPE_LIST);
    //         $validation->setErrorStyle(
    //             DataValidation::STYLE_STOP
    //         );
    //         $validation->setAllowBlank($allowBlank);

    //         // Panah dropdown ditampilkan di Excel Desktop.
    //         $validation->setShowDropDown(true);

    //         $validation->setShowInputMessage(true);
    //         $validation->setShowErrorMessage(true);
    //         $validation->setFormula1($formula);

    //         $validation->setPromptTitle('Pilih dari daftar');
    //         $validation->setPrompt(
    //             'Silakan pilih nilai yang tersedia.'
    //         );

    //         $validation->setErrorTitle('Pilihan tidak valid');
    //         $validation->setError(
    //             'Gunakan nilai dari daftar dropdown.'
    //         );
    //     }
    // }
}