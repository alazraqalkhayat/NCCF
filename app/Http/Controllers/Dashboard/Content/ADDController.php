<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utility\QueryController;
use App\Models\Analysis;
use App\Models\Detection;
use App\Models\Dose;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ADDController extends Controller
{
    // analysis.store
    public function store(Request $request, $type): JsonResponse
    {
        $status = QueryController::status('wait');

        $query = self::getQuery($type);

        $data = self::setValidate($request) + ['status' => $status->id];

        $analysis = $query->create($data);

        return response()->json(QueryController::getADDData($query, id: $analysis->id));
    }

    // analysis.update
    public function update(Request $request, $id, $type): JsonResponse
    {
        $data = self::setValidate($request);

        $query = self::getQuery($type);

        $model = $query->findOrFail($id);

        $model->update($data);

        $reason = $request->get('reason');
        if ($reason)
            $model->reason()->create(['reason' => $reason, 'status' => $data['status']]);

        return response()->json(QueryController::getADDData($query, id: $model->id));
    }

    // analysis.destroy
    public function delete($id, $type): JsonResponse
    {

        $query = self::getQuery($type)->findOrFail($id);

        $query->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public static function setValidate($request): array
    {
        $rules = [
            'type' => 'required',
            'patient' => 'required|exists:users,id',
            'date' => 'required|date',
        ];
        if ($request->has('status'))
            $rules['status'] = ['required'];

        return $request->validate($rules);
    }

    public static function getQuery($type = null): Builder
    {
        return match ($type) {
            'ANALYSIS' => Analysis::query(),
            'DOSE' => Dose::query(),
            default => Detection::query()
        };
    }
}
