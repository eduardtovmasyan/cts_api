<?php

namespace App\Http\Controllers;

use App\User;
use App\Test;
use Illuminate\Http\Request;
use App\Http\Resources\AdminTestResult;

class AdminTestResultController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetTestResultById($id)
    {
        $TestResults = Test::findOrFail($id)->with('results')->get();

        return AdminTestResult::collection($TestResults);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetTesteeResult($id)
    {
        $TestResults = User::with('results')->whereId($id)->get();

        return AdminTestResult::collection($TestResults);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function GetGroupResult($id)
    {
        $TestResults = Test::where('group_id', $id)->with('results')->get();

        return AdminTestResult::collection($TestResults);
    }
}
