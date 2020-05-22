<?php

namespace App\Http\Controllers;

use Validator;
use App\Test;
use App\TestQuestion;
use Illuminate\Http\Request;
use App\Rules\ValidTestQuestionsTopic;
use App\Rules\ValidTestQuestionsTotalScore;
use App\Http\Resources\Test as TestResource;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tests = Test::paginate(parent::PER_PAGE);

        return TestResource::collection($tests);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'subject_id' => 'required|exists:subjects,id',
            'group_id' => 'required|nullable|exists:groups,id',
            'start' => 'required|date|after:now',
            'end' => 'required|date|after:start',
            'description' => 'required|string|max:65000|nullable',
            'title' => 'required|string|max:255',
            'questions' => [
                'required', 'array', new ValidTestQuestionsTotalScore, new ValidTestQuestionsTopic
            ],
            'questions.*.score' => 'required|integer|between:1,100',
            'questions.*.question_id' => 'required|exists:questions,id',
        ])->validate();
      
        $test = Test::create([
            'subject_id' => $request->subject_id,
            'group_id' => $request->group_id,
            'start' => $request->start,
            'end' => $request->end,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        $test->questions()->attach($request->questions);

        return TestResource::make($test);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $test = Test::findOrFail($id);

        return TestResource::make($test);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'subject_id' => 'required|exists:subjects,id',
            'group_id' => 'required|nullable|exists:groups,id',
            'start' => 'required|date|after:now',
            'end' => 'required|date|after:start',
            'description' => 'required|string|max:65000|nullable',
            'title' => 'required|string|max:255',
            'questions' => [
                'required', 'array', new ValidTestQuestionsTotalScore, new ValidTestQuestionsTopic
            ],
            'questions.*.score' => 'required|integer|between:1,100',
            'questions.*.question_id' => 'required|exists:questions,id',
        ])->validate();
        
        $test = Test::findOrFail($id);
        $test->update([
            'subject_id' => $request->subject_id,
            'group_id' => $request->group_id,
            'start' => $request->start,
            'end' => $request->end,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        $test->questions()->sync($request->questions);

        return TestResource::make($test);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Test::whereId($id)->delete();
    }
}
