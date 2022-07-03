<?php

namespace App\Http\Controllers\Dashboard\Content;

use App\Http\Controllers\Controller;
use App\Models\Activities;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ActivityController extends Controller
{
    public static function getActivity($date = null, $id = null)
    {
        return Activities::query()
            ->when($date, fn ($q, $r) => $q->whereDate('name', '=',  $r))
            ->when($id, fn ($q, $r) => $q->where('id', $r))
            ->get(['id', 'path', 'type']);
    }

    // activity.store
    public function store(Request $request): JsonResponse
    {
        $data = self::setValidate($request);
        if (str_contains($request->get('fileType'), 'image'))
            $data['path'] = 'Files/' . $request->file('path')->store('images/activities', 'upload');
        else
            $data['path'] = 'Files/' . $request->file('path')->store('videos/activities', 'upload');

        $activity = Activities::query()->create($data);

        return response()->json(self::getActivity(null, $activity->id));
    }

    // activity.update
    public function update(Request $request, Activities $activity)
    {
        $data = self::setValidate($request);
        if ($request->hasFile('path')) {
            if (str_contains($request->get('fileType'), 'image'))
                $data['path'] = 'Files/' . $request->file('path')->store('images/activities', 'upload');
            else
                $data['path'] = 'Files/' . $request->file('path')->store('videos/activities', 'upload');


            if (File::exists($activity->path))
                File::delete($activity->path);
        }
        $activity->update($data);

        return response()->json(self::getActivity(null, $activity->id));
    }

    // activity.destroy
    public function delete(Activities $activity)
    {
        if (File::exists($activity->path))
            File::delete($activity->path);

        $activity->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    public static function setValidate($request)
    {
        return $request->validate([
            'path' => $request->hasFile('path') ? 'required' : '',
            'type' => 'required',
        ]);
    }
}
