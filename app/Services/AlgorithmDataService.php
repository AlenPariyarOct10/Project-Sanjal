<?php

namespace App\Services;

use App\Models\Algorithm;
use Yajra\DataTables\DataTables;

class AlgorithmDataService
{
    public function getData($request)
    {
        $perPage = 10; // Adjust as needed
        $page = $request->input('page', 1);

        $query = Algorithm::query();

        if ($request->search) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }

        // Manual pagination
        $total = $query->count();
        $results = $query
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        return response()->json([
            'data' => $results->map(function ($row) {
                return [
                    'card' => [
                        'id' => $row->id,
                        'name' => $row->name,
                        'category' => $row->category ?? 'N/A',
                        'description' => $row->description ?? '',
                        'complexity' => $row->complexity ?? '',
                    ]
                ];
            }),
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'total' => $total
        ]);
    }
}
