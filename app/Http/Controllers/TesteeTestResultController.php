<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesteeTestResultController extends Controller
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
}
