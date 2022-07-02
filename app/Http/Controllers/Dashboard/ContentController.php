<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Content\ActivityController;
use App\Http\Controllers\Dashboard\Content\AnalysisController;
use App\Http\Controllers\Dashboard\Content\AppInfoController;
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

        $data = match ($title) {
            'الانشطة والفعاليات' => [
                'data' => ActivityController::getActivity($name),
                'roles' => [],
            ],
            'التحاليل' => [
                'data' => AnalysisController::getAnalysis($name),
                'roles' => [
                    'type' => AnalysisType::all(['id', 'name']),
                    'patient' => User::query()->whereRelation('roles', 'name', '=', 'المرضى')->get(['id', 'name'])
                ],
            ],
            'الجرعات' => [
                'data' => DoseController::getDose($name),
                'roles' => [
                    'type' => DoseType::all(['id', 'name']),
                    'patient' => User::query()->whereRelation('roles', 'name', '=', 'المرضى')->get(['id', 'name'])
                ],
            ],
            'الكشف المبكر' => [
                'data' => DetectionController::getDetection($name),
                'roles' => [
                    'type' => DetectionType::all(['id', 'name']),
                    'patient' => User::query()->whereRelation('roles', 'name', '=', 'المرضى')->get(['id', 'name'])
                ],
            ],
            'معلومات التطبيق' => [
                'data' => AppInfoController::getAppIngo(),
                'roles' => [],
            ],
            default => [
                'data' => [],
                'roles' => [],
            ]
        };

        return response()->json($data);
    }
}
