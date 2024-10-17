<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Faker\Generator as Faker;

Route::get('/', function () {

    $faker = new Faker();
    $imagePath = $faker->image('public/storage/images', 640, 480, null, false);
    return $imagePath;
    // if (!file_exists($tempDirectory)) {
    //     mkdir($tempDirectory, 0777, true);
    // }
    // $image = $faker->image($tempDirectory, 640, 480, 'technics', true, true, 'product');
    // $imageName = basename($image);
    // $imagePath = 'products/' . $imageName;
    // return $imagePath;

    // Storage::disk('public')->put($imagePath, file_get_contents($image));
    // unlink($image);

    // return $imagePath;

    return view('welcome');
});
