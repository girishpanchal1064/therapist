<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DataTablesHelper
{
    protected $query;
    protected $request;
    protected $columns = [];
    protected $searchableColumns = [];
    protected $orderableColumns = [];

    public function __construct($query, Request $request = null)
    {
        $this->query = $query;
        $this->request = $request ?: request();
    }

    public static function of($query, Request $request = null)
    {
        if (!$request) {
            $request = request();
        }
        return new static($query, $request);
    }

    public function addColumn($name, $callback)
    {
        $this->columns[$name] = $callback;
        return $this;
    }

    public function addIndexColumn()
    {
        $this->addColumn('DT_RowIndex', function ($row, $index) {
            return $index + 1;
        });
        return $this;
    }

    public function rawColumns($columns)
    {
        // Store raw columns for later use
        $this->rawColumns = $columns;
        return $this;
    }

    public function make($getData = true)
    {
        $draw = intval($this->request->input('draw'));
        $start = intval($this->request->input('start'));
        $length = intval($this->request->input('length'));
        $searchValue = $this->request->input('search.value');
        $orderColumn = intval($this->request->input('order.0.column'));
        $orderDir = $this->request->input('order.0.dir', 'asc');

        // Get total records count
        $totalRecords = $this->query->count();

        // Apply search
        if (!empty($searchValue)) {
            $this->applySearch($searchValue);
        }

        // Get filtered count
        $filteredRecords = $this->query->count();

        // Apply ordering
        $this->applyOrdering($orderColumn, $orderDir);

        // Apply pagination
        $data = $this->query->skip($start)->take($length)->get();

        // Process data with custom columns
        $processedData = $this->processData($data);

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $processedData
        ]);
    }

    protected function applySearch($searchValue)
    {
        $this->query->where(function ($query) use ($searchValue) {
            foreach ($this->searchableColumns as $column) {
                $query->orWhere($column, 'like', "%{$searchValue}%");
            }
        });
    }

    protected function applyOrdering($orderColumn, $orderDir)
    {
        if (isset($this->orderableColumns[$orderColumn])) {
            $this->query->orderBy($this->orderableColumns[$orderColumn], $orderDir);
        }
    }

    protected function processData($data)
    {
        $processedData = [];

        foreach ($data as $index => $row) {
            $rowData = $row->toArray();

            // Apply custom columns
            foreach ($this->columns as $columnName => $callback) {
                $rowData[$columnName] = $callback($row, $index);
            }

            $processedData[] = $rowData;
        }

        return $processedData;
    }

    public function setSearchableColumns($columns)
    {
        $this->searchableColumns = $columns;
        return $this;
    }

    public function setOrderableColumns($columns)
    {
        $this->orderableColumns = $columns;
        return $this;
    }
}
