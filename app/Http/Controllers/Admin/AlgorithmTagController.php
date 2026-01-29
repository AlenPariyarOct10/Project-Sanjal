    <?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Models\AlgorithmTag;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;
    use App\Services\AdminGeneralDataTableService;

    class AlgorithmTagController extends Controller
    {
        protected $module, $base_route, $folder_name;

        public function __construct()
        {
            $this->module = 'AlgorithmTag';
            $this->base_route = 'admin.algorithm_tags.';
            $this->folder_name = 'algorithm_tags';
        }

        /**
         * Display a listing of the resource.
         */

        public function index()
        {
            $module = 'AlgorithmTag';
            $folder_name = 'algorithm_tags';
            $view_path = 'admin.algorithm_tags.';
            $base_route = 'admin.algorithm_tags.';
            $table_id = $folder_name.'Table';
            $ajax_url = route('admin.algorithm_tags.data');
            $sub_heading = 'Manage '.$folder_name;

            $columns = [
                ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
                ['data' => 'name', 'name' => 'name'],
                ['data' => 'address', 'name' => 'address'],
                ['data' => 'phone', 'name' => 'phone'],
                ['data' => 'email', 'name' => 'email'],
                ['data' => 'created_at', 'name' => 'created_at'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false],
            ];

            return view('admin.algorithm_tags.index', compact(
                'module','folder_name','view_path','base_route','table_id','columns','ajax_url','sub_heading'
            ));
        }

         /*
         * Provide data for DataTable
         * */

        public function data(Request $request)
        {
            $datatable = new AdminGeneralDataTableService(
                                AlgorithmTag::class,
                                'admin.algorithm_tags.',
                                'AlgorithmTag',
                                ['name', 'address', 'email', 'phone', 'website', 'created_at'],
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
                    'name'        => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'address'     => 'nullable|string|max:255',
                    'phone'       => 'nullable|string|max:50',
                    'email'       => 'nullable|email|max:255',
                    'website'     => 'nullable|url|max:255',
                    'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                ]);

                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $filename = time().'_'.$file->getClientOriginalName();
                    $file->move(public_path('uploads/algorithm_tags'), $filename);
                    $validated['logo'] = 'uploads/algorithm_tags/' . $filename;
                }

                // Slug & Key generation
                $baseSlug = Str::slug($validated['name']);
                $existingCount = AlgorithmTag::where('slug', 'LIKE', $baseSlug.'%')->count();
                $validated['slug'] = $existingCount > 0 ? $baseSlug . '-' . ($existingCount + 1) : $baseSlug;
                $validated['key'] = Str::slug($validated['name'], '_') . '_' . uniqid();

                AlgorithmTag::create($validated);

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'AlgorithmTag added successfully!'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to add AlgorithmTag!'
                ]);
            }
        }

        /**
         * Returns data of a specified resource for editing.
         */

        public function edit(string $id)
        {
            try {
                $row = AlgorithmTag::findOrFail($id);
                return response()->json(['status'=>'success','data'=>$row]);
            } catch (\Exception $e) {
                return response()->json(['status'=>'error','message'=>'AlgorithmTag not found!']);
            }
        }

        /**
         * Update the specified resource in storage.
         */

        public function update(Request $request, string $id)
        {
            try {
                DB::beginTransaction();

                $item = AlgorithmTag::findOrFail($id);

                $validated = $request->validate([
                    'name'        => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'address'     => 'nullable|string|max:255',
                    'phone'       => 'nullable|string|max:50',
                    'email'       => 'nullable|email|max:255',
                    'website'     => 'nullable|url|max:255',
                    'logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                ]);

                if ($request->hasFile('logo')) {
                    $file = $request->file('logo');
                    $filename = time().'_'.$file->getClientOriginalName();
                    $file->move(public_path('uploads/algorithm_tags'), $filename);
                    $validated['logo'] = 'uploads/algorithm_tags/' . $filename;
                }

                $baseSlug = Str::slug($validated['name']);
                $existingCount = AlgorithmTag::where('slug', 'LIKE', $baseSlug.'%')->count();
                $validated['slug'] = $existingCount > 0 ? $baseSlug . '-' . ($existingCount + 1) : $baseSlug;

                $item->update($validated);

                DB::commit();

                return response()->json([
                    'status' => 'success',
                    'message' => 'AlgorithmTag updated successfully!'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update AlgorithmTag!'
                ]);
            }
        }

        /**
         * Remove the specified resource from storage.
         */

        public function softDelete(string $id)
        {
            try {
                $item = AlgorithmTag::findOrFail($id);
                $item->delete();

                return response()->json([
                    'status' => 'success',
                    'message' => 'AlgorithmTag deleted successfully!'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to delete AlgorithmTag!'
                ]);
            }
        }

        /**
         * Display the specified resource.
         */

        public function show(string $slug)
        {
            try {
                $row = AlgorithmTag::where('slug', $slug)->firstOrFail();
                $base_route = $this->base_route;
                return view('admin.algorithm_tags.show', compact('row','base_route'));
            } catch (\Exception $e) {
                return back()->with('error', 'AlgorithmTag not found!');
            }
        }
    }