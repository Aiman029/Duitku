<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $from;
    protected $to;
    protected $type;
    protected $categoryId;

    public function __construct($from = null, $to = null, $type = null, $categoryId = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->type = $type;
        $this->categoryId = $categoryId;
    }

    public function collection()
    {
        $query = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->orderBy('date');

        if ($this->from) {
            $query->whereDate('date', '>=', $this->from);
        }
        if ($this->to) {
            $query->whereDate('date', '<=', $this->to);
        }
        if ($this->type) {
            $query->where('type', $this->type);
        }
        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return ['Tarikh', 'Kategori', 'Jenis', 'Deskripsi', 'Jumlah (RM)'];
    }

    public function map($transaction): array
    {
        return [
            $transaction->date->format('d/m/Y'),
            $transaction->category->name ?? '-',
            $transaction->type === 'income' ? 'Pendapatan' : 'Perbelanjaan',
            $transaction->description ?: '-',
            number_format($transaction->amount, 2),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}