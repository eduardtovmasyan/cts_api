<?php

namespace App\Http\Controllers;

use Validator;
use App\Question;
use App\QuestionOption;
use Illuminate\Http\Request;
use App\Http\Resources\Question as QuestionResource;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::all();

        return QuestionResource::collection($questions);
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
            'options' => 'required|array',
        ])->validate();
      
        $question = Question::create([
            'topic_id' => $request->topic_id,
            'type' => Question::TYPE_ONE_CHOICE,
            'question' => $request->question,
        ]);
        $options = [];
        $timeNow = now();
        
        foreach ($request->options as $option) {
            $options[] = [
                'question_id' => $question->id,
                'option' => $option['option'],
                'is_right' => $option['is_right'],
                'created_at' => $timeNow,
                'updated_at' => $timeNow,
            ];
        }

        Validator::make($options, [
            '*.option' => 'required|max:100',
            '*.is_right' => 'required|boolean',
        ])->validate();
        $question->options()->insert($options);

        return QuestionResource::make($question);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);

        return QuestionResource::make($question);
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
            'type' => 'required',
            'question' => 'required|string|max:65000',
            'options' => 'required|array',
        ])->validate();
        
        $question = Question::findOrFail($id);
        $question->update([
            'topic_id' => $request->topic_id,
            'type' => $request->type,
            'question' => $request->question,
        ]);
        $options = [];
        
        foreach ($request->options as $option) {
            $options[] = [
                'question_id' => $question->id,
                'option' => $option['option'],
                'is_right' => $option['is_right'],
                'created_at' => $question->created_at,
                'updated_at' => now(),
            ];
        }

        Validator::make($options, [
            '*.option' => 'required|max:100',
            '*.is_right' => 'required|boolean',
        ])->validate();

        $question->options()->delete();
        $question->options()->insert($options);

        return QuestionResource::make($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::whereId($id)->delete();
    }
}
