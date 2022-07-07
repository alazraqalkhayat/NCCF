<?php

namespace App\Http\Controllers\Dashboard\Reports;

use App\Http\Controllers\Controller;
use App\Models\PsychologicalAid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PsychologicalAidsController extends Controller
{
    public static function getPsychologicalAids($name=null, $id = null): Collection|array|\Illuminate\Support\Collection
    {
        return PsychologicalAid::query()
            ->when($id, fn($query, $id) => $query->where('id', '=', $id))
            ->when($name, fn($query, $name) => $query->where('problem', 'like', '%' . $name . '%'))
            ->get(['id', 'problem','patient'])
            ->map(fn($item) => [
                'id' => $item->id,
                'problem' => $item->problem,
                'patient' => $item->patient()->first()?->name,
            ]);
    }
}
