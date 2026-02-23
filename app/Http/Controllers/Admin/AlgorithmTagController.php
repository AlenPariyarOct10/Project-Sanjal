<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\AdminGeneralDataTableService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AlgorithmTagController extends Controller
{
    protected $module, $base_route, $folder_name;

    public function __construct()
    {
        $this->module = 'AlgorithmTag';
        $this->base_route = 'admin.algorithm_tags.';
        $this->folder_name = 'algorithm_tags';
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $module = 'AlgorithmTag';
        $folder_name = 'algorithm_tags';
        $view_path = 'admin.algorithm_tags.';
        $base_route = 'admin.algorithm_tags.';
        $table_id = $folder_name . 'Table';
        $ajax_url = route('admin.algorithm_tags.data');
        $sub_heading = 'Manage ' . $folder_name;

        $columns = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false],
        ];

        return view('admin.algorithm_tags.index', compact(
            'module', 'folder_name', 'view_path', 'base_route', 'table_id', 'columns', 'ajax_url', 'sub_heading'
        ));
    }

    /*
     * Provide data for DataTable
     * */

    public function data(Request $request)
    {
        $datatable = new AdminGeneralDataTableService(
            Tag::class ,
            'admin.algorithm_tags.',
            'AlgorithmTag',
        ['name', 'slug', 'key'],
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
                'name' => 'required|string|max:255',
                'status' => 'required|boolean',
            ]);

            // Slug & Key generation
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $count = 1;
            while (Tag::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $validated['slug'] = $slug;
            $validated['key'] = Str::slug($validated['name'], '_') . '_' . uniqid();

            Tag::create($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Algorithm Tag added successfully!'
            ]);

        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Algorithm Tag addition failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add Algorithm Tag: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Returns data of a specified resource for editing.
     */

    public function edit(string $id)
    {
        try {
            $row = Tag::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $row]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Algorithm Tag not found!']);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $item = Tag::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|boolean',
            ]);

            if ($item->name !== $validated['name']) {
                $baseSlug = Str::slug($validated['name']);
                $slug = $baseSlug;
                $count = 1;
                while (Tag::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $validated['slug'] = $slug;
            }

            $item->update($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Algorithm Tag updated successfully!'
            ]);
        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Algorithm Tag update failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Algorithm Tag: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function softDelete(string $id)
    {
        try {
            $item = Tag::findOrFail($id);
            $item->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'AlgorithmTag deleted successfully!'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete AlgorithmTag!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */

    public function show(string $slug)
    {
        try {
            $row = Tag::where('slug', $slug)->firstOrFail();
            $base_route = $this->base_route;
            return view('admin.algorithm_tags.show', compact('row', 'base_route'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'AlgorithmTag not found!');
        }
    }
}
