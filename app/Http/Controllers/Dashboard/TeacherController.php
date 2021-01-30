<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\EducationSystem;
use App\Models\Level;
use App\Models\LevelSubject;
use App\Models\Section;
use App\Models\Stage;
use App\Models\Subject;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class TeacherController extends Controller
{

    use PasswordValidationRules;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $subjects = Level::find(1)->subjects;
        $stages = Stage::all();
        $years = Year::all();
        $sections = Section::all();
        $education_systems = EducationSystem::all();
        $teachers = User::whereRoleIs('teachers')->where(function ($q) use ($request){
            return $q->when($request->search, function ($query) use ($request) {
                return $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(2);

        return view('dashboard.teachers.index', ['teachers' => $teachers, 'subjects' => $subjects, 'stages' => $stages, 'years' => $years, 'sections' => $sections, 'education_systems' => $education_systems]);
    }

    public function create(){
        $subjects = Level::find(1)->subjects;
        return view('dashboard.teachers.create', ['subjects' => $subjects]);
    }

    public function store(){
        \request()->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'image' => ['image'],
            'password' => $this->passwordRules(),
            'permissions' => 'required|min:1',
            'subjects' => 'required|min:1',
            'description' => ['required', 'string', 'max:255'],
        ]);

        $arr = [
            'first_name' => \request('first_name'),
            'last_name' => \request('last_name'),
            'email' => \request('email'),
            'password' => bcrypt(\request('password')),
        ];

        if(\request('image')){
            $path = \request('image')->hashName();
            Image::make(\request('image'))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/' . $path));
            $arr['image'] = \request('image')->hashName();
        }

        $teacher = User::create($arr);

        $teacher->attachRole('teachers');
        $teacher->syncPermissions(\request('permissions'));

        $teacher->teacher_profile()->create(
            ['description' => \request('description')]
        );

        $teacher->subjects()->attach(\request('subjects'));

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.teachers.index');

    }

    public function show($id){
        $teacher = User::find($id);
        $subjects = Subject::all();
        $levels = [];
        foreach ($teacher->subjects as $i=>$subject){
            $subject_levels = $teacher->level_subjects()->where('subject_id', $subject->id)->get();
            $levels[$i] = [];
            foreach ($subject_levels as $subject_level){
                array_push($levels[$i], Level::find($subject_level->level_id));
            }
        }
        return view('dashboard.teachers.show', ['teacher' => $teacher, 'levels' => $levels, 'subjects' => $subjects]);
    }

    public function edit($id){
        $teacher = User::find($id);
        return view('dashboard.teachers.edit', compact('teacher'));
    }

    public function update($id){
        $teacher = User::find($id);
        \request()->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                Rule::unique('users')->ignore($teacher->id),
            ],
            'image' => ['image'],
            'permissions' => 'required|min:1',
            'description' => ['required', 'string', 'max:255'],
        ]);

        $arr = [
            'first_name' => \request('first_name'),
            'last_name' => \request('last_name'),
            'email' => \request('email'),
        ];

        if(\request('image') != null && \request('image') != 'default.png'){
            if ($teacher->image != 'default.png'){
                Storage::disk('public_uploads')->delete('/user_images/'. $teacher->image);
            }
            $path = \request('image')->hashName();
            Image::make(\request('image'))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/' . $path));
            $arr['image'] = \request('image')->hashName();
        }

        $teacher->update($arr);
        $teacher->syncPermissions(\request('permissions'));

        $teacher->teacher_profile()->update(
            ['description' => \request('description')]
        );

        session()->flash('success', __('site.edited_successfully'));
        return redirect()->route('dashboard.teachers.index');
    }

    public function delete($id){
        $teacher = User::find($id);
        if ($teacher->image != 'default.png'){
            Storage::disk('public_uploads')->delete('/user_images/'. $teacher->image);
        }
        foreach ($teacher->assistants as $assistant){
            $user = User::find($assistant->assistant->id);
            $user->delete();
            $assistant->delete();
        }
        $teacher->teacher_profile()->delete();
        $teacher->assistants()->delete();
        $teacher->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.teachers.index');
    }

    public function set_level_subject($teacher_id){
        $level_subject = LevelSubject::where('subject_id', \request('subject_id'))->where('level_id', \request('level_id'))->first();
        $level_subject = $level_subject->teachers()->attach($teacher_id);
        return redirect()->route('dashboard.teachers.show', $teacher_id);
    }

    public function set_subject($teacher_id){
        $subject = Subject::find(\request('subject_id'));
        $subject = $subject->teachers()->attach($teacher_id);
        return redirect()->route('dashboard.teachers.show', $teacher_id);
    }
}
