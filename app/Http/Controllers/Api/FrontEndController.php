<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Content\ActivityController;
use App\Http\Controllers\Utility\QueryController;
use App\Models\Analysis;
use App\Models\Detection;
use App\Models\Dose;
use App\Models\PatientFrinds;
use App\Models\PsychologicalAid;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{

    public function getDetectionType(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(Detection::all(['id', 'name']));
    }

    public function detectionDetails(Request $request, Detection $detection)
    {
        return response()->json([
            'date' => $detection->date,
            'patient' => $detection->patiant()->first()->name,
            'status' => $detection->status()->first()->status
        ]);
    }

    public function detectionCansel(Request $request, Detection $detection)
    {
        return self::cansel($detection, $request);
    }

    public function getAnalysis(Request $request)
    {
        return response()->json(QueryController::getADDData(Analysis::query(), userId: $request->user()->id));
    }

    public function getDose(Request $request)
    {
        return response()->json(QueryController::getADDData(Dose::query(), userId: $request->user()->id));
    }

    public function analysisCansel(Request $request, Analysis $analysis)
    {
        return self::cansel($analysis, $request);
    }

    public function doseCansel(Request $request, Dose $dose)
    {
        return self::cansel($dose, $request);
    }

    public function addPsyologicalAid(Request $request)
    {
        $addPsyologicalAid = PsychologicalAid::query()->create([
            'problem' => $request->problem
        ]);

        return response()->json($addPsyologicalAid);
    }

    public function addPatientFrinds(Request $request)
    {
        $patientFrinds = PatientFrinds::query()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'membership' => $request->membership,
        ]);

        return response()->json($patientFrinds);
    }

    public function eventsActivities(Request $request)
    {
        $data = ActivityController::getActivity();
        $data->map(function ($v) {
            if (str_contains($v->path, 'image'))
                $v['mediaType'] = 'image';
            else
                $v['mediaType'] = 'video';
        });

        return response()->json($data);
    }

    public static function cansel($data, $request)
    {
        $cancel = QueryController::status('cancel');
        if ($cancel) {
            $data->reason()->create([
                'reason' => $request->reason,
                'status' => $cancel->id
            ]);
            $data->update(['status' => $cancel->id]);
        }

        return response()->json('تم الالغاء بنجاح.');
    }
}
