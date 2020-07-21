<?php

namespace App\Http\Controllers;

use Validator;
use App\Topic;
use App\Http\Requests\CreateTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
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
    public function store(CreateTopicRequest $request)
    {
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
    public function update(UpdateTopicRequest $request, $id)
    {
        $topic = Topic::findOrFail($id);
        $topic->update([
            'name' => $request->name,
            'subject_id' => $request->subject_id,
            'description' => $request->description,
        ]);

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
