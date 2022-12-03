<?php

namespace App\Exports\Report;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductStockExport implements WithEvents, WithTitle, WithDrawings, WithColumnWidths, WithHeadings, WithCustomStartCell, WithColumnFormatting, WithStyles
{

    protected $category_id;

    public function __construct($category_id = null)
    {
        $this->category_id  = $category_id;
    }

    public function columnFormats(): array
    {
        return [
//            'B' => NumberFormat::FORMAT_TEXT,
//            'D' => NumberFormat::FORMAT_NUMBER,
//            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    private function products()
    {
        return Product::query()
            ->with(['unit', 'stocks', 'prices.unit'])
            ->when($this->category_id, function ($category, $id){
                $category->where('category_id', $id);
            });
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function headings(): array
    {
        return [
            ['NO', 'BARCODE', 'NAMA PRODUK', 'STOCK', '', '', 'SATUAN', 'HARGA JUAL'],
            ['', '', '', 'GUDANG', 'TOKO', 'TOTAL', '',  'ECERAN', 'PELANGGAN', 'GROSIR'],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 20,
            'C' => 50,
            'D' => 10,
            'E' => 10,
            'F' => 10,
            'G' => 8,
            'H' => 15,
            'I' => 15,
            'J' => 15,
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('TB-SBR logo');
        $drawing->setPath(public_path('/img/sbr-logo.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function title(): string
    {
        return 'stok_dan_harga_jual';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A4:J4')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_DOUBLE);
        $sheet->getStyle('D7:J7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT );
        $sheet->getStyle('D6:J6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER );

        $sheet->getStyle('A6:J6')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A7:J7')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);

        $sheet->mergeCells('D6:F6');
        $sheet->mergeCells('H6:J6');
        $sheet->mergeCells('A6:A7');
        $sheet->mergeCells('B6:B7');
        $sheet->mergeCells('C6:C7');
        $sheet->mergeCells('G6:G7');


        $sheet->getStyle('A6:A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER );
        $sheet->getStyle('B6:B7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER );
        $sheet->getStyle('C6:C7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER );
        $sheet->getStyle('G6:G7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER );

        $sheet->getStyle('A6:A7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER );
        $sheet->getStyle('B6:B7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER );
        $sheet->getStyle('C6:C7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER );
        $sheet->getStyle('G6:G7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER );
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->cellValue('C2', 'LAPORAN STOCK DAN DAFTAR HARGA JUAL PRODUK');
                $event->sheet->cellValue('C3', 'POSISI TANGGAL ' . str(now()->format('d F Y'))->upper());


                $fontsize = 9;

                $col = $this->getColumn();
                $colCell = 0;
                $rowCell = 8;
                $no = 1;
                $products = $this->products()->get();

                foreach ($products as $product) {
                    $prices = collect($product->prices)->sortByDesc('quantity');

                    $current_warehouse_stock = $product->warehouse_stock ?: 0;
                    $current_store_stock = $product->store_stock ?: 0;
                    $current_total_stock = $product->total ?: 0;


                    $event->sheet->getStyle($col[$colCell + 3]. $rowCell.':'.$col[$colCell + 5]. $rowCell)->getFont()->setBold(true);
                    $event->sheet->getStyle($col[$colCell + 1]. $rowCell)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

                    $event->sheet->cellValue($col[$colCell] . $rowCell, $no);
                    $event->sheet->cellValue($col[$colCell + 1]. $rowCell, $product->barcode);
                    $event->sheet->cellValue($col[$colCell + 2]. $rowCell, $product->name);
                    $event->sheet->cellValue($col[$colCell + 3]. $rowCell, ($product->warehouse_stock ?: 0));
                    $event->sheet->cellValue($col[$colCell + 4]. $rowCell, ($product->store_stock ?: 0));
                    $event->sheet->cellValue($col[$colCell + 5]. $rowCell, (($product->warehouse_stock ?: 0) + $product->store_stock ?: 0));
                    $event->sheet->cellValue($col[$colCell + 6]. $rowCell, $product->unit->name);

                    if($prices->count() > 1){
                        $rowCell++;
                    }
                    foreach ($prices as $price) {
                        $warehouse_stock = $current_warehouse_stock / $price['quantity'];
                        $store_stock = $current_store_stock / $price['quantity'];
                        $total_stock = $current_total_stock / $price['quantity'];

                        $event->sheet->cellValue($col[$colCell + 3]. $rowCell, (int) $warehouse_stock);
                        $event->sheet->cellValue($col[$colCell + 4]. $rowCell, (int) $store_stock);
                        $event->sheet->cellValue($col[$colCell + 5]. $rowCell, (int) $total_stock);

                        $event->sheet->cellValue($col[$colCell + 6]. $rowCell, $price->unit->name);

                        $event->sheet->cellValue($col[$colCell + 7]. $rowCell, $price['sell_price']);
                        $event->sheet->cellValue($col[$colCell + 8]. $rowCell, $price['customer_price']);
                        $event->sheet->cellValue($col[$colCell + 9]. $rowCell, $price['wholesale_price']);

                        $event->sheet->getStyle($col[$colCell + 7]. $rowCell . ':' . $col[$colCell + 9]. $rowCell)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                        $current_warehouse_stock = $current_warehouse_stock - ( (int) $warehouse_stock * $price['quantity']);
                        $current_store_stock = $current_store_stock - ( (int) $store_stock * $price['quantity']);
                        $current_total_stock = $current_total_stock - ( (int) $total_stock * $price['quantity']);

                        $rowCell++;
                        $no++;
                    }
                }

            }
        ];
    }

    private function getColumn () {
        return [
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
            'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
            'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
            'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
            'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
            'FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ','FK','FL','FM','FN','FO','FP','FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ',
            'GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ','GK','GL','GM','GN','GO','GP','GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ',
            'HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ','HK','HL','HM','HN','HO','HP','HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ',
        ];
    }
}
