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
        $groups = Group::paginate(parent::PER_PAGE);

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
            'name' => 'required|max:100|unique:groups,name',
            'description' => 'nullable',
        ])->validate();

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return GroupResource::make($group);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::findOrFail($id);
        
        return GroupResource::make($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|max:100|unique:groups,name,' . $id,
            'description' => 'nullable',
        ])->validate();

        Group::whereId($id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Group::whereId($id)->delete();
    }
}
