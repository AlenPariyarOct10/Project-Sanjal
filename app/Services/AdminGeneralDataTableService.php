<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\DataTables;

class AdminGeneralDataTableService
{
    protected $model;
    protected $searchable = [];
    protected $base_route;
    protected $module;

    public function __construct($model, $base_route, $module, $searchable = [])
    {
        $this->model = $model;           // Eloquent Model class (string)
        $this->base_route = $base_route; // Example: 'admin.universities.'
        $this->module = $module;         // Example: 'University'
        $this->searchable = $searchable; // Columns for search
    }

    public function getDataForDataTable(Request $request)
    {

        $raw = [];
        array_push($raw, 'action');


        $query = ($this->model)::query();
        $modelInstance = new $this->model;

        // Handle search
        if ($request->filled('search_value') && !empty($this->searchable)) {
            $search = $request->search_value;
            $query->where(function($q) use ($search) {
                foreach ($this->searchable as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            });
        }

        $datatable = DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('action', function ($row) {
                return $this->renderActions($row);
            });

        foreach ($modelInstance->getFillable() as $column) {
            $datatable->editColumn($column, function ($row) use ($raw, $column) {
                if (in_array($column, ['created_at', 'updated_at'])) {
                    return $row->$column ? $row->$column->format('M d, Y H:i') : "-";
                }

                if($column == 'status') {
                    array_push($raw, 'status');
                    return $row->$column ? 'Active' : 'Inactive';
                }

                return $row->$column ?? "-";
            });
        }

        return $datatable->rawColumns($raw)->make(true);
    }

    protected function renderActions($row)
    {

        $identifier = $row->getAttribute('slug') ?: $row->id;
        $group = '<div class="flex gap-2">';

        if(Route::has($this->base_route.'show')) {
            $group .= '<a href="' . route($this->base_route.'show', $identifier) . '"
                       class="px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition"
                       title="View '.$this->module.'">
                       <i class="fa fa-eye"></i>
                    </a>';
        }

        if(Route::has($this->base_route.'edit')) {
            $group .= '<button data-id="'.$row->id.'"
                       class="editBtn px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition"
                       title="Edit '.$this->module.'">
                       <i class="fas fa-edit"></i>
                    </button>';
        }

        if(Route::has($this->base_route.'destroy')) {
            $group .= '<button data-id="'.$row->id.'"
                       class="deleteBtn px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition"
                       title="Delete '.$this->module.'">
                       <i class="fa fa-trash"></i>
                    </button>';
        }

        $group .= '</div>';
        return $group;
    }
}
