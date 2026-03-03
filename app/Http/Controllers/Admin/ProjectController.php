<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class ProjectController extends Controller
{
    protected $module, $base_route, $folder_name;

    public function __construct()
    {
        $this->module = 'Project';
        $this->base_route = 'admin.projects.';
        $this->folder_name = 'projects';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module = $this->module;
        $folder_name = $this->folder_name;
        $base_route = $this->base_route;
        $table_id = $folder_name . 'Table';
        $ajax_url = route('admin.projects.data');
        $sub_heading = 'Manage Projects';

        $columns = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'created_by', 'name' => 'created_by'],
            ['data' => 'course_id', 'name' => 'course_id'],
            ['data' => 'subject_id', 'name' => 'subject_id'],
            ['data' => 'status', 'name' => 'status'],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false],
        ];

        $courses = Course::where('status', 1)->get();
        $subjects = Subject::all();
        $tags = Tag::where('status', 1)->get();

        return view('admin.projects.index', compact(
            'module', 'folder_name', 'base_route', 'table_id', 'columns',
            'ajax_url', 'sub_heading', 'courses', 'subjects', 'tags'
        ));
    }

    /**
     * DataTable data endpoint.
     */
    public function getDataForIndex(Request $request)
    {
        $query = Project::with(['user', 'course', 'subject']);

        // Handle search
        if ($request->filled('search_value')) {
            $search = $request->search_value;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%");
                }
                )
                    ->orWhereHas('course', function ($cq) use ($search) {
                    $cq->where('name', 'like', "%{$search}%");
                }
                );
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_by', function ($row) {
            return $row->user ? $row->user->name : '-';
        })
            ->editColumn('course_id', function ($row) {
            return $row->course ? $row->course->name : '-';
        })
            ->editColumn('subject_id', function ($row) {
            return $row->subject ? $row->subject->name : '-';
        })
            ->editColumn('status', function ($row) {
            return $row->status ? 'Active' : 'Draft';
        })
            ->editColumn('created_at', function ($row) {
            return $row->created_at ? $row->created_at->format('M d, Y') : '-';
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
        $group .= '<a href="' . route('admin.projects.show', $row->id) . '" class="px-3 py-1 bg-white text-black border border-black rounded-sm hover:bg-black btn hover:text-white transition" title="View Project"><i class="fa fa-eye"></i></a>';
        $group .= '</div>';
        return $group;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $project = Project::with(['user', 'course', 'subject', 'tags', 'files', 'comments.user'])->findOrFail($id);
            $base_route = $this->base_route;
            return view('admin.projects.show', compact('project', 'base_route'));
        }
        catch (\Exception $e) {
            return back()->with('error', 'Project not found!');
        }
    }
}
