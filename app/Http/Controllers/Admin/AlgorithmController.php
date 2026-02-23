<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Algorithm;
use App\Models\AlgorithmCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\AdminGeneralDataTableService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AlgorithmController extends Controller
{
    protected $module, $base_route, $folder_name;

    public function __construct()
    {
        $this->module = 'Algorithm';
        $this->base_route = 'admin.algorithms.';
        $this->folder_name = 'algorithms';
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $module = 'Algorithm';
        $folder_name = 'algorithms';
        $view_path = 'admin.algorithms.';
        $base_route = 'admin.algorithms.';
        $table_id = $folder_name . 'Table';
        $ajax_url = route('admin.algorithms.data');
        $sub_heading = 'Manage ' . $folder_name;

        $columns = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false],
        ];

        $categories = AlgorithmCategory::where('status', 1)->get();
        $tags = Tag::where('status', 1)->get();

        return view('admin.algorithms.index', compact(
            'module', 'folder_name', 'view_path', 'base_route', 'table_id', 'columns', 'ajax_url', 'sub_heading', 'categories', 'tags'
        ));
    }

    /*
     * Provide data for DataTable
     * */

    public function data(Request $request)
    {
        $datatable = new AdminGeneralDataTableService(
            Algorithm::class ,
            'admin.algorithms.',
            'Algorithm',
        ['name', 'description'],
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
                'description' => 'nullable|string',
                'resource_url' => 'nullable|url|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'status' => 'required|boolean',
                'category_ids' => 'nullable|array',
                'category_ids.*' => 'exists:algorithm_categories,id',
                'tag_ids' => 'nullable|array',
                'tag_ids.*' => 'exists:tags,id',
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/algorithms'), $filename);
                $validated['image'] = 'uploads/algorithms/' . $filename;
            }

            // Slug & Key generation
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $count = 1;
            while (Algorithm::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $validated['slug'] = $slug;
            $validated['key'] = Str::slug($validated['name'], '_') . '_' . uniqid();

            $algorithm = Algorithm::create($validated);

            if ($request->has('category_ids')) {
                $algorithm->categories()->sync($request->category_ids);
            }
            if ($request->has('tag_ids')) {
                $algorithm->tags()->sync($request->tag_ids);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Algorithm added successfully!'
            ]);

        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Algorithm addition failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add Algorithm: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Returns data of a specified resource for editing.
     */

    public function edit(string $id)
    {
        try {
            $row = Algorithm::with(['categories', 'tags'])->findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $row]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Algorithm not found!']);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $item = Algorithm::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'resource_url' => 'nullable|url|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'status' => 'required|boolean',
                'category_ids' => 'nullable|array',
                'category_ids.*' => 'exists:algorithm_categories,id',
                'tag_ids' => 'nullable|array',
                'tag_ids.*' => 'exists:tags,id',
            ]);

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($item->image && file_exists(public_path($item->image))) {
                    @unlink(public_path($item->image));
                }
                $file = $request->file('image');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/algorithms'), $filename);
                $validated['image'] = 'uploads/algorithms/' . $filename;
            }

            if ($item->name !== $validated['name']) {
                $baseSlug = Str::slug($validated['name']);
                $slug = $baseSlug;
                $count = 1;
                while (Algorithm::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $validated['slug'] = $slug;
            }

            $item->update($validated);

            $item->categories()->sync($request->category_ids ?? []);
            $item->tags()->sync($request->tag_ids ?? []);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Algorithm updated successfully!'
            ]);
        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Algorithm update failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Algorithm: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function softDelete(string $id)
    {
        try {
            $item = Algorithm::findOrFail($id);
            $item->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Algorithm deleted successfully!'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Algorithm!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */

    public function show(string $slug)
    {
        try {
            $row = Algorithm::where('slug', $slug)->firstOrFail();
            $base_route = $this->base_route;
            return view('admin.algorithms.show', compact('row', 'base_route'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'Algorithm not found!');
        }
    }
}
