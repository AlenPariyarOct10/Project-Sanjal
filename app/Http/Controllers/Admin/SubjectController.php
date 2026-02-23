<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\AdminGeneralDataTableService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
{
    protected $module, $base_route, $folder_name;

    public function __construct()
    {
        $this->module = 'Subject';
        $this->base_route = 'admin.subjects.';
        $this->folder_name = 'subjects';
    }

    public function index()
    {
        $module = $this->module;
        $folder_name = $this->folder_name;
        $view_path = 'admin.subjects.';
        $base_route = $this->base_route;
        $table_id = $folder_name . 'Table';
        $ajax_url = route('admin.subjects.data');
        $sub_heading = 'Manage ' . $folder_name;

        $columns = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'code', 'name' => 'code'],
            ['data' => 'course_id', 'name' => 'course_id'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false],
        ];

        $courses = Course::where('status', 1)->get();

        return view('admin.subjects.index', compact(
            'module', 'folder_name', 'view_path', 'base_route', 'table_id', 'columns', 'ajax_url', 'sub_heading', 'courses'
        ));
    }

    public function data(Request $request)
    {
        // We override to show course name
        $query = Subject::with('course');

        if ($request->filled('search_value')) {
            $search = $request->search_value;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        return \Yajra\DataTables\DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('course_id', function ($row) {
            return $row->course ? $row->course->name : '-';
        })
            ->editColumn('created_at', function ($row) {
            return $row->created_at ? $row->created_at->format('M d, Y') : '-';
        })
            ->addColumn('action', function ($row) {
            return $this->renderActions($row);
        })
            ->rawColumns(['action'])
            ->make(true);
    }

    protected function renderActions($row)
    {
        $group = '<div class="flex gap-2">';
        $group .= '<button data-id="' . $row->id . '" class="editBtn px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition" title="Edit Subject"><i class="fas fa-edit"></i></button>';
        $group .= '<button data-id="' . $row->id . '" class="deleteBtn px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition" title="Delete Subject"><i class="fa fa-trash"></i></button>';
        $group .= '</div>';
        return $group;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'nullable|string|max:50',
                'course_id' => 'required|exists:courses,id',
                'description' => 'nullable|string',
            ]);

            Subject::create($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Subject added successfully!'
            ]);

        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Subject addition failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add Subject: ' . $e->getMessage()
            ]);
        }
    }

    public function edit(string $id)
    {
        try {
            $row = Subject::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $row]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Subject not found!']);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $item = Subject::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'nullable|string|max:50',
                'course_id' => 'required|exists:courses,id',
                'description' => 'nullable|string',
            ]);

            $item->update($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Subject updated successfully!'
            ]);
        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Subject update failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Subject: ' . $e->getMessage()
            ]);
        }
    }

    public function softDelete(string $id)
    {
        try {
            $item = Subject::findOrFail($id);
            $item->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Subject deleted successfully!'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Subject!'
            ]);
        }
    }
}
