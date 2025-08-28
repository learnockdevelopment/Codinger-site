<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VouchersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $vouchers;

    public function __construct($vouchers)
    {
        $this->vouchers = $vouchers;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->vouchers;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'ID',
            trans('admin/main.batch_name'),
            trans('admin/main.code'),
            trans('admin/main.amount'),
            trans('admin/main.created_date'),
            trans('admin/main.user'),
            trans('admin/main.status'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($voucher): array
    {
        return [
            $voucher->id,
            $voucher->batch_name,
            $voucher->code,
            $voucher->amount,
            dateTimeFormat($voucher->created_at, 'j M Y H:i'),
            $voucher->user ? $voucher->user->full_name : trans('admin/main.not_assigned'),
            $voucher->is_used ? trans('panel.expired') : trans('admin/main.active'),
        ];
    }
}
