<?php

namespace App\Http\Controllers;

use App\User;
use App\Test;
use Illuminate\Http\Request;
use App\Http\Resources\TestResult;

class AdminTestResultController extends Controller
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
        $testResults = User::with('results')->whereId($id)->get();

        return TestResult::collection($testResults);
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
}
