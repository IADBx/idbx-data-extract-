<?php

namespace App\Exports;

use App\Problem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ProblemsExport implements FromQuery
{
    use Exportable;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function query()
    {
        return Problem::query()->where('resource_id', $this->resource)->select('comment');
    }
}
