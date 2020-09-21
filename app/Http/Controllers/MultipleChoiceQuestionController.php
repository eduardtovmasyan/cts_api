<?php

namespace App\Http\Controllers;

use Validator;
use App\Question;
use App\QuestionOption;
use App\Http\Resources\OptionalQuestion;
use App\Http\Resources\OptionalQuestionShort;
use App\Http\Requests\CreateMultipleChoiceQuestionRequest;
use App\Http\Requests\UpdateMultipleChoiceQuestionRequest;

class MultipleChoiceQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::where('type', Question::TYPE_MULTIPLE_CHOICE)->paginate(parent::PER_PAGE);

        return OptionalQuestionShort::collection($questions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMultipleChoiceQuestionRequest $request)
    {
        $question = Question::create([
            'topic_id' => $request->topic_id,
            'type' => Question::TYPE_MULTIPLE_CHOICE,
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
        $question = Question::where('type', Question::TYPE_MULTIPLE_CHOICE)->findOrFail($id);

        return OptionalQuestion::make($question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMultipleChoiceQuestionRequest $request, $id)
    {
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
        Question::where('type', Question::TYPE_MULTIPLE_CHOICE)->whereId($id)->delete();
    }
}
