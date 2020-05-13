<?php

namespace App\Http\Controllers;

use Validator;
use App\Question;
use App\QuestionOption;
use Illuminate\Http\Request;
use App\Rules\ValidOneChoiceOptions;
use App\Http\Resources\OptionalQuestion;
use App\Http\Resources\OptionalQuestionShort;

class OneChoiceQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::where('type', Question::TYPE_ONE_CHOICE)->get();

        return OptionalQuestionShort::collection($questions);
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
            'options' => [
                'required', 'array', new ValidOneChoiceOptions
            ],
            'options.*.option' => 'required|max:100',
            'options.*.is_right' => 'required|boolean',
        ])->validate();
      
        $question = Question::create([
            'topic_id' => $request->topic_id,
            'type' => Question::TYPE_ONE_CHOICE,
            'question' => $request->question,
        ]);

        foreach ($request->options as $option) {
            $options[] = QuestionOption::make($option);
        }

        $question->options()->saveMany($options);

        return OptionalQuestion::make($question);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::where('type', Question::TYPE_ONE_CHOICE)->findOrFail($id);

        return OptionalQuestion::make($question);
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
            'options' => [
                'required', 'array', new ValidOneChoiceOptions
            ],
            'options.*.option' => 'required|max:100',
            'options.*.is_right' => 'required|boolean',
        ])->validate();
        
        $question = Question::findOrFail($id);

        foreach ($request->options as $option) {
            $options[] = QuestionOption::make($option);
        }

        $question->update([
            'topic_id' => $request->topic_id,
            'question' => $request->question,
        ]);
        $question->options()->delete();
        $question->options()->saveMany($options);
        
        return OptionalQuestion::make($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::where('type', Question::TYPE_ONE_CHOICE)->AndMultiplywhereId($id)->delete();
    }
}
