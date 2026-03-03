<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\AdminGeneralDataTableService;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    protected $module, $base_route, $folder_name;

    public function __construct()
    {
        $this->module = 'Role';
        $this->base_route = 'admin.roles.';
        $this->folder_name = 'roles';
    }

    public function index()
    {
        $module = $this->module;
        $folder_name = $this->folder_name;
        $view_path = 'admin.roles.';
        $base_route = $this->base_route;
        $table_id = $folder_name . 'Table';
        $ajax_url = route('admin.roles.data');
        $sub_heading = 'Manage ' . $folder_name;

        $columns = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'title', 'name' => 'title'],
            ['data' => 'slug', 'name' => 'slug'],
            ['data' => 'key', 'name' => 'key'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false],
        ];

        return view('admin.roles.index', compact(
            'module', 'folder_name', 'view_path', 'base_route', 'table_id', 'columns', 'ajax_url', 'sub_heading'
        ));
    }

    public function data(Request $request)
    {
        $datatable = new AdminGeneralDataTableService(
            Role::class ,
            $this->base_route,
            $this->module,
        ['title', 'slug', 'key'],
            );
        return $datatable->getDataForDataTable($request);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string|max:255|unique:roles,title',
                'status' => 'required|boolean',
            ]);

            $validated['slug'] = Str::slug($validated['title'], '-');
            $validated['key'] = Str::slug($validated['title'], '_');

            Role::create($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Role added successfully!'
            ]);

        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Role addition failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add Role: ' . $e->getMessage()
            ]);
        }
    }

    public function edit(string $id)
    {
        try {
            $row = Role::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $row]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Role not found!']);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $item = Role::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255|unique:roles,title,' . $id,
                'status' => 'required|boolean',
            ]);

            $validated['slug'] = Str::slug($validated['title'], '-');
            $validated['key'] = Str::slug($validated['title'], '_');

            $item->update($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Role updated successfully!'
            ]);
        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("Role update failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Role: ' . $e->getMessage()
            ]);
        }
    }

    public function softDelete(string $id)
    {
        try {
            $item = Role::findOrFail($id);
            $item->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Role deleted successfully!'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Role!'
            ]);
        }
    }
}
