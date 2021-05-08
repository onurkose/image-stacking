<?php

use App\Models\Image;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::post('upload', function (Request $request) {
    $request->validate([
        'files' => 'required',
        'files.*' => 'mimes:png|max:2048'
    ]);

    $arrayIndex = $request->get('array_index');

    $uploadedFiles = $request->file('files');

    if (is_array($uploadedFiles)) {
        foreach ($uploadedFiles as $uploadedFile) {
            $filename = time() . $uploadedFile->getClientOriginalName();

            $uploadedFile->storeAs('public/images', $filename);

            Image::create([
                'array_row' => $arrayIndex,
                'file_name' => $filename,
            ]);
        }
    }

    return response()->json(['success' => true]);
});

Route::get('generate', function () {
    $images = Image::get();

    $groupedList = [];

    $groupedListCartesian = [];

    if ($images->count()) {
        foreach ($images as $image) {
            if (array_key_exists($image->array_row, $groupedList)) {
                $groupedList[$image->array_row][] = $image->file_name;
            } else {
                $groupedList[$image->array_row] = [$image->file_name];
            }
        }

        combinations($groupedList, $groupedListCartesian, min(array_keys($groupedList)));
    }

    return response()->json($groupedListCartesian);
});

Route::get('reset', function () {
    Image::truncate();

    return response()->json(['success' => true]);
});
