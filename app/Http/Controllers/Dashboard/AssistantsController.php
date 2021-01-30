<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\AssistantProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class AssistantsController extends Controller
{
    use PasswordValidationRules;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $assistants = User::whereRoleIs('assistants')->where(function ($q) use ($request){
            return $q->when($request->search, function ($query) use ($request) {
                return $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(2);

        return view('dashboard.assistants.index', compact('assistants'));
    }

    public function create(){
        $teachers = User::whereRoleIs('teachers')->get();
        return view('dashboard.assistants.create', compact('teachers'));
    }

    public function store(){
        \request()->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'image' => ['image'],
            'password' => $this->passwordRules(),
            'permissions' => 'required|min:1',
            'teacher_id' => 'required',
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
        $assistant = User::create($arr);

        $assistant->attachRole('assistants');
        $assistant->syncPermissions(\request('permissions'));

        $assistant->assistant_profile()->create(
            [
                'description' => \request('description'),
            ]
        );
        $profile = AssistantProfile::find($assistant->assistant_profile->id);
        $profile->teacher_id = \request('teacher_id');
        $profile->save();

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.assistants.index');

    }

    public function show($id){

    }

    public function edit($id){
        $assistant = User::find($id);
        $teachers = User::whereRoleIs('teachers')->get();
        return view('dashboard.assistants.edit', ['assistant' => $assistant, 'teachers' => $teachers]);
    }

    public function update($id){
        $assistant = User::find($id);
        \request()->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                Rule::unique('users')->ignore($assistant->id),
            ],
            'image' => ['image'],
            'permissions' => 'required|min:1',
        ]);

        $arr = [
            'first_name' => \request('first_name'),
            'last_name' => \request('last_name'),
            'email' => \request('email'),
        ];

        if(\request('image') != null && \request('image') != 'default.png'){
            if ($assistant->image != 'default.png'){
                Storage::disk('public_uploads')->delete('/user_images/'. $assistant->image);
            }
            $path = \request('image')->hashName();
            Image::make(\request('image'))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/' . $path));
            $arr['image'] = \request('image')->hashName();
        }

        $assistant->update($arr);
        $assistant->syncPermissions(\request('permissions'));

        $assistant->assistant_profile()->update(
            [
                'description' => \request('description'),
            ]
        );
        $teacher = User::find(\request('teacher_id'));
        $profile = AssistantProfile::find($assistant->assistant_profile->id);
        $profile->teacher_id = $teacher->id;
        $profile->save();

        session()->flash('success', __('site.edited_successfully'));
        return redirect()->route('dashboard.assistants.index');
    }

    public function delete($id){
        $assistant = User::find($id);
        if ($assistant->image != 'default.png'){
            Storage::disk('public_uploads')->delete('/user_images/'. $assistant->image);
        }
        $assistant->assistant_profile()->delete();
        $assistant->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.assistants.index');
    }
}
