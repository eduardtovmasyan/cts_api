<?php

namespace App\Http\Controllers;

use App\Test;
use Validator;
use App\Answer;
use App\Result;
use App\Question;
use App\AnswerOption;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Result as ResultResource;

class ResultController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param mixed $resultId
     * @return \Illuminate\Http\Response
     */
    public function show($resultId)
    {
        $result = Result::findOrFail($resultId);

        return ResultResource::make($result);
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
            'answers.*.answer' => 'required',
            'answers.*.question_id' => [
                'required',
                Rule::exists('test_questions')->where(function ($query) use ($request) {
                    $query->where('test_id', $request->test_id);
                }),
            ],
        ])->validate();

        $test = Test::findOrFail($request->test_id);
        $questions = $test->questions;
        $score = $totalScore = 0;
        $answers = [];
        $answersOptions = [];

        foreach ($request->answers as $answer) {
            $answers[$answer['question_id']] = Answer::make([
                'answer' => $answer['answer'],
                'question_id' => $answer['question_id'],
                'is_right' => false,
            ]);
        }

        foreach ($questions as $key => $question) {
            $totalScore += $question->pivot->score;
            $answer = $answers[$question->id] ?? null;

            if ($answer) {
                $answer->is_right = $question->isCorrectAnswer($answer->answer);

                if ($answer->is_right) {
                    $score += $question->pivot->score;
                }

                if ($question->isOptional()) {
                    $answersOptions[$question->id] = is_array($answer->answer)
                        ? $answer->answer : [$answer->answer];
                    $answer->answer = null;
                }
            } else {
                $answers[$question->id] = Answer::make([
                    'question_id' => $answer['question_id'],
                    'is_right' => false,
                ]);
            }
        }

        $score = round(($score / $totalScore) * 100);
        $result = $test->results()->create(['user_id' => Auth::id(), 'score' => $score]);
        $result->answers()->saveMany($answers);
        $optionsInsertData = [];

        foreach ($result->answers as $answer) {
            if (!empty($answersOptions[$answer->question_id])) {
                foreach ($answersOptions[$answer->question_id] as &$optionId) {
                    $optionsInsertData[] = [
                        'option_id' => $optionId,
                        'answer_id' => $answer->id,
                    ];
                }
            }
        }

        AnswerOption::insert($optionsInsertData);

        return ResultResource::make($result);
    }
}
