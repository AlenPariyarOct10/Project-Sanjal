<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UniversityRequest;
use App\Models\University;
use App\Services\UniversiyDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use Yajra\DataTables\DataTables;

class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $module = 'University';
        $folder_name = 'universities';
        $view_path = "admin.universities.";
        $base_route = "admin.universities.";
        $table_id = $folder_name."Table";

        return view(
            'admin.universities.index',
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
                'description' => 'nullable|string',
                'address'     => 'nullable|string|max:255',
                'phone'       => 'nullable|string|max:50',
                'email'       => 'nullable|email|max:255',
                'website'     => 'nullable|url|max:255',
                'facebook'    => 'nullable|url|max:255',
                'twitter'     => 'nullable|url|max:255',
                'instagram'   => 'nullable|url|max:255',
                'youtube'     => 'nullable|url|max:255',
                'linkedin'    => 'nullable|url|max:255',
                'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            // 2. File upload
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/universities'), $filename);

                $validated['logo'] = 'uploads/universities/' . $filename;
            }

            University::create($validated);

            DB::commit();

            return response()->json([
                "status"  => "success",
                "message" => "University added successfully!",
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                "status"  => "error",
                "message" => "Failed to add university!",
            ]);
        }
    }

    public function data(Request $request)
    {
        return app(UniversiyDataService::class)->getDataForDataTable($request);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('admin.universities.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $row = University::findOrFail($id);
            return response()->json([
                "status"  => "success",
                "data"    => $row,
            ]);
        }catch(\Exception $e){
            return response()->json([
                "status"  => "error",
                "message" => "University not found!",
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

            $university = University::findOrFail($id);

            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
                'address'     => 'nullable|string|max:255',
                'phone'       => 'nullable|string|max:50',
                'email'       => 'nullable|email|max:255',
                'website'     => 'nullable|url|max:255',
                'facebook'    => 'nullable|url|max:255',
                'twitter'     => 'nullable|url|max:255',
                'instagram'   => 'nullable|url|max:255',
                'youtube'     => 'nullable|url|max:255',
                'linkedin'    => 'nullable|url|max:255',
                'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/universities'), $filename);
                $validated['logo'] = 'uploads/universities/' . $filename;
            }

            $university->update($validated);

            DB::commit();

            return response()->json([
                "status" => "success",
                "message" => "University updated successfully!",
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => "error",
                "message" => "Failed to update university!",
            ]);
        }
    }

    /**
     * Soft Delete the specified resource from storage.
     */
    public function softDelete(string $id)
    {
        try {
            $university = University::findOrFail($id);
            $university->delete();

            return response()->json([
                "status"  => "success",
                "message" => "University deleted successfully!",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status"  => "error",
                "message" => "Failed to delete university!",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
