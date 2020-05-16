<?php

namespace App\Http\Controllers;

use Validator;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Resources\Question as ShortAnswerQuestion;
use App\Http\Resources\QuestionShort;

class ShortAnswerQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::where('type', Question::TYPE_SHORT_ANSWER)->get();

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
            'answer' => 'required|max:50',
        ])->validate();
      
        $question = Question::create([
            'topic_id' => $request->topic_id,
            'type' => Question::TYPE_SHORT_ANSWER,
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return ShortAnswerQuestion::make($question);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::where('type', Question::TYPE_SHORT_ANSWER)->findOrFail($id);

        return ShortAnswerQuestion::make($question);
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
            'answer' => 'required|max:50',
        ])->validate();

        $question = Question::findOrFail($id);
        $question->update([
            'topic_id' => $request->topic_id,
            'question' => $request->question,
            'answer' => $request->answer,
        ]);
        
        return ShortAnswerQuestion::make($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::where('type', Question::TYPE_SHORT_ANSWER)->whereId($id)->delete();
    }
}
