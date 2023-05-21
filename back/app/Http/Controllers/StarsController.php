<?php

namespace App\Http\Controllers;

use App\Models\Star;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StarsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Star::all());
    }

    /**
     * @param Request $request
     * @param Star $id
     * @return JsonResponse
     */
    public function show(Request $request, Star $id)
    {
        return response()->json($id);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string|max:50',
            'firstname' => 'string|max:50',
            'description' => 'string',
        ]);

        return response()->json($this->manage($request));
    }

    /**
     * @param Request $request
     * @param String $id
     * @return JsonResponse
     */
    public function update(Request $request, String $id)
    {
        $request->validate([
            'name' => 'string|max:50',
            'firstname' => 'string|max:50',
            'description' => 'string',
        ]);

        return response()->json($this->manage($request, $id));
    }

    /**
     * @param Request $request
     * @param String $id
     * @return Star $star
     */
    public function manage($request, $id = null)
    {
        $star = Star::updateOrCreate(
            [
                Star::COLUMN_ID => $id
            ],
            [
                Star::COLUMN_NAME => $request->name,
                Star::COLUMN_FIRSTNAME => $request->firstname,
                Star::COLUMN_DESCRIPTION => $request->description
            ]
        );

        return $star;
    }

    /**
     * @param Star $id
     * @return JsonResponse
     */
    public function destroy(Star $id)
    {
        $id->delete();
        return response()->json('Deleted');
    }
}
