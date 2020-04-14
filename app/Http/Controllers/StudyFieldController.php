<?php

namespace App\Http\Controllers;

use App\StudyField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StudyFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studyfields = StudyField::with('creator')->get();
        return view('studyfield.index', compact('studyfields'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('studyfield.edit', [
            'mode'       => 'create',
            'method'     => 'POST',
            'action'     => route('studyfield.store'),
            'studyfield' => (object) [
                'name' => ''
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:study_fields'
        ]);

        $sf = new StudyField(['name' => $request->input('name')]);
        $sf->save();

        return redirect()->route('studyfield.index')
            ->with('success', __('actions.studyfield.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudyField  $studyfield
     * @return \Illuminate\Http\Response
     */
    public function edit(StudyField $studyfield)
    {
        $studyfield->load('creator');
        return view('studyfield.edit', [
            'mode'       => 'edit',
            'method'     => 'PUT',
            'action'     => route('studyfield.update', $studyfield),
            'studyfield' => $studyfield
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudyField  $studyfield
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudyField $studyfield)
    {
        $request->validate([
            'name' => [
                'required',
                Rule::unique('study_fields')->ignore($studyfield->id),
            ]
        ]);
        $studyfield->name = $request->input('name');
        if ($request->has('make_public')) {
            $studyfield->creator()->dissociate();
            $studyfield->creator()->associate(Auth::user());
        }
        $studyfield->save();
        return redirect()->route('studyfield.index')
            ->with('success', __('actions.studyfield.edited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudyField  $studyfield
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudyField $studyfield)
    {
        $studyfield->applications()->detach();
        $studyfield->delete();
        return redirect()->route('studyfield.index')
            ->with('success', __('actions.studyfield.deleted'));
    }
}
