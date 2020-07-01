<?php

namespace App\Http\Controllers;

use App\User;
use App\Result;
use Illuminate\Http\Request;
use App\Http\Resources\Result as ResultResource;

class TesteeResultController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param mixed $userId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $testeeResults = Result::where('user_id', $userId)
            ->paginate(parent::PER_PAGE);

        return ResultResource::collection($testeeResults);
    }
}
