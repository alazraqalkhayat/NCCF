<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Models\Analysis;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public static function getAnalysis($date = null, $id = null, $userId = null)
    {
        return Analysis::query()
            ->when($date, fn ($query, $date) => $query->whereDate('date', '=', $date))
            ->when($id, fn ($query, $id) => $query->where('id', $id))
            ->when($userId, fn ($query, $userId) => $query->whereRelation('patient', 'id', '=', $userId))
            ->get(['id', 'date', 'type', 'patient'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'type' => $item->type()->first()?->name,
                    'patient' => $item->patient()->first()?->name,
                    'status' => $item->status()->first()?->staus,
                ];
            });
    }

    // analysis.store
    public function store(Request $request)
    {
        $analysis = Analysis::query()->create(self::setValidate($request));

        return response()->json(self::getAnalysis(null, $analysis->id));
    }

    // analysis.update
    public function update(Request $request, Analysis $analysis)
    {
        $analysis->update(self::setValidate($request));

        return response()->json(self::getAnalysis(null, $analysis->id));
    }

    // analysis.destroy
    public function delete(Analysis $analysis)
    {
        $analysis->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public static function setValidate($request)
    {
        return $request->validate([
            'type' => 'required|exists:analysis_types,id',
            'patient' => 'required|exists:users,id',
            'date' => 'required|date',
        ]);
    }
}
