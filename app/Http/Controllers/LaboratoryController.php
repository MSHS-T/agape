<?php

namespace App\Http\Controllers;

use App\Application;
use App\Laboratory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laboratories = Laboratory::with('creator')->get();
        return view('laboratory.index', compact('laboratories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('laboratory.edit', [
            'mode'       => 'create',
            'method'     => 'POST',
            'action'     => route('laboratory.store'),
            'laboratory' => (object) [
                'name'           => '',
                'unit_code'      => '',
                'director_email' => '',
                'regency'        => ''
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
            'name'           => 'required',
            'unit_code'      => 'required',
            'director_email' => 'required|email',
            'regency'        => 'required'
        ]);

        $lab = new Laboratory($request->all());
        $lab->save();

        return redirect()->route('laboratory.index')
            ->with('success', __('actions.laboratory.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Laboratory  $laboratory
     * @return \Illuminate\Http\Response
     */
    public function edit(Laboratory $laboratory)
    {
        $laboratory->load('creator');
        return view('laboratory.edit', [
            'mode'       => 'edit',
            'method'     => 'PUT',
            'action'     => route('laboratory.update', $laboratory),
            'laboratory' => $laboratory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Laboratory  $laboratory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laboratory $laboratory)
    {
        $request->validate([
            'name'           => 'required',
            'unit_code'      => 'required',
            'director_email' => 'required|email',
            'regency'        => 'required'
        ]);
        $laboratory->fill($request->only(['name', 'unit_code', 'director_email', 'regency']));
        if ($request->has('make_public')) {
            $laboratory->creator()->dissociate();
            $laboratory->creator()->associate(Auth::user());
        }
        $laboratory->save();
        return redirect()->route('laboratory.index')
            ->with('success', __('actions.laboratory.edited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Laboratory  $laboratory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laboratory $laboratory)
    {
        $laboratory->applications()->detach();
        $laboratory->delete();
        return redirect()->route('laboratory.index')
            ->with('success', __('actions.laboratory.deleted'));
    }
}
