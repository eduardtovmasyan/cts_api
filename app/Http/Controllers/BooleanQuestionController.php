<?php

namespace App\Http\Controllers;

use Validator;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Resources\QuestionShort;
use App\Http\Resources\Question as BooleanQuestion;

class BooleanQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::where('type', Question::TYPE_BOOLEAN)->get();

        return QuestionShort::collection($questions);
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
            'topic_id' => 'required|exists:topics,id',
            'question' => 'required|string|max:65000',
            'answer' => 'required|boolean',
        ])->validate();
      
        $question = Question::create([
            'topic_id' => $request->topic_id,
            'type' => Question::TYPE_BOOLEAN,
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return BooleanQuestion::make($question);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::where('type', Question::TYPE_BOOLEAN)->findOrFail($id);

        return BooleanQuestion::make($question);
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
            'topic_id' => 'required|exists:topics,id',
            'question' => 'required|string|max:65000',
            'answer' => 'required|boolean',
        ])->validate();

        $question = Question::findOrFail($id);
        $question->update([
            'topic_id' => $request->topic_id,
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        
        return BooleanQuestion::make($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::where('type', Question::TYPE_BOOLEAN)->whereId($id)->delete();
    }
}
