<?php

namespace App\Http\Controllers\Api;

use App\CustomColumn;
use App\Http\Requests\UpdateCustomColumnsRequest;
use App\Http\Controllers\Controller;
use Session;

class SearchController extends Controller
{
    public function columns(CustomColumn $customColumn)
    {
        return response()->json([
            'availableColumns' => $this->getAvailableColumns(),
            'customColumns' => $customColumn->all()->pluck('name'),
        ], 200);
    }

    public function updateCustomColumns(UpdateCustomColumnsRequest $request, CustomColumn $customColumn)
    {
        foreach ($customColumn->all() as $column) {
            $column->delete();
        }
        foreach ($request->customColumns as $columnName) {
            $customColumn->create([
                'name' => $columnName,
            ]);
        }

        return response()->json([], 200);
    }

    private function getAvailableColumns()
    {
        return [
            'Id',
            'Email',
            'Name',
            'Company name',
            'First name',
            'Last name',
            'Spouse name',
            'Birthday',
            'Birthday month',
            'Birthday year',
            'Company',
            'Phone 1',
            'Phone 2',
            'Phone 3',
            'Email address 2',
            'Email address 3',
            'Fax 1',
            'Fax 2',
            'Street address 1',
            'Street address 2',
            'City',
        ];
    }
}
