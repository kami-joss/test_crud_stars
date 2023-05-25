<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImagesController extends Controller
{
    public function upload(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fileUpload = new Image;

        if ($request->file()) {
            $file_name = time() . '_' . $request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('images', $file_name, 'public');

            $fileUpload->name = time() . '_' . $request->file->getClientOriginalName();
            $fileUpload->path = '/storage/' . $file_path;
            $fileUpload->save();

            return response()->json(['success' => 'File uploaded successfully.']);
        }
    }

    public function destroy(Image $id)
    {
        $id->stars()->detach();
        $id->delete();

        return response()->json('deleted');
    }
}
