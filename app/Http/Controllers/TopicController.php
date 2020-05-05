<?php

namespace App\Http\Controllers;

use Validator;
use App\Topic;
use Illuminate\Http\Request;
use App\Http\Resources\Topic as TopicResource;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::paginate(parent::PER_PAGE);

        return TopicResource::collection($topics);
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
            'name' => 'required|max:100|unique:topics,name',
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'nullable',
        ])->validate();

        $topic = Topic::create([
            'name' => $request->name,
            'subject_id' => $request->subject_id,
            'description' => $request->description,
        ]);

        return TopicResource::make($topic);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Topic::findOrFail($id);

        return TopicResource::make($topic);
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
            'name' => 'required|max:100|unique:topics,name,' . $id,
            'subject_id' => 'required|exists:subjects,id',
            'description' => 'nullable',
        ])->validate();

        Topic::whereId($id)->update([
            'name' => $request->name,
            'subject_id' => $request->subject_id,
            'description' => $request->description,
        ]);

        $topic = Topic::findOrFail($id);

        return TopicResource::make($topic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Topic::whereId($id)->delete();
    }
}
