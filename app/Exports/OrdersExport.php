<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        return Order::whereBetween('tanggal_pemesanan', [$this->start, $this->end])
                    ->select('invoices', 'nama_pemesan', 'tanggal_pemesanan', 'total_harga', 'status')
                    ->get();
    }

    public function headings(): array
    {
        return [
            'Invoice', 'Nama Pemesan', 'Tanggal Pemesanan', 'Total Harga', 'Status'
        ];
    }

    public function title(): string
    {
        return 'Laporan Orders';
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A:E')->getAlignment()->setHorizontal('center');
    }
}
