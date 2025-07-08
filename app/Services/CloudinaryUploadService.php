<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Exception;
use Illuminate\Support\Facades\Log;

class CloudinaryUploadService
{
    protected Cloudinary $cloudinary;

    /**
     * The constructor injects the Cloudinary instance that we configured
     * in the AppServiceProvider.
     */
    public function __construct(Cloudinary $cloudinary)
    {
        $this->cloudinary = $cloudinary;
    }

    /**
     * Uploads a file to Cloudinary.
     *
     * @param UploadedFile $file The file to upload.
     * @param string|null $folder The folder on Cloudinary to store the file in.
     * @param string|null $publicId An optional public ID for the file.
     * @return string|null The secure URL of the uploaded file, or null on failure.
     */
    public function upload(UploadedFile $file, ?string $folder = null, ?string $publicId = null): ?string
    {
        try {
            $options = [
                'folder' => $folder,
                'public_id' => $publicId,
                // 'overwrite' => true, // Set to true if you want to overwrite existing files with the same public_id
            ];

            // Remove null values so we don't send empty parameters
            $options = array_filter($options);

            $uploadedFile = $this->cloudinary
                ->uploadApi()
                ->upload($file->getRealPath(), $options);

            return $uploadedFile['secure_url'];

        } catch (Exception $e) {
            Log::error('Cloudinary Upload Failed: ' . $e->getMessage());
            return null;
        }
    }
}
