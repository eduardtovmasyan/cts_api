<?php

namespace App\Http\Controllers;

use App\Test;
use Validator;
use App\Answer;
use App\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Result as ResultResource;

class ResultController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param mixed $resultId
     *
     * @return \Illuminate\Http\Response
     */
    public function show($resultId)
    {
        $result = Result::whereId($resultId)->paginate(parent::PER_PAGE);

        return ResultResource::collection($result);
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
            'test_id' => 'required|exists:tests,id',
            'answers' => 'required|array',
            'answers.*.answer' => 'required|max:255',
            'answers.*.question_id' => 'required|exists:questions,id',
        ])->validate();

        $test = Test::findOrFail($request->test_id);
        $questions = $test->questions;
        $score = $totalScore = 0;
        $answers = [];

        foreach ($request->answers as $answer) {
            $answers[$answer['question_id']] = Answer::make([
                'answer' => $answer['answer'],
                'question_id' => $answer['question_id'],
                'is_right' => false,
            ]);
        }

        foreach ($questions as $key => $question) {
            $totalScore += $question->pivot->score;

            if (isset($answers[$question->id]) && $answers[$question->id]->answer == $question->answer) {
                $score += $question->pivot->score;
                $answers[$question->id]->is_right = true;
            }
        }

        $score = round(($score / $totalScore) * 100);
        $result = $test->results()->create(['user_id' => Auth::id(), 'score' => $score]);
        $result->answers()->saveMany($answers);

        return ResultResource::make($result);
    }
}
