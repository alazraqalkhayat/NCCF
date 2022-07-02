<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AnalysisType;
use App\Models\DetectionType;
use App\Models\DoseType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class TypesController extends Controller
{
    /**
     * @return Response|ResponseFactory
     */
    public function index(): Response|ResponseFactory
    {
        return inertia('Dashboard/types', [
            'getData' => $this->getTypes(AnalysisType::query())
        ]);
    }

    public function getTypes($class, $name = null, $id = null)
    {
        return $class->when($name, fn($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->when($id, fn($query, $id) => $query->where('id', '=', $id))
            ->get(['id', 'name']);
    }

    public function getRecords(Request $request): JsonResponse
    {
        $type = $request->get('type');
        $name = $request->get('name') == '' ? null : $request->get('name');
        return match ($type) {
            'DOSE' => response()->json([
                'data' => $this->getTypes(DoseType::query(), $name),
            ]),
            'DEDICATION' => response()->json([
                'data' => $this->getTypes(DetectionType::query(), $name),
            ]),
            default => response()->json([
                'data' => $this->getTypes(AnalysisType::query(), $name),
            ]),
        };

    }

    public function update(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $query = match ($request->get('type')) {
            'DOSE' => DoseType::query(),
            'DEDICATION' => DetectionType::query(),
            default => AnalysisType::query(),
        };

        $query->findOrFail($id)->update($data);

        return response()->json([
            'data' => $this->getTypes($query, id: $query->findOrFail($id)->value('id'))
        ]);
    }

//    store
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);

        $query = match ($request->get('type')) {
            'DOSE' => DoseType::query(),
            'DEDICATION' => DetectionType::query(),
            default => AnalysisType::query(),
        };

        $store = $query->create($data);
        return response()->json([
            'data' => $this->getTypes($query, id: $store->id)
        ]);
    }

//    delete
    public function delete(Request $request,$id): JsonResponse
    {
        $query = match ($request->get('type')) {
            'DOSE' => DoseType::query(),
            'DEDICATION' => DetectionType::query(),
            default => AnalysisType::query(),
        };

        $query->findOrFail($id)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
