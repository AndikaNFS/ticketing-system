<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class AssetMovementTemplateSheet implements
    FromArray,
    WithHeadings,
    WithEvents,
    WithTitle
{
    protected array $assetRefs;

    public function __construct(array $assetRefs)
    {
        $this->assetRefs = $assetRefs;
    }

    public function title(): string
    {
        return 'Asset Movement';
    }

    public function headings(): array
    {
        return [
            'Asset Ref',
            'From Outlet',
            'To Outlet',
            'Transfer Date',
            'Description',
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
            ];
        }

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle('A1:E1')->getFont()->setBold(true);

                foreach (range('A', 'E') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                $sheet->getStyle('D2:D501')
                    ->getNumberFormat()
                    ->setFormatCode('dd-mm-yyyy');

                // From Outlet
                $this->addDropdown($sheet, 'B', '=OutletList');

                // To Outlet
                $this->addDropdown($sheet, 'C', '=OutletList');
            },
        ];
    }

    private function addDropdown(
        $sheet,
        string $column,
        string $formula
    ): void {
        for ($row = 2; $row <= 101; $row++) {
            $validation = $sheet->getCell("{$column}{$row}")
                ->getDataValidation();

            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_STOP);
            $validation->setAllowBlank(true);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(false);
            $validation->setFormula1($formula);
        }
    }
}