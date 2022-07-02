<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Models\AnalysisType;
use App\Models\DetectionType;
use App\Models\DoseType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/content', [
            'getData' => self::getPatient(),
            'roles' => [],
        ]);
    }

    public function getPatient($name = null, $id = null, $type = 'patient')
    {
        return User::query()
            ->when($name, function ($query) use ($name) {
                return $query->where('name', $name);
            })
            ->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })
            ->whereRelation('roles', 'name', '=', $type)
            ->get(['id', 'name'])
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'phone' => $item->phone,
                    'email' => $item->email,
                ];
            });
    }
}
