<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Content\ActivityController;
use App\Http\Controllers\Dashboard\Content\AnalysisController;
use App\Http\Controllers\Dashboard\Content\DoseController;
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
        return response()->json(AnalysisController::getAnalysis(userId: $request->user()->id));
    }

    public function getDose(Request $request)
    {
        return response()->json(DoseController::getDose(userId: $request->user()->id));
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
        return response()->json(ActivityController::getActivity());
    }

    public static function cansel($data, $request)
    {
        $cansol = $data->status()->update([
            'status' => 'CANSEL',
        ]);
        if ($cansol)
            $data->reson()->create([
                'reson' => $request->reson
            ]);

        return response()->json('تم الالغاء بنجاح.');
    }
}
