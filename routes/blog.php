<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Web\FrontBlogController;


// Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
//     Route::group(['middleware' => ['admin']], function () {

//         Route::get('blog/view', [BlogController::class, 'index'])->name('blog.view');
//         Route::post('blog/store', [BlogController::class, 'store'])->name('blog.store');
//         Route::get('blog/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
//         Route::put('blog/update/{id}', [BlogController::class, 'update'])->name('blog.update');
//         Route::post('delete', [BlogController::class, 'delete'])->name('blog.delete');
//     });
// });


// front end
Route::group(['namespace' => 'Web','middleware'=>['maintenance_mode']], function () {
    Route::get('blogs', [FrontBlogController::class, 'all_blogs'])->name('all_blogs');
    Route::get('blogs/single/{id}', [FrontBlogController::class, 'single'])->name('blog.single');
});
