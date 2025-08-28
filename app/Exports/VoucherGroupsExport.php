<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VoucherGroupsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $groups;

    public function __construct($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->groups;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'ID',
            trans('admin/main.batch_name'),
            // Add other relevant group-level headings if needed
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($group): array
    {
        return [
            $group->id,
            $group->batch_name,
            // Map other group data if available
        ];
    }
}
