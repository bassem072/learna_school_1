<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\EducationSystem;
use App\Models\Level;
use App\Models\LevelTranslation;
use App\Models\Section;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\App;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $stages = Stage::all();
        $years = Year::all();
        $sections = Section::all();
        $education_systems = EducationSystem::all();
        /*$levels = Level::when($request->stage, function ($query) use ($request) {
            return $query->whereTranslationLike('section', $request->section ? '%' . $request->section . '%' : '%')
                ->whereTranslationLike('stage', $request->stage ? '%' . $request->stage . '%' : '%')
                ->whereTranslationLike('year', $request->year ? '%' . $request->year . '%' : '%')
                ->whereTranslationLike('education_system', $request->education_system ? '%' . $request->education_system . '%' : '%');
        })->paginate(5);*/
        $levels = Level::when($request->education_system, function ($query) use ($request){
            return $query->where('education_system_id', $request->education_system);
        })->when($request->stage, function ($query) use ($request){
            return $query->where('stage_id', $request->stage);
        })->when($request->year, function ($query) use ($request){
            return $query->where('year_id', $request->year);
        })->when($request->section, function ($query) use ($request){
            return $query->where('section_id', $request->section);
        })->paginate(500);

        //$levels = Level::paginate(500);
        //dd($levels[0]->year->name);
        return view('dashboard.levels.index', ['levels' => $levels, 'stages' => $stages, 'years' => $years, 'sections' => $sections, 'education_systems' => $education_systems]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.levels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        \request()->validate([
            'ar.name' => ['required', Rule::unique('level_translations', 'name')],
            'en.name' => ['required', Rule::unique('level_translations', 'name')],
        ]);

        $level = Level::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.levels.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $term = Level::find($id);
        return view('dashboard.levels.edit', compact('term'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $level = Level::find($id);
        \request()->validate([
            'ar.*' => [
                'required',
                Rule::unique('level_translations')->ignore($level->translate('ar')->id),
            ],
            'en.*' => [
                'required',
                Rule::unique('level_translations')->ignore($level->translate('en')->id),
            ],
        ]);

        $level->update($request->all());
        session()->flash('success', __('site.edited_successfully'));
        return redirect()->route('dashboard.levels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $level = Level::find($id);
        $level->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.levels.index');
    }
}
