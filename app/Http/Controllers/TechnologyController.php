<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trashed_data = $request->input('trashed');

        if ($trashed_data) {

            $technologies = Technology::onlyTrashed()->get();
        } else {

            $technologies = Technology::all();
        }

        $trashed_num = Technology::onlyTrashed()->get()->count();

        return view('technologies.index', compact('technologies', 'trashed_num'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('technologies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTechnologyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTechnologyRequest $request)
    {
        $validated_data = $request->validated();

        $validated_data['slug'] = Str::slug($validated_data['name']);

        $newTechnology = Technology::create($validated_data);

        return to_route('technologies.show', $newTechnology);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function show(Technology $technology)
    {
        return view('technologies.show', compact('technology'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function edit(Technology $technology)
    {
        return view('technologies.edit', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTechnologyRequest  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTechnologyRequest $request, Technology $technology)
    {
        $validated_data = $request->validated();

        if ($validated_data['name'] !== $technology->name) {
            $validated_data['slug'] = Str::slug($validated_data['name']);
        }

        $technology->update($validated_data);

        return to_route('technologies.show', $technology);
    }

    public function restore(Technology $technology)
    {
        if ($technology->trashed()) {

            $technology->restore();

            request()->session()->flash('restore_message', 'The Technology: ' . $technology->name . ' is successfully restored');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        if ($technology->trashed()) {

            $technology->forceDelete();

            request()->session()->flash('full_delete_message', 'The Technology: ' . $technology->name . ' has been fully deleted');
        } else {

            $technology->delete();

            request()->session()->flash('delete_message', 'The Technology: ' . $technology->name . ' has been moved to the bin');
        }

        return to_route('technologies.index');
    }
}
