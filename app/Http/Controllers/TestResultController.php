<?php

namespace App\Http\Controllers;

use App\User;
use App\Test;
use App\Result;
use Illuminate\Http\Request;
use App\Http\Resources\Result as ResultDetails;
use App\Http\Resources\TestResult;
use App\Http\Resources\TesteeTestResult;

class TestResultController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function getTestResultById($id)
    {
        $testResults = Test::findOrFail($id)->with('results')->get();

        return TestResult::collection($testResults);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function getTesteeResult($id)
    {
        $testResults = User::where('type', User::TYPE_TESTEE)->with('results')->whereId($id)->get();

        return TesteeTestResult::collection($testResults);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function getGroupResult($id)
    {
        $testResults = Test::where('group_id', $id)->with('results')->get();

        return TestResult::collection($testResults);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function getResultDetails($id)
    {
        $result = Result::whereId($id)->with('answers')->get();

        return ResultDetails::collection($result);
    }
}

