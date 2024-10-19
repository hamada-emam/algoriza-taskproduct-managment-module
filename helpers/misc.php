<?php
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
