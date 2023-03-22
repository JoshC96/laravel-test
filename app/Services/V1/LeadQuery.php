<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class LeadQuery
{
    protected $allowedFields = [
        'id' => ['=', '<', '>'],
        'firstName' => ['=', 'like'],
        'lastName' => ['=', 'like'],
        'email' => ['=', 'like'], // would like to add an 'ilike' operator but doesn't work on MySQL
        'phone' => ['='],
        'electricBill' => ['=', '<', '>'],
    ];

    protected $columnMap = [
        'electricBill' => 'electric_bill',
        'firstName' => 'first_name',
        'lastName' => 'last_name',
    ];

    public function transform(Request $request) 
    {
        $eloQuery = [];

        foreach ($this->allowedFields as $field => $operators) {
            $query = $request->query($field);

            if(!isset($query)) continue;

            $column = $this->columnMap[$field] ?? $field;

            foreach ($operators as $operator) {
                if(isset($query[$operator])) {
                    $eloQuery[] = [$column, $operator, $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}