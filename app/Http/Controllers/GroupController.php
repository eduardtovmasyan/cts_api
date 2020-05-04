<?php

namespace App\Http\Controllers;

use App\Group;
use Validator;
use Illuminate\Http\Request;
use App\Http\Resources\Group as GroupResource;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();

        return GroupResource::collection($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:groups,name',
            'description' => 'nullable',
        ])->validate();

        $timeNow = now();
        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'updated_at' => $timeNow,
            'created_at' => $timeNow,
        ]);

        return GroupResource::make($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($group)
    {
        $singlegroup = Group::findOrFail($group);
        
        return GroupResource::make($singlegroup);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $group)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:groups,name',
            'description' => 'nullable',
        ])->validate();

        Group::whereId($group)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($group)
    {
        Group::whereId($group)->delete();
    }
}
