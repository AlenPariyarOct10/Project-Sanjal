<?php

namespace App\Console\Commands;

use App\Models\University;
use App\Services\AdminGeneralDataTableService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeAdminController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:AdminController {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a module controller with full CRUD methods, validation, DataTable, and file upload';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name'); // e.g., University
        $className = $name . 'Controller';
        $module = $name;
        $snake = Str::snake($name); // HelloWorld -> hello_world
        $folderName = Str::plural($snake);
        $baseRoute = "admin." . $folderName . ".";

        $path = app_path("Http/Controllers/Admin/{$className}.php");

        if (File::exists($path)) {
            $this->error("Controller {$className} already exists!");
            return;
        }

        $stub = $this->getStub($className, $module, $folderName, $baseRoute);

        File::put($path, $stub);

        $this->info("Controller {$className} created successfully!");
    }

    protected function getStub($className, $module, $folderName, $baseRoute)
    {
        return <<<PHP
            <?php

            namespace App\Http\Controllers\Admin;

            use App\Http\Controllers\Controller;
            use App\Models\\$module;
            use Illuminate\Http\Request;
            use Illuminate\Support\Facades\DB;
            use Illuminate\Support\Str;
            use App\Services\AdminGeneralDataTableService;

            class $className extends Controller
            {
                protected \$module, \$base_route, \$folder_name;

                public function __construct()
                {
                    \$this->module = '$module';
                    \$this->base_route = '$baseRoute';
                    \$this->folder_name = '$folderName';
                }

                /**
                 * Display a listing of the resource.
                 */

                public function index()
                {
                    \$module = '$module';
                    \$folder_name = '$folderName';
                    \$view_path = 'admin.$folderName.';
                    \$base_route = '{$baseRoute}';
                    \$table_id = \$folder_name.'Table';
                    \$ajax_url = route('{$baseRoute}data');
                    \$sub_heading = 'Manage '.\$folder_name;

                    \$columns = [
                        ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
                        ['data' => 'name', 'name' => 'name'],
                        ['data' => 'address', 'name' => 'address'],
                        ['data' => 'phone', 'name' => 'phone'],
                        ['data' => 'email', 'name' => 'email'],
                        ['data' => 'created_at', 'name' => 'created_at'],
                        ['data' => 'action', 'name' => 'action', 'orderable' => false],
                    ];

                    return view('admin.$folderName.index', compact(
                        'module','folder_name','view_path','base_route','table_id','columns','ajax_url','sub_heading'
                    ));
                }

                 /*
                 * Provide data for DataTable
                 * */

                public function data(Request \$request)
                {
                    \$datatable = new AdminGeneralDataTableService(
                                        $module::class,
                                        'admin.$folderName.',
                                        '$module',
                                        ['name', 'address', 'email', 'phone', 'website', 'created_at'],
                                    );
                    return \$datatable->getDataForDataTable(\$request);
                }

                /*
                 * Create a Custom Request and Replace Request for Validation
                 * */
                public function store(Request \$request)
                {
                    try {
                        DB::beginTransaction();

                        \$validated = \$request->validate([
                            'name'        => 'required|string|max:255',
                            'description' => 'nullable|string',
                            'address'     => 'nullable|string|max:255',
                            'phone'       => 'nullable|string|max:50',
                            'email'       => 'nullable|email|max:255',
                            'website'     => 'nullable|url|max:255',
                            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                        ]);

                        if (\$request->hasFile('logo')) {
                            \$file = \$request->file('logo');
                            \$filename = time().'_'.\$file->getClientOriginalName();
                            \$file->move(public_path('uploads/$folderName'), \$filename);
                            \$validated['logo'] = 'uploads/$folderName/' . \$filename;
                        }

                        // Slug & Key generation
                        \$baseSlug = Str::slug(\$validated['name']);
                        \$existingCount = $module::where('slug', 'LIKE', \$baseSlug.'%')->count();
                        \$validated['slug'] = \$existingCount > 0 ? \$baseSlug . '-' . (\$existingCount + 1) : \$baseSlug;
                        \$validated['key'] = Str::slug(\$validated['name'], '_') . '_' . uniqid();

                        $module::create(\$validated);

                        DB::commit();

                        return response()->json([
                            'status' => 'success',
                            'message' => '$module added successfully!'
                        ]);

                    } catch (\Exception \$e) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to add $module!'
                        ]);
                    }
                }

                /**
                 * Returns data of a specified resource for editing.
                 */

                public function edit(string \$id)
                {
                    try {
                        \$row = $module::findOrFail(\$id);
                        return response()->json(['status'=>'success','data'=>\$row]);
                    } catch (\Exception \$e) {
                        return response()->json(['status'=>'error','message'=>'$module not found!']);
                    }
                }

                /**
                 * Update the specified resource in storage.
                 */

                public function update(Request \$request, string \$id)
                {
                    try {
                        DB::beginTransaction();

                        \$item = $module::findOrFail(\$id);

                        \$validated = \$request->validate([
                            'name'        => 'required|string|max:255',
                            'description' => 'nullable|string',
                            'address'     => 'nullable|string|max:255',
                            'phone'       => 'nullable|string|max:50',
                            'email'       => 'nullable|email|max:255',
                            'website'     => 'nullable|url|max:255',
                            'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                        ]);

                        if (\$request->hasFile('logo')) {
                            \$file = \$request->file('logo');
                            \$filename = time().'_'.\$file->getClientOriginalName();
                            \$file->move(public_path('uploads/$folderName'), \$filename);
                            \$validated['logo'] = 'uploads/$folderName/' . \$filename;
                        }

                        \$baseSlug = Str::slug(\$validated['name']);
                        \$existingCount = $module::where('slug', 'LIKE', \$baseSlug.'%')->count();
                        \$validated['slug'] = \$existingCount > 0 ? \$baseSlug . '-' . (\$existingCount + 1) : \$baseSlug;

                        \$item->update(\$validated);

                        DB::commit();

                        return response()->json([
                            'status' => 'success',
                            'message' => '$module updated successfully!'
                        ]);
                    } catch (\Exception \$e) {
                        DB::rollBack();
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to update $module!'
                        ]);
                    }
                }

                /**
                 * Remove the specified resource from storage.
                 */

                public function softDelete(string \$id)
                {
                    try {
                        \$item = $module::findOrFail(\$id);
                        \$item->delete();

                        return response()->json([
                            'status' => 'success',
                            'message' => '$module deleted successfully!'
                        ]);
                    } catch (\Exception \$e) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Failed to delete $module!'
                        ]);
                    }
                }

                /**
                 * Display the specified resource.
                 */

                public function show(string \$slug)
                {
                    try {
                        \$row = $module::where('slug', \$slug)->firstOrFail();
                        \$base_route = \$this->base_route;
                        return view('admin.$folderName.show', compact('row','base_route'));
                    } catch (\Exception \$e) {
                        return back()->with('error', '$module not found!');
                    }
                }
            }
        PHP;
    }
}



