<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Star;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\images;
use Exception;

class StarsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(Star::with(['images'])->get());
    }

    /**
     * @param Request $request
     * @param Star $id
     * @return JsonResponse
     */
    public function show(Request $request, Star $id)
    {
        return response()->json($id->with(['images']));
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
            'images' => 'mimes:jpg,jpeg,png|max:2048'
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
            'images' => 'mimes:jpg,jpeg,png|max:2048'
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

        if ($request->images) {
            try {
                $images = $this->storeimages($request);
                $star->images()->save($images);
            } catch (Exception $e) {
                return $e;
            }
        }

        return Star::with(['images'])->where('id', $star->id)->first();
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

    /**
     * Store an images
     * @param Request $request
     * @return images
     */
    private function storeimages($request)
    {
        $fileUpload = new Image;

        if ($request->file('images')) {
            $file_name = time() . '_' . $request->images->getClientOriginalName();
            $file_path = $request->file('images')->storeAs('images', $file_name, 'public');

            $fileUpload->name = time() . '_' . $request->images->getClientOriginalName();
            $fileUpload->path = '/storage/' . $file_path;
            $fileUpload->save();

            return $fileUpload;
        }
    }
}
