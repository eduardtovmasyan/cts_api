<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use App\Http\Resources\Answer as AnswerResource;

class ResultAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param mixed $resultId
     * @return \Illuminate\Http\Response
     */
    public function index($resultId)
    {
        $answers = Answer::where('result_id', $resultId)->paginate(parent::PER_PAGE);

        return AnswerResource::collection($answers);
    }
}
