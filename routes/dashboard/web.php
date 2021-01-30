<?php

use \Illuminate\Support\Facades\Route;

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function() {
    Route::prefix('dashboard')->middleware(['auth:sanctum', 'verified', 'role:super_admin|admins'])->name('dashboard.')->group(function () {
        Route::view('/', 'dashboard.index')->name('index');
        Route::prefix('admins')->middleware(['permission:users_read'])->name('admins.')->group(function (){
            Route::get('/', [\App\Http\Controllers\Dashboard\AdminController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Dashboard\AdminController::class, 'create'])->middleware(['permission:users_create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Dashboard\AdminController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\Dashboard\AdminController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\App\Http\Controllers\Dashboard\AdminController::class, 'edit'])->middleware(['permission:users_update'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\Dashboard\AdminController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\Dashboard\AdminController::class, 'delete'])->middleware(['permission:users_delete'])->name('delete');
        });
        Route::prefix('teachers')->middleware(['permission:teachers_read'])->name('teachers.')->group(function (){
            Route::get('/', [\App\Http\Controllers\Dashboard\TeacherController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Dashboard\TeacherController::class, 'create'])->middleware(['permission:teachers_create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Dashboard\TeacherController::class, 'store'])->name('store');
            Route::get('/{teacher_id}', [\App\Http\Controllers\Dashboard\TeacherController::class, 'show'])->name('show')->middleware('checkUser:teachers');
            Route::get('/{teacher_id}/edit', [\App\Http\Controllers\Dashboard\TeacherController::class, 'edit'])->middleware(['permission:teachers_update', 'checkUser:teachers'])->name('edit');
            Route::put('/{teacher_id}', [\App\Http\Controllers\Dashboard\TeacherController::class, 'update'])->name('update');
            Route::delete('/{teacher_id}', [\App\Http\Controllers\Dashboard\TeacherController::class, 'delete'])->middleware(['permission:teachers_delete'])->name('delete');
            Route::post('/{teacher_id}/add_level', [\App\Http\Controllers\Dashboard\TeacherController::class, 'set_level_subject'])->name('add_level');
            Route::post('/{teacher_id}/add_subject', [\App\Http\Controllers\Dashboard\TeacherController::class, 'set_subject'])->name('add_subject');
            Route::prefix('{teacher_id}/assistants')->middleware(['permission:assistants_read', 'checkUser:teachers'])->name('assistants.')->group(function (){
                Route::get('/', [\App\Http\Controllers\Dashboard\TeacherAssistantsController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\Dashboard\TeacherAssistantsController::class, 'create'])->middleware(['permission:assistants_create'])->name('create');
                Route::post('/', [\App\Http\Controllers\Dashboard\TeacherAssistantsController::class, 'store'])->name('store');
                Route::get('/{id}', [\App\Http\Controllers\Dashboard\TeacherAssistantsController::class, 'show'])->name('show')->middleware(['checkUser:assistants', 'checkAssistant']);
                Route::get('/{id}/edit', [\App\Http\Controllers\Dashboard\TeacherAssistantsController::class, 'edit'])->middleware(['permission:assistants_update'])->name('edit')->middleware(['checkUser:assistants', 'checkAssistant']);
                Route::put('/{id}', [\App\Http\Controllers\Dashboard\TeacherAssistantsController::class, 'update'])->name('update');
                Route::delete('/{id}', [\App\Http\Controllers\Dashboard\TeacherAssistantsController::class, 'delete'])->middleware(['permission:assistants_delete'])->name('delete');
            });
            Route::prefix('{teacher_id}/subjects')->middleware(['permission:subjects_read'])->name('assistants.')->group(function (){
                Route::get('/', [\App\Http\Controllers\Dashboard\TeacherSubjectController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\Dashboard\TeacherSubjectController::class, 'create'])->middleware(['permission:subjects_create'])->name('create');
                Route::post('/', [\App\Http\Controllers\Dashboard\TeacherSubjectController::class, 'store'])->name('store');
                Route::get('/{id}', [\App\Http\Controllers\Dashboard\TeacherSubjectController::class, 'show'])->name('show')->middleware(['checkUser:assistants', 'checkAssistant']);
                Route::get('/{id}/edit', [\App\Http\Controllers\Dashboard\TeacherSubjectController::class, 'edit'])->middleware(['permission:subjects_update'])->name('edit');
                Route::put('/{id}', [\App\Http\Controllers\Dashboard\TeacherSubjectController::class, 'update'])->name('update');
                Route::delete('/{id}', [\App\Http\Controllers\Dashboard\TeacherSubjectController::class, 'delete'])->middleware(['permission:subjects_delete'])->name('delete');
            });
        });
        Route::prefix('assistants')->middleware(['permission:assistants_read'])->name('assistants.')->group(function (){
            Route::get('/', [\App\Http\Controllers\Dashboard\AssistantsController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Dashboard\AssistantsController::class, 'create'])->middleware(['permission:assistants_create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Dashboard\AssistantsController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\Dashboard\AssistantsController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\App\Http\Controllers\Dashboard\AssistantsController::class, 'edit'])->middleware(['permission:assistants_update'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\Dashboard\AssistantsController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\Dashboard\AssistantsController::class, 'delete'])->middleware(['permission:assistants_delete'])->name('delete');
        });
        Route::prefix('subjects')->middleware(['permission:subjects_read'])->name('subjects.')->group(function (){
            Route::get('/', [\App\Http\Controllers\Dashboard\SubjectController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Dashboard\SubjectController::class, 'create'])->middleware(['permission:subjects_create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Dashboard\SubjectController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\Dashboard\SubjectController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\App\Http\Controllers\Dashboard\SubjectController::class, 'edit'])->middleware(['permission:subjects_update'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\Dashboard\SubjectController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\Dashboard\SubjectController::class, 'destroy'])->middleware(['permission:subjects_delete'])->name('delete');
        });
        Route::prefix('levels')->middleware(['permission:levels_read'])->name('levels.')->group(function (){
            Route::get('/', [\App\Http\Controllers\Dashboard\LevelController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Dashboard\LevelController::class, 'create'])->middleware(['permission:levels_create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Dashboard\LevelController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\Dashboard\LevelController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\App\Http\Controllers\Dashboard\LevelController::class, 'edit'])->middleware(['permission:levels_update'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\Dashboard\LevelController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\Dashboard\LevelController::class, 'destroy'])->middleware(['permission:levels_delete'])->name('delete');
        });
        Route::prefix('terms')->middleware(['permission:terms_read'])->name('terms.')->group(function (){
            Route::get('/', [\App\Http\Controllers\Dashboard\TermController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Dashboard\TermController::class, 'create'])->middleware(['permission:terms_create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Dashboard\TermController::class, 'store'])->name('store');
            Route::get('/{id}', [\App\Http\Controllers\Dashboard\TermController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [\App\Http\Controllers\Dashboard\TermController::class, 'edit'])->middleware(['permission:terms_update'])->name('edit');
            Route::put('/{id}', [\App\Http\Controllers\Dashboard\TermController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\Dashboard\TermController::class, 'destroy'])->middleware(['permission:terms_delete'])->name('delete');
        });
    });
});
