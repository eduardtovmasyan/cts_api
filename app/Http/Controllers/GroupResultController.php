<?php

namespace App\Http\Controllers;

use App\Result;
use App\Http\Resources\Result as ResultResource;

class GroupResultController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param mixed $groupId
     *
     * @return \Illuminate\Http\Response
     */
    public function index($groupId)
    {
        $groupResults = Result::leftJoin('tests', 'tests.id', '=', 'results.test_id')
            ->where('group_id', $groupId)
            ->paginate(parent::PER_PAGE);

        return ResultResource::collection($groupResults);
    }
}
