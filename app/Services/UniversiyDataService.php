<?php

namespace App\Services;

use App\Models\University;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UniversiyDataService
{
    public function getDataForDataTable(Request $request)
    {
        $query = University::query();

        // Handle search
        if ($request->has('search_value') && $request->search_value != '') {
            $search = $request->search_value;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('website', 'like', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('address', function ($row) {
                return $row->address ?? "-";
            })
            ->editColumn('website', function ($row) {
                return $row->website ?? "-";
            })
            ->editColumn('phone', function ($row) {
                return $row->phone ?? "-";
            })
            ->editColumn('email', function ($row) {
                return $row->email ?? "-";
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d H:i') : "-";
            })
            ->editColumn('action', function ($row) {
                return '
                    <div class="flex gap-2">
                        <a href="'.route('admin.universities.show', $row->id).'"
                           class="px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition"
                           title="View">
                           <i class="fa fa-eye"></i>
                        </a>

                        <a href="'.route('admin.universities.edit', $row->id).'"
                           class="px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition"
                           title="Edit">
                           <i class="fas fa-edit"></i>
                        </a>

                        <button data-id="'.$row->id.'"
                           class="deleteBtn px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition"
                           title="Delete">
                           <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
