<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\College;
use App\Services\AdminGeneralDataTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $module, $base_route, $folder_name;

    public function __construct()
    {
        $this->module = 'User';
        $this->base_route = 'admin.users.';
        $this->folder_name = 'users';
    }

    public function index()
    {
        $module = $this->module;
        $folder_name = $this->folder_name;
        $view_path = 'admin.users.';
        $base_route = $this->base_route;
        $table_id = $folder_name . 'Table';
        $ajax_url = route('admin.users.data');
        $sub_heading = 'Manage Users';

        $columns = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'email', 'name' => 'email'],
            ['data' => 'role_id', 'name' => 'role_id'],
            ['data' => 'college_id', 'name' => 'college_id'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false],
        ];

        $roles = Role::where('status', 1)->get();
        $colleges = College::where('status', 1)->get();

        return view('admin.users.index', compact(
            'module', 'folder_name', 'view_path', 'base_route', 'table_id', 'columns', 'ajax_url', 'sub_heading', 'roles', 'colleges'
        ));
    }

    public function data(Request $request)
    {
        $query = User::with(['role', 'college']);

        // Handle search
        if ($request->filled('search_value')) {
            $search = $request->search_value;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('role', function ($rq) use ($search) {
                    $rq->where('title', 'like', "%{$search}%");
                }
                );
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('role_id', function ($row) {
            return $row->role ? $row->role->title : '-';
        })
            ->editColumn('college_id', function ($row) {
            return $row->college ? $row->college->name : '-';
        })
            ->editColumn('created_at', function ($row) {
            return $row->created_at ? $row->created_at->format('M d, Y') : '-';
        })
            ->editColumn('status', function ($row) {
            return $row->status ? 'Active' : 'Inactive';
        })
            ->addColumn('action', function ($row) {
            return $this->renderActions($row);
        })
            ->rawColumns(['action'])
            ->make(true);
    }

    protected function renderActions($row)
    {
        $group = '<div class="flex gap-2">';
        $group .= '<button data-id="' . $row->id . '" class="editBtn px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition" title="Edit User"><i class="fas fa-edit"></i></button>';
        $group .= '<button data-id="' . $row->id . '" class="deleteBtn px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition" title="Delete User"><i class="fa fa-trash"></i></button>';
        $group .= '</div>';
        return $group;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'role_id' => 'required|exists:roles,id',
                'college_id' => 'nullable|exists:colleges,id',
                'status' => 'required|boolean',
            ]);

            $validated['password'] = Hash::make($validated['password']);

            User::create($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'User added successfully!'
            ]);
        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("User addition failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add user: ' . $e->getMessage()
            ]);
        }
    }

    public function edit(string $id)
    {
        try {
            $row = User::findOrFail($id);
            return response()->json(['status' => 'success', 'data' => $row]);
        }
        catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'User not found!']);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $item = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:8',
                'role_id' => 'required|exists:roles,id',
                'college_id' => 'nullable|exists:colleges,id',
                'status' => 'required|boolean',
            ]);

            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            }
            else {
                unset($validated['password']);
            }

            $item->update($validated);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully!'
            ]);
        }
        catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        }
        catch (\Exception $e) {
            DB::rollBack();
            Log::error("User update failed: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update user: ' . $e->getMessage()
            ]);
        }
    }

    public function softDelete(string $id)
    {
        try {
            $item = User::findOrFail($id);
            $item->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully!'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete user!'
            ]);
        }
    }
}
