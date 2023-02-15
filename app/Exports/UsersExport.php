<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    /**
     * @var User $user
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->username,
            $user->role->name
        ];
    }


    public function headings(): array
    {
        return [
            '#',
            'username',
            'role'
        ];
    }

    public function query()
    {
        return User::query();
    }
}
