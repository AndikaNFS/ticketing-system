<?php

namespace App\Exports;

use Dflydev\DotAccessData\Data;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\NamedRange;
use Illuminate\Support\Str;

// class InventoryTemplateExport implements FromArray, WithHeadings, WithEvents
class InventoryTemplateExport implements WithMultipleSheets
{
    protected array $categories;
    protected array $outlets;
    protected array $refs;
    /**
     * Create a new class instance.
     */
    public function __construct(array $categories, array $outlets)
    {
        $this->categories = $categories;
        $this->outlets = $outlets;

        $prefix = 'INV-' . Str::upper(Str::random(8));

        $this->refs= [];

        for ($i = 1; $i <= 100; $i++) {
            $this->refs[] = sprintf('%s-%03d', $prefix, $i);
        }
    }

    public function sheets(): array
    {
        return [
            new InventoryTemplateSheet($this->refs),
            new AssetTemplateSheet($this->refs),
            new InventoryReferenceSheet(
                $this->categories,
                $this->outlets,
                $this->refs
            ),
        ];
    }

    // public function headings(): array
    // {
    //     return [
    //         'Device',
    //         'Brand',
    //         'Serial Number',
    //         'Category',
    //         'Outlet',
    //         'Source Outlet',
    //         'Is Tracked',
    //         'Quantity',
    //         'Placement',
    //         'Entry Date',
    //         'Description',
    //     ];
    // }

    // public function array(): array
    // {
    //     return array_fill(0, 101, array_fill(0, 1, null));
    // }


    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             $sheet = $event->sheet->getDelegate();
    //             $spreadsheet = $sheet->getParent();

    //             // Buat sheet referensi untuk sumber dropdown.
    //             $refSheet = $spreadsheet->createSheet();
    //             $refSheet->setTitle('Referensi');

    //             $refSheet->setCellValue('A1', 'Category');
    //             $refSheet->setCellValue('B1', 'Outlet');
    //             $refSheet->setCellValue('C1', 'Tracked');

    //             foreach ($this->categories as $i => $category) {
    //                 $refSheet->setCellValue('A' . ($i + 2), $category);
    //             }

    //             foreach ($this->outlets as $i => $outlet) {
    //                 $refSheet->setCellValue('B' . ($i + 2), $outlet);
    //             }

    //             $refSheet->setCellValue('C2', 'Yes');
    //             $refSheet->setCellValue('C3', 'No');

    //             // Named ranges digunakan oleh dropdown Excel.
    //             $spreadsheet->addNamedRange(new NamedRange(
    //                 'CategoryList',
    //                 $refSheet,
    //                 '$A$2:$A$' . (count($this->categories) + 1)
    //             ));

    //             $spreadsheet->addNamedRange(new NamedRange(
    //                 'OutletList',
    //                 $refSheet,
    //                 '$B$2:$B$' . (count($this->outlets) + 1)
    //             ));

    //             $spreadsheet->addNamedRange(new NamedRange(
    //                 'TrackedList',
    //                 $refSheet,
    //                 '$C$2:$C$3'
    //             ));

    //             // Sembunyikan sheet referensi
    //             $refSheet->setSheetState(
    //                 \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN
    //             );

    //             // Terapkan dropdown pada baris 2 sampai 101.
    //             // $dropdowns = [
    //             //     // 'C' => '=CategoryList',
    //             //     // 'D' => '=OutletList',
    //             //     // 'E' => '=OutletList',
    //             //     // 'F' => '=TrackedList',


    //             //     'C' => [
    //             //         'formula' => '=CategoryList',
    //             //         'title' => 'Pilih Category',
    //             //         'prompt' => 'Silahkan pilih kategori perangkat',
    //             //         'allowBlank' => false,
    //             //     ],
    //             //     'D' => [
    //             //         'formula' => '=OutletList',
    //             //         'title' => 'Pilih Outlet',
    //             //         'prompt' => 'Silahkan pilih outlet lokasi aset',
    //             //         'allowBlank' => false,
    //             //     ],
    //             //     'E' => [
    //             //         'formula' => '=TrackedList',
    //             //         'title' => 'Pilih Yes/No',
    //             //         'prompt' => 'Yes = aset menggunakan serial tracking; No = barang tanpa tracking.',
    //             //         'allowBlank' => false,
    //             //     ],
    //             // ];

    //             // foreach ($dropdowns as $column => $config) {
    //             //     for ($row = 2; $row <= 101; $row++) {
    //             //         $validation = $sheet 
    //             //             ->getCell($column . $row)
    //             //             ->getDataValidation();

    //             //         // $validation->setType(
    //             //         //     DataValidation::TYPE_LIST
    //             //         // );
    //             //         // $validation->setErrorStyle(
    //             //         //     DataValidation::STYLE_STOP
    //             //         // );
    //             //         $validation->setType(DataValidation::TYPE_LIST);
    //             //         $validation->setErrorStyle(DataValidation::STYLE_STOP);
    //             //         $validation->setAllowBlank($config['allowBlank']);
    //             //         // $validation->setAllowBlank($column === 'E');
    //             //         $validation->setShowInputMessage(true);
    //             //         $validation->setShowErrorMessage(true);
    //             //         $validation->setShowDropDown(false);
    //             //         $validation->setFormula1($config['formula']);
    //             //         $validation->setPromptTitle($config['title']);
    //             //         $validation->setPrompt($config['prompt']);
    //             //         $validation->setErrorTitle('Pilihan tidak valid');
    //             //         $validation->setError('Silahkan gunakan nilai dari daftar dropdown');
                        
    //             //     }
    //             // }

                                
    //             $dropdowns = [
    //                 'D' => [
    //                     'formula' => '=CategoryList',
    //                     'title' => 'Pilih Category',
    //                     'prompt' => 'Silakan pilih kategori perangkat.',
    //                     'allowBlank' => false,
    //                 ],
    //                 'E' => [
    //                     'formula' => '=OutletList',
    //                     'title' => 'Pilih Outlet',
    //                     'prompt' => 'Silakan pilih outlet lokasi aset.',
    //                     'allowBlank' => false,
    //                 ],
    //                 'F' => [
    //                     'formula' => '=OutletList',
    //                     'title' => 'Pilih Source Outlet',
    //                     'prompt' => 'Pilih outlet asal barang, atau kosongkan jika tidak ada.',
    //                     'allowBlank' => true,
    //                 ],
    //                 'G' => [
    //                     'formula' => '=TrackedList',
    //                     'title' => 'Pilih Yes/No',
    //                     'prompt' => 'Yes = menggunakan serial tracking; No = tanpa tracking.',
    //                     'allowBlank' => false,
    //                 ],
    //             ];

    //             foreach ($dropdowns as $column => $config) {
    //                 for ($row = 2; $row <= 3; $row++) {
    //                     $validation = $sheet
    //                         ->getCell($column . $row)
    //                         ->getDataValidation();

    //                     $validation->setType(DataValidation::TYPE_LIST);
    //                     $validation->setErrorStyle(DataValidation::STYLE_STOP);
    //                     $validation->setAllowBlank($config['allowBlank']);

    //                     // Penting: false berarti panah dropdown tidak disembunyikan.
    //                     $validation->setShowDropDown(true);

    //                     $validation->setShowInputMessage(true);
    //                     $validation->setShowErrorMessage(true);
    //                     $validation->setFormula1($config['formula']);

    //                     $validation->setPromptTitle($config['title']);
    //                     $validation->setPrompt($config['prompt']);

    //                     $validation->setErrorTitle('Pilihan tidak valid');
    //                     $validation->setError(
    //                         'Silakan pilih nilai dari daftar dropdown.'
    //                     );
    //                 }
    //             }


    //             $sheet->freezePane('A2');
    //             $sheet->getStyle('A1:J1')->getFont()->setBold(true);
    //             $sheet->getColumnDimension('A')->setWidth(24);
    //             $sheet->getColumnDimension('B')->setWidth(18);
    //             $sheet->getColumnDimension('C')->setWidth(20);
    //             $sheet->getColumnDimension('D')->setWidth(24);
    //             $sheet->getColumnDimension('E')->setWidth(24);

    //         },
    //     ];
    // }    

}
