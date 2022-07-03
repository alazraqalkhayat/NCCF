<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Content\ActivityController;
use App\Http\Controllers\Dashboard\Content\AnalysisController;
use App\Http\Controllers\Dashboard\Content\AppInfoController;
use App\Http\Controllers\Dashboard\Content\DetectionController;
use App\Http\Controllers\Dashboard\Content\DoseController;
use App\Http\Controllers\Utility\QueryController;
use App\Models\Analysis;
use App\Models\AnalysisType;
use App\Models\Detection;
use App\Models\DetectionType;
use App\Models\Dose;
use App\Models\DoseType;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use JetBrains\PhpStorm\ArrayShape;

class ContentController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('Dashboard/content', self::getADDRecords(Analysis::query(), AnalysisType::query()));
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

            // ADD
            'التحاليل' => self::getADDRecords(Analysis::query(), AnalysisType::query(), $name),
            'الجرعات' => self::getADDRecords(Dose::query(), DoseType::query(), $name),
            'الكشف المبكر' => self::getADDRecords(Detection::query(), DetectionType::query(), $name),

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

    #[ArrayShape(['data' => "mixed", 'roles' => "array"])] public static function getADDRecords($query, $type, $date = null)
    {
        return [
            'data' => QueryController::getADDData($query, date: $date),
            'roles' => [
                'type' => $type->get(['id', 'name']),
                'status' => Status::all(['id', 'status']),
                'patient' => User::query()->whereRelation('roles', 'name', '=', 'المرضى')->get(['id', 'name'])
            ],
        ];
    }
}
