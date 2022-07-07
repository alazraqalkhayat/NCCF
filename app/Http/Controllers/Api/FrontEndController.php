<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Content\ActivityController;
use App\Http\Controllers\Dashboard\TypesController;
use App\Http\Controllers\Utility\QueryController;
use App\Models\Analysis;
use App\Models\Detection;
use App\Models\DetectionType;
use App\Models\Dose;
use App\Models\PatientFrinds;
use App\Models\PsychologicalAid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{

    public function getDetectionType(Request $request): JsonResponse
    {
        return response()->json(TypesController::getTypes(DetectionType::query()));
    }

    public function detectionDetails(Request $request): JsonResponse
    {

        $user = $request->user();
        $detectionType = $request->get('type');

        $detection = $user->detection()->where('type','=',$detectionType);

        return response()->json(QueryController::getADDData($detection));
    }

    public function detectionCansel(Request $request, Detection $detection): JsonResponse
    {
        return self::cansel($detection, $request);
    }

    public function getAnalysis(Request $request): JsonResponse
    {
        return response()->json(QueryController::getADDData(Analysis::query(), userId: $request->user()->id));
    }

    public function getDose(Request $request): JsonResponse
    {
        return response()->json(QueryController::getADDData(Dose::query(), userId: $request->user()->id));
    }

    public function analysisCansel(Request $request, Analysis $analysis): JsonResponse
    {
        return self::cansel($analysis, $request);
    }

    public function doseCansel(Request $request, Dose $dose): JsonResponse
    {
        return self::cansel($dose, $request);
    }

    public function addPsychologicalAid(Request $request): JsonResponse
    {
        $addPsychologicalAid = PsychologicalAid::query()->create([
            'problem' => $request->get('problem')
        ]);

        return response()->json($addPsychologicalAid);
    }

    public function addPatientFriends(Request $request): JsonResponse
    {
        $patientFriends = PatientFrinds::query()->create([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'membership' => $request->get('membership'),
        ]);

        return response()->json($patientFriends);
    }

    public function eventsActivities(Request $request): JsonResponse
    {
        $data = ActivityController::getActivity();
        $data->map(function ($v) {
            if (str_contains($v->path, 'image'))
                $v['mediaType'] = 'image';
            else
                $v['mediaType'] = 'video';

            return $v;
        });

        return response()->json($data);
    }

    public static function cansel($data, $request): JsonResponse
    {
        $cancel = QueryController::status('cancel');
        if ($cancel) {
            $data->reason()->create([
                'reason' => $request->get('reason'),
                'status' => $cancel->value('id')
            ]);
            $data->update(['status' => $cancel->value('id')]);
        }

        return response()->json('تم الالغاء بنجاح.');
    }
}
