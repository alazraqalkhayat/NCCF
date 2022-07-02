<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Models\Dose;
use Illuminate\Http\Request;

class DoseController extends Controller
{
    public static function getDose($date = null, $id = null, $userId = null)
    {
        return Dose::query()
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
                    'status' => $item->status()->first()?->name,
                ];
            });
    }

    // dose.store
    public function store(Request $request)
    {
        $dose = Dose::query()->create(self::setValidate($request));

        return response()->json(self::getDose(null, $dose->id));
    }

    // dose.update
    public function update(Request $request, Dose $dose)
    {
        $dose->update(self::setValidate($request));

        return response()->json(self::getDose(null, $dose->id));
    }

    // dose.destroy
    public function delete(Dose $dose)
    {
        $dose->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public static function setValidate($request)
    {
        return $request->validate([
            'type' => 'required|exists:dose_types,id',
            'patient' => 'required|exists:users,id',
            'date' => 'required|date',
        ]);
    }
}
