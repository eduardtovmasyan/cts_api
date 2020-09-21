<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use Validator;
use App\Http\Requests\CreateTesteeRequest;
use App\Http\Requests\UpdateTesteeRequest;
use App\Http\Resources\Testee as TesteeResource;

class TesteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testee = User::whichTestee()->paginate(parent::PER_PAGE);

        return TesteeResource::collection($testee);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTesteeRequest $request)
    {
        $testee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->is_active,
            'group_id' => $request->group_id,
            'type' => User::TYPE_TESTEE,
            'password' => Hash::make($request->password),
        ]);

        return TesteeResource::make($testee);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $testee = User::whichTestee()->findOrFail($id);

        return TesteeResource::make($testee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTesteeRequest $request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|numeric|unique:users,phone,' . $id,
            'password' => 'required|min:6',
            'is_active' => 'required|boolean',
            'group_id' => 'required|exists:groups,id',
        ])->validate();

        $testee = User::whichTestee()->findOrFail($id);
        $testee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => $request->is_active,
            'group_id' => $request->group_id,
            'password' => Hash::make($request->password),
        ]);

        return TesteeResource::make($testee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::whichTestee()->whereId($id)->delete();
    }
}
