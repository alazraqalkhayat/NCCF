<?php

namespace App\Http\Controllers\Dashboard\Reports;

use App\Http\Controllers\Controller;
use App\Models\PatientFrinds;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PatientFreindsController extends Controller
{
    public static function getPatientsFriends($name = null, $id = null): Collection|array|\Illuminate\Support\Collection
    {
        return PatientFrinds::query()
            ->when($id, fn($query, $id) => $query->where('id', '=', $id))
            ->when($name, fn($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->get(['id', 'name']);
    }
}
