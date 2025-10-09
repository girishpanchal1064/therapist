<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Helpers\DataTablesHelper;

class DataTables extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'datatables';
    }

    public static function of($query, $request = null)
    {
        return DataTablesHelper::of($query, $request);
    }
}
