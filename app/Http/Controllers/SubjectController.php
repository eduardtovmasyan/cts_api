<?php

namespace App\Http\Controllers;

use Validator;
use App\Subject;
use Illuminate\Http\Request;
use App\Http\Resources\Subject as SubjectResource;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::paginate(parent::PER_PAGE);

        return SubjectResource::collection($subjects);
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
            'name' => 'required|max:100|unique:subjects,name',
            'description' => 'string|max:65000|nullable',
        ])->validate();

        $subject = Subject::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return SubjectResource::make($subject);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subject = Subject::findOrFail($id);

        return SubjectResource::make($subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|max:100|unique:subjects,name,' . $id,
            'description' => 'string|max:65000|nullable',
        ])->validate();
        
        $subject = Subject::findOrFail($id);
        $subject->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        
        return SubjectResource::make($subject);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subject::whereId($id)->delete();
    }
}
