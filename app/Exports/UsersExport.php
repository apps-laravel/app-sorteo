<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements  FromArray, WithHeadings, WithStyles,ShouldAutoSize
{

    public function array(): array
    {
        $data = DB::table('users')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->join('cities', 'users.city_id', '=', 'cities.id')
            ->select('users.name','users.last_name','users.email', 'users.cc', 'users.gender','users.phone', 'departments.name as department', 'cities.name as city')
            ->get();

        $data->map(function($item){
            $item->name = $item->name . ' ' . $item->last_name;
            unset($item->last_name);
            return $item;
        });

        return $data->toArray();
    }
    public  function styles(Worksheet $sheet){
        return [
            1 => ['font' => ['bold' => true]]
        ];

    }
    public function headings(): array
    {
        return [
            'Nombre',
            'Email',
            'Cedula',
            'Genero',
            'Telefono',
            'Departamento',
            'Ciudad'
        ];
    }
}
