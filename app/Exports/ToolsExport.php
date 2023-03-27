<?php

namespace App\Exports;

use App\Models\Tool;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ToolsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    /**
     * @var Tool $user
     */
    public function map($tool): array
    {
        return [
            $tool->id,
            $tool->name
        ];
    }


    public function headings(): array
    {
        return [
            '#',
            'название'
        ];
    }

    public function query()
    {
        return Tool::query()->orderby('name', 'asc');
    }
}
