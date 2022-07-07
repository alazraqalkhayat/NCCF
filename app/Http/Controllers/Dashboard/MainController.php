<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Content\ActivityController;
use App\Http\Controllers\Dashboard\Content\AppInfoController;
use App\Http\Controllers\Dashboard\Reports\PatientFreindsController;
use App\Http\Controllers\Dashboard\Reports\PsychologicalAidsController;
use App\Http\Controllers\Dashboard\Users\PermissionController;
use App\Http\Controllers\Dashboard\Users\RoleController;
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
use JetBrains\PhpStorm\ArrayShape;

class MainController extends Controller
{
    public function getRecords(Request $request): JsonResponse
    {
        $type = $request->get('type');
        $name = $request->get('name') == '' ? null : $request->get('name');

        $data = match ($type) {
            'ACTIVITIES'  => [
                'data' => ActivityController::getActivity($name),
                'roles' => [],
            ],

            // ADD
            'ANALYSIS', 'CONTENT' => self::getADDRecords(Analysis::query(), AnalysisType::query(), $name),
            'DOSE' => self::getADDRecords(Dose::query(), DoseType::query(), $name),
            'DETECTION' => self::getADDRecords(Detection::query(), DetectionType::query(), $name),

            'APP_INFO' => [
                'data' => AppInfoController::getAppIngo(),
                'roles' => [],
            ],

            'DOSE_TYPE' => [
                'data' => TypesController::getTypes(DoseType::query(), $name),
                'roles' => [],
            ],

            'DEDICATION_TYPE' => [
                'data' => TypesController::getTypes(DetectionType::query(), $name),
                'roles' => [],
            ],
            'ANALYSIS_TYPE', 'TYPES' => [
                'data' => TypesController::getTypes(AnalysisType::query(), $name),
                'roles' => [],
            ],
            'PSYCHOLOGICAL_AID' ,'REPORTS' => [
                'data' => PsychologicalAidsController::getPsychologicalAids($name),
                'roles' => [],
            ],
            'PATIENT_FRIENDS' => [
                'data' => PatientFreindsController::getPatientsFriends($name),
                'roles' => [],
            ],

            // users
            'USER','USERS' => [
                'data' => UsersController::getUsers($name),
                'roles' => RoleController::getRole(),
            ],
            'ROLE' => [
                'data' => RoleController::getRole(name: $name),
                'roles' => PermissionController::getPermission(),
            ],
            'PERMISSION' => [
                'data' => PermissionController::getPermission($name),
                'roles' => RoleController::getRole(),
            ],

            default => [
                'data' => [],
                'roles' => [],
            ]
        };

        return response()->json($data);
    }

    #[ArrayShape(['data' => "mixed", 'roles' => "array"])] public static function getADDRecords($query, $type, $date = null): array
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

    public static function getTypesRecords($query, $type, $name)
    {
        return match ($type) {
            'DOSE' => response()->json([
                'data' => TypesController::getTypes(DoseType::query(), $name),
            ]),
            'DEDICATION' => response()->json([
                'data' => TypesController::getTypes(DetectionType::query(), $name),
            ]),
            default => response()->json([
                'data' => TypesController::getTypes(AnalysisType::query(), $name),
            ]),
        };
    }

}
