<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\TagDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module = 'Tag';
        $folder_name = 'tags';
        $view_path = "admin.tags.";
        $base_route = "admin.tags.";
        $table_id = $folder_name . "Table";
        $ajax_url = route('admin.tags.data');
        $sub_heading = "Manage " . $folder_name;

        $columns = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'key', 'name' => 'key'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false],
        ];

        return view(
            'admin.tags.index',
            compact('module', 'folder_name', 'view_path', 'base_route', 'table_id', 'columns', 'ajax_url', 'sub_heading')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:tags,name',
            ]);

            $validated['slug'] = Str::slug($validated['name']);
            $validated['key'] = Str::slug($validated['name'], '_') . '_' . uniqid();
            $validated['status'] = 1;

            Tag::create($validated);

            DB::commit();

            return response()->json([
                "status" => "success",
                "message" => "Tag added successfully!",
            ]);

        }
        catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                "status" => "error",
                "message" => "Validation failed!",
                "errors" => $e->errors(),
            ], 422);

        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => "error",
                "message" => "Failed to add tag!",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $row = Tag::findOrFail($id);
            return response()->json([
                "status" => "success",
                "data" => $row,
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Tag not found!",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $tag = Tag::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:tags,name,' . $id,
            ]);

            $validated['slug'] = Str::slug($validated['name']);

            $tag->update($validated);

            DB::commit();

            return response()->json([
                "status" => "success",
                "message" => "Tag updated successfully!",
            ]);

        }
        catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                "status" => "error",
                "message" => "Validation failed!",
                "errors" => $e->errors(),
            ], 422);

        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => "error",
                "message" => "Failed to update tag!",
            ]);
        }
    }

    /**
     * Soft-delete the specified resource from storage.
     */
    public function softDelete(string $id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();

            return response()->json([
                "status" => "success",
                "message" => "Tag deleted successfully!",
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to delete tag!",
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $row = Tag::with(['projects', 'algorithms'])->findOrFail($id);
            $base_route = "admin.tags.";

            return view('admin.tags.show', compact('row', 'base_route'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'Tag not found!');
        }
    }

    /**
     * DataTable data endpoint.
     */
    public function data(Request $request)
    {
        return app(TagDataService::class)->getDataForDataTable($request);
    }
}
