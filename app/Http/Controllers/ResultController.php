<?php

namespace App\Http\Controllers;

use App\Result;
use Illuminate\Http\Request;
use App\Http\Resources\Answer;

class ResultController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param mixed $resultId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($resultId)
    {
        $result = Result::whereId($resultId)->answers();

        return Answer::collection($result);
    }
}
