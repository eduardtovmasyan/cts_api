<?php

namespace App\Http\Controllers;

use App\Result;
use Illuminate\Http\Request;
use App\Http\Resources\Result as ResultResource;

class TestResultController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param mixed $testId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($testId)
    {
        $testResults = Result::where('test_id', $testId)->paginate(parent::PER_PAGE);

        return ResultResource::collection($testResults);
    }
}
