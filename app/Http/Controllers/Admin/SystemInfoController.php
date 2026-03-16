<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SystemInfoRequest;
use App\Models\SystemInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\AdminGeneralDataTableService;

class SystemInfoController extends Controller
{
    protected $module, $base_route, $folder_name, $model;

    public function __construct()
    {
        $this->model = new SystemInfo();
        $this->module = 'SystemInfo';
        $this->base_route = 'admin.system_infos.';
        $this->folder_name = 'system_infos';
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $module = 'SystemInfo';
        $folder_name = 'system_infos';
        $view_path = 'admin.system_infos.';
        $base_route = 'admin.system_infos.';
        $table_id = $folder_name . 'Table';
        $ajax_url = route('admin.system_infos.data');
        $sub_heading = 'Manage ' . $folder_name;

        $columns = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'key', 'name' => 'key'],
            ['data' => 'value', 'name' => 'value'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false],
        ];

        return view('admin.system_infos.index', compact(
            'module', 'folder_name', 'view_path', 'base_route', 'table_id', 'columns', 'ajax_url', 'sub_heading'
        ));
    }

    /*
     * Provide data for DataTable
     * */

    public function data(Request $request)
    {
        $datatable = new AdminGeneralDataTableService(
            SystemInfo::class ,
            'admin.system_infos.',
            'SystemInfo',
        ['name', 'address', 'email', 'phone', 'website', 'created_at'],
            );
        return $datatable->getDataForDataTable($request);
    }

    /*
     * Create a Custom Request and Replace Request for Validation
     * */
    public function store(SystemInfoRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            if ($request->hasFile('file_value')) {
                $data['value'] = $request->file('file_value')->store('system_infos', 'public');
            }

            SystemInfo::create($data);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'System Info added successfully!'
            ]);

        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add SystemInfo!'
            ]);
        }
    }

    /**
     * Returns data of a specified resource for editing.
     */

    public function edit(string $id)
    {
        try {
            $row = SystemInfo::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $row]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'SystemInfo not found!']);
        }
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(SystemInfoRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $item = SystemInfo::findOrFail($id);

            $data = $request->validated();
            if ($request->hasFile('file_value')) {
                if ($item->value && Storage::disk('public')->exists($item->value)) {
                    Storage::disk('public')->delete($item->value);
                }
                $data['value'] = $request->file('file_value')->store('system_infos', 'public');
            }

            $item->update($data);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'SystemInfo updated successfully!'
            ]);
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update SystemInfo!',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function softDelete(string $id)
    {
        try {
            $item = SystemInfo::findOrFail($id);
            $item->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'SystemInfo deleted successfully!'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete SystemInfo!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        try {
            $row = SystemInfo::where('id', $id)->firstOrFail();
            $base_route = $this->base_route;
            return view('admin.system_infos.show', compact('row', 'base_route'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'SystemInfo not found!');
        }
    }

    /**
     * Show system settings page (logo, name, etc.)
     */
    public function settings()
    {
        $settings = SystemInfo::where('status', 1)->pluck('value', 'key')->toArray();
        return view('admin.system_settings.index', compact('settings'));
    }

    /**
     * Save system settings (logo, name, etc.)
     */
    public function saveSettings(Request $request)
    {
        $request->validate([
            'system_name' => 'nullable|string|max:255',
            'system_logo' => 'nullable|image|max:2048',
            'system_title' => 'nullable|string|max:255',
            'system_short_description' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            // Handle logo upload
            if ($request->hasFile('system_logo')) {
                $oldLogo = SystemInfo::where('key', 'system_logo')->first();
                if ($oldLogo && $oldLogo->value && Storage::disk('public')->exists($oldLogo->value)) {
                    Storage::disk('public')->delete($oldLogo->value);
                }
                $path = $request->file('system_logo')->store('system_infos', 'public');
                SystemInfo::updateOrCreate(
                ['key' => 'system_logo'],
                ['value' => $path, 'status' => 1]
                );
            }

            // Save text fields
            $textFields = ['system_name', 'system_title', 'system_short_description'];
            foreach ($textFields as $field) {
                if ($request->filled($field)) {
                    SystemInfo::updateOrCreate(
                    ['key' => $field],
                    ['value' => $request->input($field), 'status' => 1]
                    );
                }
            }

            // Save boolean flags
            $flags = ['maintenance_mode'];
            foreach ($flags as $field) {
                SystemInfo::updateOrCreate(
                    ['key' => $field],
                    ['value' => $request->has($field) ? '1' : '0', 'status' => 1]
                );
            }

            DB::commit();
            return redirect()->route('admin.system_settings.index')->with('success', 'System settings saved successfully!');
        }
        catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to save settings: ' . $e->getMessage());
        }
    }
}
