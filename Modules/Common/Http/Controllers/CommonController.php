<?php

namespace Modules\Common\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommonController extends Controller
{
    use FileService;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('common::index');
    }

    /**
     * Handle image upload using FileService.
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'images' => 'required',
                'images.*' => 'file|image|max:5120', // Handle multiple images if needed
                'compression' => 'nullable|integer|min:10|max:100', // Optional compression quality
            ]);

            // If it's multiple:
            $file = is_array($request->images->get('images'))
                ? $request->images->get('images')[0]
                : $request->file('images');

            if (!$file) {
                return response()->json(['message' => 'No file found'], 422);
            }

            // Get compression quality from request, default to 80 if not provided
            $quality = $request->input('compression', 80);

            // Pass compression and optional width to storeFile
            $upload = $this->storeFile($file, 'image', [
                'rescale' => $request->has('width') ? true : false,
                'width' => $request->input('width') ?: null,
                'quality' => $quality,
            ]);
            if (strpos($upload, '/') === 0) {
                $upload = substr($upload, 1);
            }

            // Explode the full path to get the filename
            $filename = '';
            if ($upload) {
                $parts = explode('/', $upload);
                $filename = end($parts);
            }

            return response()->json([
                'url' => Storage::url($upload),
                'filename' => $filename,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred during upload.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Detele an image from storage.
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'url' => 'required|string',
        ]);

        $url = $request->input('url');
        $disk = 'image';

        // Use the FileService trait's removeFile method
        $removed = $this->removeFile($disk, $url);

        if ($removed) {
            return response()->json(['message' => 'File removed']);
        } else {
            return response()->json(['message' => 'File not found'], 404);
        }
    }
}
