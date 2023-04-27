<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class TypeController extends Controller
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

            $types = Type::onlyTrashed()->get();
        } else {

            $types = Type::all();
        }

        $trashed_num = Type::onlyTrashed()->get()->count();

        return view('types.index', compact('types', 'trashed_num'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypeRequest $request)
    {
        $validated_data = $request->validated();

        $validated_data['slug'] = Str::slug($validated_data['name']);

        $newType = Type::create($validated_data);

        return to_route('types.show', $newType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return view('types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTypeRequest  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $validated_data = $request->validated();

        if ($validated_data['name'] !== $type->name) {
            $validated_data['slug'] = Str::slug($validated_data['name']);
        }

        $type->update($validated_data);

        return to_route('types.show', $type);
    }

    public function restore(Type $type)
    {
        if ($type->trashed()) {

            $type->restore();

            request()->session()->flash('restore_message', 'The Work Type: ' . $type->name . ' is successfully restored');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        if ($type->trashed()) {

            $type->forceDelete();

            request()->session()->flash('full_delete_message', 'The Work Type: ' . $type->name . ' has been fully deleted');
        } else {

            $type->delete();

            request()->session()->flash('delete_message', 'The Work Type: ' . $type->name . ' has been moved to the bin');
        }

        return to_route('types.index');
    }
}
