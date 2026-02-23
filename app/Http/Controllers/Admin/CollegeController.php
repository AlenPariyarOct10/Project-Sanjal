<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Services\AdminGeneralDataTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CollegeController extends Controller
{
    protected $base_route, $module, $folder_name;

    public function __construct()
    {
        $this->module = 'College';
        $this->base_route = "admin.colleges.";
        $this->folder_name = "colleges.";
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module = $this->module;
        $folder_name = 'colleges';
        $view_path = "admin.colleges.";
        $base_route = $this->base_route;
        $table_id = $folder_name . "Table";
        $ajax_url = route('admin.colleges.data');
        $sub_heading = "Manage Colleges across Nepal";

        $columns = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'university_id', 'name' => 'university.name'],
            ['data' => 'address', 'name' => 'address'],
            ['data' => 'phone', 'name' => 'phone'],
            ['data' => 'email', 'name' => 'email'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false],
        ];

        $universities = \App\Models\University::orderBy('name')->get();

        return view(
            'admin.colleges.index',
            compact('module', 'folder_name', 'view_path', 'base_route', 'table_id', 'columns', 'ajax_url', 'sub_heading', 'universities')
        );
    }

    /**
     * Data for DataTables.
     */
    public function data(Request $request)
    {
        $datatable = new AdminGeneralDataTableService(
            College::class ,
            $this->base_route,
            $this->module,
        ['name', 'address', 'email', 'phone', 'website', 'created_at'],
            );

        return $datatable->getDataForDataTable($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'university_id' => 'required|exists:universities,id',
                'description' => 'nullable|string',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'website' => 'nullable|url|max:255',
                'facebook' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'instagram' => 'nullable|url|max:255',
                'youtube' => 'nullable|url|max:255',
                'linkedin' => 'nullable|url|max:255',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'status' => 'required|boolean',
            ]);

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('colleges', 'public');
                $validated['logo'] = $path;
            }

            $validated['user_id'] = auth()->id();

            College::create($validated);

            DB::commit();

            return response()->json([
                "status" => "success",
                "message" => "College added successfully!",
            ]);

        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("College addition failed: " . $e->getMessage());
            return response()->json([
                "status" => "error",
                "message" => "Failed to add college: " . $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $row = College::findOrFail($id);
            $base_route = $this->base_route;
            return view('admin.colleges.show', compact('row', 'base_route'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'College not found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $row = College::findOrFail($id);
            return response()->json([
                "status" => "success",
                "data" => $row,
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "College not found!",
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

            $college = College::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'university_id' => 'required|exists:universities,id',
                'description' => 'nullable|string',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'website' => 'nullable|url|max:255',
                'facebook' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'instagram' => 'nullable|url|max:255',
                'youtube' => 'nullable|url|max:255',
                'linkedin' => 'nullable|url|max:255',
                'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'status' => 'required|boolean',
            ]);

            if ($request->hasFile('logo')) {
                if ($college->logo) {
                    Storage::disk('public')->delete($college->logo);
                }
                $path = $request->file('logo')->store('colleges', 'public');
                $validated['logo'] = $path;
            }

            $college->update($validated);

            DB::commit();

            return response()->json([
                "status" => "success",
                "message" => "College updated successfully!",
            ]);

        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("College update failed: " . $e->getMessage());
            return response()->json([
                "status" => "error",
                "message" => "Failed to update college: " . $e->getMessage(),
            ]);
        }
    }

    /**
     * Soft Delete the specified resource from storage.
     */
    public function softDelete(string $id)
    {
        try {
            $college = College::findOrFail($id);
            $college->delete();

            return response()->json([
                "status" => "success",
                "message" => "College deleted successfully!",
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                "status" => "error",
                "message" => "Failed to delete college!",
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    // Handled by softDelete for now to match other controllers
    }
}
