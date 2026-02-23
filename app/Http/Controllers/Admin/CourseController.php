<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\AdminGeneralDataTableService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CourseController extends Controller
{
    protected $module, $base_route, $folder_name;

    public function __construct()
    {
        $this->module = 'Course';
        $this->base_route = 'admin.courses.';
        $this->folder_name = 'courses';
    }

    public function index()
    {
        $module = $this->module;
        $folder_name = $this->folder_name;
        $view_path = 'admin.courses.';
        $base_route = $this->base_route;
        $table_id = $folder_name . 'Table';
        $ajax_url = route('admin.courses.data');
        $sub_heading = 'Manage ' . $folder_name;

        $columns = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'code', 'name' => 'code'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false],
        ];

        $universities = University::where('status', 1)->get();

        return view('admin.courses.index', compact(
            'module', 'folder_name', 'view_path', 'base_route', 'table_id', 'columns', 'ajax_url', 'sub_heading', 'universities'
        ));
    }

    public function data(Request $request)
    {
        $datatable = new AdminGeneralDataTableService(
            Course::class ,
            $this->base_route,
            $this->module,
        ['name', 'code', 'key'],
            );
        return $datatable->getDataForDataTable($request);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'nullable|string|max:50',
                'university_id' => 'required|exists:universities,id',
                'description' => 'nullable|string',
                'status' => 'required|boolean',
            ]);

            $validated['key'] = Str::slug($validated['name'], '_');

            Course::create($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Course added successfully!'
            ]);

        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Course addition failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add Course: ' . $e->getMessage()
            ]);
        }
    }

    public function edit(string $id)
    {
        try {
            $row = Course::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $row]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Course not found!']);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $item = Course::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'nullable|string|max:50',
                'university_id' => 'required|exists:universities,id',
                'description' => 'nullable|string',
                'status' => 'required|boolean',
            ]);

            $item->update($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Course updated successfully!'
            ]);
        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Course update failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Course: ' . $e->getMessage()
            ]);
        }
    }

    public function softDelete(string $id)
    {
        try {
            $item = Course::findOrFail($id);
            $item->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Course deleted successfully!'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Course!'
            ]);
        }
    }
}
