<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlgorithmCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\AdminGeneralDataTableService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AlgorithmCategoryController extends Controller
{
    protected $module, $base_route, $folder_name;

    public function __construct()
    {
        $this->module = 'AlgorithmCategory';
        $this->base_route = 'admin.algorithm_categories.';
        $this->folder_name = 'algorithm_categories';
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $module = 'AlgorithmCategory';
        $folder_name = 'algorithm_categories';
        $view_path = 'admin.algorithm_categories.';
        $base_route = 'admin.algorithm_categories.';
        $table_id = $folder_name . 'Table';
        $ajax_url = route('admin.algorithm_categories.data');
        $sub_heading = 'Manage ' . $folder_name;

        $columns = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'type', 'name' => 'type'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false],
        ];

        return view('admin.algorithm_categories.index', compact(
            'module', 'folder_name', 'view_path', 'base_route', 'table_id', 'columns', 'ajax_url', 'sub_heading'
        ));
    }

    /*
     * Provide data for DataTable
     * */

    public function data(Request $request)
    {
        $datatable = new AdminGeneralDataTableService(
            AlgorithmCategory::class ,
            'admin.algorithm_categories.',
            'AlgorithmCategory',
        ['type', 'name', 'description'],
            );
        return $datatable->getDataForDataTable($request);
    }

    /*
     * Create a Custom Request and Replace Request for Validation
     * */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'type' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|boolean',
            ]);

            // Slug & Key generation
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $count = 1;
            while (AlgorithmCategory::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $validated['slug'] = $slug;
            $validated['key'] = Str::slug($validated['name'], '_') . '_' . uniqid();

            AlgorithmCategory::create($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Algorithm Category added successfully!'
            ]);

        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Algorithm Category addition failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add Algorithm Category: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Returns data of a specified resource for editing.
     */

    public function edit(string $id)
    {
        try {
            $row = AlgorithmCategory::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $row]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'AlgorithmCategory not found!']);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $item = AlgorithmCategory::findOrFail($id);

            $validated = $request->validate([
                'type' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|boolean',
            ]);

            if ($item->name !== $validated['name']) {
                $baseSlug = Str::slug($validated['name']);
                $slug = $baseSlug;
                $count = 1;
                while (AlgorithmCategory::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $validated['slug'] = $slug;
            }

            $item->update($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Algorithm Category updated successfully!'
            ]);
        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Algorithm Category update failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Algorithm Category: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function softDelete(string $id)
    {
        try {
            $item = AlgorithmCategory::findOrFail($id);
            $item->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'AlgorithmCategory deleted successfully!'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete AlgorithmCategory!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */

    public function show(string $slug)
    {
        try {
            $row = AlgorithmCategory::where('slug', $slug)->firstOrFail();
            $base_route = $this->base_route;
            return view('admin.algorithm_categories.show', compact('row', 'base_route'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'AlgorithmCategory not found!');
        }
    }
}
