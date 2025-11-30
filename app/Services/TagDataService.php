<?php

namespace App\Services;

use App\Models\Tag;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TagDataService
{
    public function getDataForDataTable(Request $request)
    {
        $query = Tag::query();

        // Handle search
        if ($request->has('search_value') && $request->search_value != '') {
            $search = $request->search_value;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('key', 'like', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('name', function ($row) {
                return $row->name ?? "-";
            })
            ->editColumn('key', function ($row) {
                return $row->key ?? "-";
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('M d, Y H:i') : "-";
            })
            ->editColumn('action', function ($row) {
                return '
                    <div class="flex gap-2">
                        <a href="'.route('admin.tags.show', $row->id).'"
                           class="px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition"
                           title="View">
                           <i class="fa fa-eye"></i>
                        </a>

                        <a href="'.route('admin.tags.edit', $row->id).'"
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
