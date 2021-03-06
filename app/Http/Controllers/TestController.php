<?php

namespace App\Http\Controllers;

use App\Test;
use Validator;
use App\TestQuestion;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\TestShort;
use App\Rules\ValidTestQuestionTopic;
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

        return TestShort::collection($tests);
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
            'group_id' => 'nullable|exists:groups,id',
            'start' => 'required|date|after:now',
            'end' => 'required|date|after:start',
            'description' => 'nullable|string|max:65000',
            'title' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.score' => 'required|integer|between:1,100',
            'questions.*.id' => [
                'required', 'exists:questions,id',  new ValidTestQuestionTopic($request->subject_id)
            ],
        ])->validate();

        $questions = [];

        foreach ($request->questions as $i => $question) {
            $questions[$question['id']] = ['score' => $question['score']];
        }

        $test = Test::create([
            'subject_id' => $request->subject_id,
            'group_id' => $request->group_id,
            'start' => $request->start,
            'end' => $request->end,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $test->questions()->attach($questions);

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
            'group_id' => 'nullable|exists:groups,id',
            'start' => 'required|date|after:now',
            'end' => 'required|date|after:start',
            'description' => 'nullable|string|max:65000',
            'title' => 'required|string|max:255',
            'questions' => 'required|array',
            'questions.*.score' => 'required|integer|between:1,100',
            'questions.*.id' => [
                'required', 'exists:questions,id',  new ValidTestQuestionTopic($request->subject_id)
            ],
        ])->validate();

        $questions = [];

        foreach ($request->questions as $i => $question) {
            $questions[$question['id']] = ['score' => $question['score']];
        }

        $test = Test::findOrFail($id);
        $test->update([
            'subject_id' => $request->subject_id,
            'group_id' => $request->group_id,
            'start' => $request->start,
            'end' => $request->end,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        $test->questions()->sync($questions);

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
