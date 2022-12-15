<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Libs\Response;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $fields = [
            'type' => $request->type,
            'photo' => $request->file('photo'),
            'name' => $request->name,
            'created' => $request->created,
            'location' => $request->location,
            'description' => $request->description,
        ];

        $rules = [
            'type' => 'required|in:checkin,checkout,leave',
            'photo' => 'required|image',
            'name' => 'required|string',
            'created' => 'required|date_format:Y-m-d H:i:s',
            'location' => 'required|string',
            'description' => 'required|string',
        ];

        $validator = Validator::make($fields, $rules);

        if ($validator->fails()) return (new Response)->json(null, $validator->errors(), 422);

        $photo = $request->file('photo');

        $filename = $photo->getClientOriginalName();

        $filename = time() . '_' . str_replace(' ', '_', $filename);
        $photo->storeAs('reports', $filename);
        $report = new Report();
        $report->type = $request->type;
        $report->photo = "reports/$filename";
        $report->name = $request->name;
        $report->created = $request->created;
        $report->location = $request->location;
        $report->description = $request->description;
        $report->save();



        return (new Response)->json($report->toArray(), 'success');
    }

    public function downloadPhoto($id)
    {
        $report = Report::find($id);
        if (!$report) return (new Response)->json(null, 'Report not found', 404);
        $filename = $report->photo;

        $path = storage_path('app/' . $filename);
        if (!file_exists($path))
            return (new Response)->json(null, 'File not found', 404);

        return response()->download($path);
    }
}
