<?php

namespace App\Http\Controllers;

use App\ProjectCallType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectCallTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectcalltypes = ProjectCallType::all();
        return view('projectcalltype.index', compact('projectcalltypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projectcalltype.edit', [
            'mode'       => 'create',
            'method'     => 'POST',
            'action'     => route('projectcalltype.store'),
            'project_call_type' => (object) [
                'label_short' => '',
                'label_long' => '',
                'reference' => '',
                'is_workshop' => false
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
            'reference'   => 'required|string|unique:project_call_types',
            'label_short' => 'required|string',
            'label_long'  => 'required|string',
            'is_workshop' => 'boolean',
        ]);

        $ct = new ProjectCallType([
            'reference'   => $request->input('reference'),
            'label_short' => $request->input('label_short'),
            'label_long'  => $request->input('label_long'),
            'is_workshop' => $request->input('is_workshop') ?? false,
        ]);
        $ct->save();

        return redirect()->route('projectcalltype.index')
            ->with('success', __('actions.project_call_type.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjectCallType  $projectcalltype
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectCallType $projectcalltype)
    {
        return view('projectcalltype.edit', [
            'mode'       => 'edit',
            'method'     => 'PUT',
            'action'     => route('projectcalltype.update', $projectcalltype),
            'project_call_type' => $projectcalltype
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProjectCallType  $projectcalltype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectCallType $projectcalltype)
    {
        $request->validate([
            'reference' => [
                'required',
                'string',
                Rule::unique('project_call_types')->ignore($projectcalltype->id),
            ],
            'label_short' => 'required|string',
            'label_long'  => 'required|string',
            'is_workshop' => 'boolean',
        ]);
        $projectcalltype->reference   = $request->input('reference');
        $projectcalltype->label_short = $request->input('label_short');
        $projectcalltype->label_long  = $request->input('label_long');
        $projectcalltype->is_workshop = $request->input('is_workshop');
        $projectcalltype->save();
        return redirect()->route('projectcalltype.index')
            ->with('success', __('actions.project_call_type.edited'));
    }
}
