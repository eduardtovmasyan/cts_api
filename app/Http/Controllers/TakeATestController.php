<?php

namespace App\Http\Controllers;

use App\Test;
use App\Result;
use App\Answer;
use Illuminate\Http\Request;

class TakeATestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function TakeATest(Request $request)
    {
        $test_id = $request->test_id;
        $user_id = $request->user_id;
        $test = Test::findOrFail($test_id)->questions();
        $total = $test->count();
        $sum = 0;
        $answers = [];

        foreach ($request->answers as $i => $answer) {
            $testQuestion = Test::findOrFail($test_id)->questions()->where('question_id', $answer['question_id'])->first();

            if ($testQuestion->answer == $answer['answer'] ) {
                $sum += 1;
                $is_right = true;
            } else {
                $is_right = false;
            }

            $answers[] = [
                'question_id' => $answer['question_id'],
                'answer' => $answer['answer'],
                'is_right' => $is_right,
            ];
        }
        
        $score = round(($sum*100)/$total);
        $result = Result::create([
            'test_id' => $test_id,
            'user_id' => $user_id,
            'score' => $score,
        ]);

        foreach ($answers as $key) {
            $Results[] = Answer::make($key);
        }
        $result->answers()->saveMany($Results);

        return $score;
    }     
}
