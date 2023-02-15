<?php

namespace App\Exports;

use App\Models\Agreement;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AgreemetsExport implements FromQuery, WithHeadings, WithMapping
{

    public function query()
    {
        return Agreement::query();
    }

    public function headings(): array
    {
        return [
            'id',
            '№',
            'Дата договора',
            'Начало действия',
            'Окончания действия',
            'Актуальный',
            'Статус',
            'Организация',
            'Инн',
            'Организация(полное)',
            'Юр. Адресс',
        ];
    }

    /**
     * @var Agreement $agreement
     */
    public function map($agreement): array
    {
        return [
            $agreement->id,
            $agreement->num_agreement,
            $agreement->date_agreement ? date('d.m.Y', strtotime($agreement->date_agreement)) : '-',
            $agreement->date_bg ? date('d.m.Y', strtotime($agreement->date_bg)) : '-',
            $agreement->date_end ? date('d.m.Y', strtotime($agreement->date_end)) : '-',
            $agreement->is_actual  ? 'да' : 'нет',
            $agreement->status ? $agreement->status->name : '-',
            $agreement->company->name,
            $agreement->company->inn,
            $agreement->company->name_full,
            $agreement->company->legal_adress,
        ];

    }
}
