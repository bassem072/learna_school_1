<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $terms = Term::when($request->search, function ($query) use ($request) {
            return $query->whereTranslationLike('name', '%' . $request->search . '%');
        })->paginate(5);

        return view('dashboard.terms.index', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.terms.create');
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
            'ar.name' => ['required', Rule::unique('term_translations', 'name')],
            'en.name' => ['required', Rule::unique('term_translations', 'name')],
        ]);

        $term = Term::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.terms.index');
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
        $term = Term::find($id);
        return view('dashboard.terms.edit', compact('term'));
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
        $term = Term::find($id);
        \request()->validate([
            'ar.*' => [
                'required',
                Rule::unique('subject_translations')->ignore($term->translate('ar')->id),
            ],
            'en.*' => [
                'required',
                Rule::unique('subject_translations')->ignore($term->translate('en')->id),
            ],
        ]);

        $term->update($request->all());
        session()->flash('success', __('site.edited_successfully'));
        return redirect()->route('dashboard.terms.index');
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
        $term = Term::find($id);
        $term->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.terms.index');
    }
}
