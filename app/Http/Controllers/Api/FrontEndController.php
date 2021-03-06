<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Content\ActivityController;
use App\Http\Controllers\Dashboard\Content\ADDController;
use App\Http\Controllers\Dashboard\ContentController;
use App\Http\Controllers\Dashboard\TypesController;
use App\Http\Controllers\Utility\QueryController;
use App\Models\Analysis;
use App\Models\AppInfo;
use App\Models\Detection;
use App\Models\DetectionType;
use App\Models\Dose;
use App\Models\PatientFrinds;
use App\Models\PsychologicalAid;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{

    public function getDetectionType(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(TypesController::getTypes(DetectionType::query()));
    }

    public function detectionDetails(Request $request): \Illuminate\Http\JsonResponse
    {

        $user = $request->user();
        $detectionType = $request->get('typeId');

        $detection = $user->detection()->where('type','=',$detectionType);

        return response()->json(QueryController::getADDData($detection));
    }

    public function detectionCansel(Request $request)
    {
        $detection = Detection::findOrFail(intval($request->id));
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
        $analysis = Analysis::find($request->id);
        return self::cansel($analysis, $request);
    }

    public function doseCansel(Request $request)
    {
        $dose = Dose::find($request->id);
        return self::cansel($dose, $request);
    }

    public function addPsyologicalAid(Request $request)
    {
        $addPsyologicalAid = $request->user()->psychologicalAid()->create([
            'problem' => $request->problem,
        ]);

        return response()->json('?????? ?????????????? ??????????');
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
                
                return $v;
        });

        return response()->json($data);
    }

    public static function cansel($data, $request)
    {
        // $cancel = QueryController::status('CANCEL');
        // if ($cancel) {
            $data->reason()->create([
                'reason' => $request->reason,
                'status' => 2
            ]);

            $data->update(['status' => 2]);
        // }

        return response()->json('???? ?????????????? ??????????.');
    }

    public function aboutUs()
    {
        $info=AppInfo::all();
        return response()->json($info);
    }
}
