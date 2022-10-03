<?php

namespace App\Exports;

use App\Modules\HR\Entities\Management;
use Maatwebsite\Excel\Concerns\FromCollection;

class ManagementExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Management::query()
            ->select('created_at', 'status')
            ->whereHas('translations', function ($query) {
                $query->select('name');
            })
            ->with(['parent' => function ($query) {
                $query->whereHas('translations', function ($q) {
                    $q->select('name');
                });
            }])->get();
    }
}
