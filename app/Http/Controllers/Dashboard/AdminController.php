<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{

    use PasswordValidationRules;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $admins = User::whereRoleIs('admins')->where(function ($q) use ($request){
            return $q->when($request->search, function ($query) use ($request) {
                return $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(2);

        return view('dashboard.admins.index', compact('admins'));
    }

    public function create(){
        return view('dashboard.admins.create');
    }

    public function store(){
        \request()->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'image' => ['image'],
            'password' => $this->passwordRules(),
            'permissions' => 'required|min:1',
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

        $admin = User::create($arr);

        $admin->attachRole('admins');
        $admin->syncPermissions(\request('permissions'));

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.admins.index');

    }

    public function show($id){

    }

    public function edit($id){
        $admin = User::find($id);
        return view('dashboard.admins.edit', compact('admin'));
    }

    public function update($id){
        $admin = User::find($id);
        \request()->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                Rule::unique('users')->ignore($admin->id),
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
            if ($admin->image != 'default.png'){
                Storage::disk('public_uploads')->delete('/user_images/'. $admin->image);
            }
            $path = \request('image')->hashName();
            Image::make(\request('image'))->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/user_images/' . $path));
            $arr['image'] = \request('image')->hashName();
        }

        $admin->update($arr);
        $admin->syncPermissions(\request('permissions'));

        session()->flash('success', __('site.edited_successfully'));
        return redirect()->route('dashboard.admins.index');
    }

    public function delete($id){
        $admin = User::find($id);
        if ($admin->image != 'default.png'){
            Storage::disk('public_uploads')->delete('/user_images/'. $admin->image);
        }
        $admin->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.admins.index');
    }
}
