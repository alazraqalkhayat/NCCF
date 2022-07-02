<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Content\ActivityController;
use App\Http\Controllers\Dashboard\Content\AnalysisController;
use App\Http\Controllers\Dashboard\Content\DetectionController;
use App\Http\Controllers\Dashboard\Content\DoseController;
use App\Models\AnalysisType;
use App\Models\DetectionType;
use App\Models\DoseType;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class ContentController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('Dashboard/content', [
            'getData' => AnalysisController::getAnalysis(),
            'roles' => [
                'type' => AnalysisType::all(['id', 'name']),
                'patient' => User::query()->whereRelation('roles', 'name', '=', 'المرضى')->get(['id', 'name'])
            ],
        ]);
    }

    public function getRecords(Request $request): JsonResponse
    {
        $title = $request->get('type');
        $name = $request->get('name') == '' ? null : $request->get('name');
        if ($title == 'analysis')
            return response()->json([
                'data' => AnalysisController::getAnalysis($name),
                'roles' => [
                    'type' => AnalysisType::all(['id', 'name']),
                    'patient' => User::query()->whereRelation('roles', 'name', '=', 'المرضى')->get(['id', 'name'])
                ],
            ]);
        else if ($title == 'detection')
            return response()->json([
                'data' => DetectionController::getDetection($name),
                'roles' => [
                    'type' => DetectionType::all(['id', 'name']),
                    'patient' => User::query()->whereRelation('roles', 'name', '=', 'المرضى')->get(['id', 'name'])
                ],
            ]);
        else if ($title == 'dose')
            return response()->json([
                'data' => DoseController::getDose($name),
                'roles' => [
                    'type' => DoseType::all(['id', 'name']),
                    'patient' => User::query()->whereRelation('roles', 'name', '=', 'المرضى')->get(['id', 'name'])
                ],
            ]);
        else if ($title == 'activity')
            return response()->json([
                'data' => ActivityController::getActivity($name),
                'roles' => [],
            ]);
        else
            return response()->json([
                'data' => [],
                'roles' => [],
            ]);
    }
}
