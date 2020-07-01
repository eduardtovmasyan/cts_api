<?php

namespace App\Http\Controllers;

use App\Test;
use Validator;
use App\Result;
use App\Answer;
use Illuminate\Http\Request;

class TestingController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitResult(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'test_id' => 'required|exists:tests,id',
            'answers' => 'required|array',
            'answers.*.answer' => 'required|max:255',
            'answers.*.question_id' => 'required|exists:questions,id',
        ])->validate();

        $testQuestions = Test::findOrFail($request->test_id)->questions()->get()->toArray();
        $dbQuestions = [];
        $questions= [];
        $isRight = [];
        $totalScore = 0;
        $score = 0;

        foreach ($testQuestions as $key => $value) {
            $dbQuestions[] = [
                'question_id' => $value['pivot']['question_id'],
                'answer' => $value['answer'], 
                'score' => $value['pivot']['score']
            ];
        }

        foreach ($request->answers as $i => $answer) {
            $questions[] = [
                'question_id' => $answer['question_id'],
                'answer' => $answer['answer'], 
            ];
        }

        foreach ($dbQuestions as $i => $dbAnswer) {
            $totalScore += $dbAnswer['score'];

            foreach ($questions as $j => &$answer) {
                if ($i == $j) {
                    if ($dbAnswer['answer'] == $answer['answer']) {
                        $score += $dbAnswer['score'];
                        $answer['is_right'] = true;
                    } else {
                        $answer['is_right'] = false;
                    }
                }
            }
        }

        $testeeResult = round(($score/$totalScore)*100);
        $result = Result::create([
            'test_id' => $request->test_id,
            'user_id' => $request->user_id,
            'score' => $testeeResult,
        ]);

        foreach ($questions as $key) {
            $answers[] = Answer::make($key);
        }
        $result->answers()->saveMany($answers);

        if ($testeeResult == 100) {
            $message = ['Perfect' => $testeeResult];
        } 

        elseif ($testeeResult < 100 && $testeeResult > 89) {
            $message = ['Excellent' => $testeeResult];
        }

        elseif ($testeeResult < 90 && $testeeResult > 69) {
            $message = ['Good' => $testeeResult];
        }

        elseif ($testeeResult < 70 && $testeeResult > 50) {
            $message = ['A sufficient amount' => $testeeResult];
        }

        else{
            $message = ['Unacceptably' => $testeeResult];
        }

        return $message;
    }
}
