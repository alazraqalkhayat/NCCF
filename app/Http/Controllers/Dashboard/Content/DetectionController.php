<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Models\Detection;
use Illuminate\Http\Request;

class DetectionController extends Controller
{
    public static function getDetection($date = null, $id = null)
    {
        return Detection::with('status:id,status,reson')
            ->when($date, fn ($query, $date) => $query->whereDate('date', '=', $date))
            ->when($id, fn ($query, $id) => $query->where('id', $id))
            ->get(['id', 'date', 'type', 'patient'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'type' => $item->type()->first()?->name,
                    'patient' => $item->patient()->first()?->name,
                ];
            });
    }

    // detection.store
    public function store(Request $request)
    {
        $detection = Detection::query()->create(self::setValidate($request));

        return response()->json(self::getDetection(null, $detection->id));
    }

    // detection.update
    public function update(Request $request, Detection $detection)
    {
        $detection->update(self::setValidate($request));

        return response()->json(self::getDetection(null, $detection->id));
    }

    // detection.destroy
    public function delete(Detection $detection)
    {
        $detection->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public static function setValidate($request)
    {
        return $request->validate([
            'type' => 'required|exists:detection_types,id',
            'patient' => 'required|exists:users,id',
            'date' => 'required|date',
        ]);
    }
}
