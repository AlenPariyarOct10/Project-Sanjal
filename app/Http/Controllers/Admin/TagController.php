<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Services\TagDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $table_id = $folder_name."Table";

        return view(
            'admin.tags.index',
            compact('module', 'folder_name', 'view_path', 'base_route', 'table_id',)
        );

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // 1. Validate request
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'key' => 'required|string',
                'slug'     => 'required|string|max:255',
            ]);
            $validated['status'] = 1;

            Tag::create($validated);

            DB::commit();

            return response()->json([
                "status"  => "success",
                "message" => "Tag added successfully!",
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                "status"  => "error",
                "message" => "Failed to add tag!",
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function data(Request $request)
    {
        return app(TagDataService::class)->getDataForDataTable($request);
    }
}
