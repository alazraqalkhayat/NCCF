<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Reports\PatientFreindsController;
use App\Http\Controllers\Dashboard\Reports\PsychologicalAidsController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class ReportsController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('Dashboard/reports', [
            'getData' => PsychologicalAidsController::getPsychologicalAids()
        ]);
    }

    public function getRecords(Request $request): JsonResponse
    {
        $type = $request->get('type');
        $name = $request->get('name') == '' ? null : $request->get('name');

        $data = match ($type) {
            'الدعم النفسي' => [
                'data' => PsychologicalAidsController::getPsychologicalAids($name),
            ],
            'اصدقاء مرضى السرطان' => [
                'data' => PatientFreindsController::getPatientsFriends($name),
            ],
        };
        return response()->json($data);
    }
}
