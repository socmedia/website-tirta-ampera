<?php

namespace App\Traits;

use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\Response as ImageResponse;

trait FileService
{
    /**
     * Convert an image from a given URL and return the new converted image.
     *
     * @param  Request  $request (expects 'resource', 'width', and optionally 'format')
     * @return ImageResponse
     */
    public function rescaleImage($request)
    {
        try {
            // Extract parameters from the request
            $resource = $request['resource'];
            $width = isset($request['w']) ? $request['w'] : null;
            $format = isset($request['format']) ? $request['format'] : 'jpg'; // Default format is jpg

            // Validate the required 'resource' and 'width' parameters
            if (empty($resource) || empty($width)) {
                throw new Exception('Both resource and width are required.', 400);
            }

            // Initialize the image resource
            $image = Image::make($resource);

            // Resize image by width while maintaining aspect ratio
            $image->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            // Return the image in the specified format
            return $image->response($format);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Upload a file to storage and return its URL.
     * Optionally rescale/compress image files.
     *
     * @param  \Illuminate\Http\UploadedFile $fileInput (uploaded file)
     * @param  string $disk
     * @param  array $options ['rescale' => bool, 'width' => int|null, 'quality' => int|null]
     * @return string File URL
     */
    public function storeFile($fileInput, string $disk = 'public', array $options = []): string
    {
        $path = now()->toDateString();
        $fileName = Str::random(12) . '.' . $fileInput->extension();
        $fullPath = config('filesystems.disks.' . $disk . '.path') . "/{$path}/{$fileName}";

        $shouldRescale = $options['rescale'] ?? false;
        $width = $options['width'] ?? 600;
        $quality = $options['quality'] ?? 80; // Default compression quality

        // If rescale is requested and file is an image
        if ($shouldRescale && strpos($fileInput->getMimeType(), 'image/') === 0) {
            // Use the uploaded file's stream instead of getRealPath()
            $image = Image::make($fileInput);

            // If width is set, resize while maintaining aspect ratio
            if ($width) {
                $image->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            // Encode the image to the original extension (or default to jpg)
            $extension = $fileInput->extension() ?: 'jpg';
            $encodedImage = $image->encode($extension, $quality);

            // Store the compressed image directly from the encoded data
            Storage::disk($disk)->put("{$path}/{$fileName}", $encodedImage);
        } else {
            // putFileAs returns the path of the stored file
            Storage::disk($disk)->putFileAs($path, $fileInput, $fileName);
        }

        return $fullPath;
    }

    /**
     * Store a file uploaded via Dropzone and return its URL.
     *
     * @param  \Illuminate\Http\UploadedFile $fileInput (uploaded file from Dropzone)
     * @param  string $disk
     * @return string File URL
     */
    public function storeFileFromDropzone($fileInput, string $disk = 'public'): string
    {
        // You may want to validate the file here if needed
        $path = now()->toDateString();
        $fileName = Str::random(12) . '.' . $fileInput->getClientOriginalExtension();
        $fullPath = config('filesystems.disks.' . $disk . '.path') . "/{$path}/{$fileName}";

        Storage::disk($disk)->putFileAs($path, $fileInput, $fileName);

        return $fullPath;
    }

    /**
     * Upload a base64 encoded file to storage and return its URL.
     *
     * @param  string $fileInput (base64 encoded)
     * @param  string $disk
     * @param  int $width
     * @return string File URL
     */
    public function storeFileFromBase64(string $fileInput, string $disk = 'public', int $width = 400): string
    {
        preg_match("/data:image\/(.*?);/", $fileInput, $image_extension);
        if (empty($image_extension[1])) {
            throw new Exception('Invalid base64 image data.', 400);
        }

        $image = preg_replace('/data:image\/(.*?);base64,/', '', $fileInput);
        $image = str_replace(' ', '+', $image);
        $image = base64_decode($image);

        $path = now()->toDateString();
        $fileName = Str::random(12) . '.' . $image_extension[1];

        $fullPath = config('filesystems.disks.' . $disk . '.path') . "/{$path}/{$fileName}";

        $imageInstance = Image::make($image);
        $imageInstance->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        Storage::disk($disk)->put("{$path}/{$fileName}", $imageInstance->encode()->encoded);

        return $fullPath;
    }

    /**
     * Update a file in storage and return its new URL.
     *
     * @param  \Illuminate\Http\UploadedFile $fileInput (uploaded file)
     * @param  string $oldFilePath
     * @param  string $disk
     * @return string New File URL
     */
    public function updateFile($fileInput, string $oldFilePath, string $disk = 'public'): string
    {
        $path = $this->storeFile($fileInput, $disk);
        $this->removeFile($disk, $oldFilePath);

        return $path;
    }

    /**
     * Find an existing file in storage.
     *
     * @param  string $disk
     * @param  string $shortPath
     * @return mixed
     */
    public function findFile(string $disk, string $shortPath)
    {
        return Storage::disk($disk)->exists($shortPath) ? Storage::disk($disk)->get($shortPath) : false;
    }

    /**
     * Remove a file from storage.
     *
     * @param  string $disk
     * @param  string $path (date/filename.ext)
     * @return bool
     */
    public function removeFile(string $disk, string $path): bool
    {
        $path = explode('/', $path);
        $processed = implode('/', array_slice($path, -2, 2));

        return Storage::disk($disk)->exists($processed) ? Storage::disk($disk)->delete($processed) : false;
    }
}
