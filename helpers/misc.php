<?php

use Illuminate\Support\Str;

if (!function_exists('upload_file')) {
    /**
     * Upload a file and return the path.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string
     */
    function upload_file($file, $directory = 'uploads/products')
    {
        $path = $file->store($directory, 'public');
        return $path;
    }
}

if (!function_exists('generate_unique_file_path')) {

    function generate_unique_file_path($prefix = 'export', $extension = 'xlsx')
    {
        $timestamp = now()->format('Ymd_His');
        $randomString = Str::random(10);

        return "/exports/{$prefix}_{$timestamp}_{$randomString}.{$extension}";
    }
}
