<?php

namespace App\Exports\Report;


use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
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
use PhpOffice\PhpSpreadsheet\Style\Border;;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AssetExport implements WithEvents, WithTitle, WithDrawings, WithColumnWidths, WithHeadings, WithMapping, FromQuery, WithCustomStartCell, WithColumnFormatting, WithStyles
{

    use Exportable;

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function query()
    {
        return Product::query()->with(['category', 'unit'])->withCount([
            'stocks as total_asset' => function ($builder){
                $builder->select(DB::raw("SUM(available_stock * buying_price) as total"));
            }])->take(3);
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function map($product): array
    {
        return [
            [
                '=row() - 6',
                $product->barcode,
                $product->name,
                ($product->store_stock + $product->warehouse_stock) ?: '0',
                $product->unit->name,
                $product->total_asset ?: '0',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            ['NO', 'BARCODE', 'NAMA PRODUK', 'STOCK', 'SATUAN', 'TOTAL'],
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
            'F' => 15,
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
        return 'Asset';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A4:F4')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_DOUBLE);
        $sheet->getStyle('F6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT );
        $sheet->getStyle('D6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT );

        $sheet->getStyle('A6:F6')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A6:F6')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_MEDIUM);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->cellValue('C2', 'LAPORAN TOTAL ASSET');
                $event->sheet->cellValue('C3', 'POSISI TANGGAL ' . str(now()->format('d F Y'))->upper());

            }
        ];
    }

    private function getColumn () {
        $col = array (
            'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
            'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
            'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
            'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
            'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
            'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
            'FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ','FK','FL','FM','FN','FO','FP','FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ',
            'GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ','GK','GL','GM','GN','GO','GP','GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ',
            'HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ','HK','HL','HM','HN','HO','HP','HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ',
        );
        return $col;
    }
}
