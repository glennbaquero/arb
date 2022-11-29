<?php

namespace App\Exports\Users;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserExport implements FromArray, WithStrictNullComparison, WithHeadings, ShouldAutoSize
{
    protected $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function array(): array
    {
    	$result = [];

    	foreach ($this->items as $item) {
    		$result[] = [
                'id' => $item->id,
                'firstname' => $item->first_name,
                'lastname' => $item->last_name,
                'email' => $item->email,
                'username' => $item->username,
                'gender' => $item->gender,
                'birthday' => $item->renderDate('birthday', 'M d, Y'),
                'age' => $item->age,
                'mobile_number' => $item->mobile_number,
                'telephone_number' => $item->telephone_number,
                'status' => $item->renderStatus(),
                'created_at' => $item->renderDate(),
            ];
    	}

        return $result;
    }

    public function headings(): array
    {
        return [
            '#',
            'First Name',
            'Last Name',
            'Email',
            'Username',
            'Gender',
            'Mobile #',
            'Telephone #',
            'Status',
            'Registration Date',
        ];
    }
}