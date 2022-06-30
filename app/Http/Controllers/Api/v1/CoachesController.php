<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coach;
use Illuminate\Support\Facades\Validator;


class CoachesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Coach::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "name" => ["required"],
                "price" => ["required"],
                "working_hours" => ["required"],
                "program" => ["required"]
            ]
        );

        if ($validator->fails()) {
            return [
                "status" => "falls",
                "errors" => $validator->errors()
            ];
        }

        $coach = Coach::create([
            "name" => $request->name,
            "currency" => $request->currency,
            "price" => $request->price,
            "working_hours" => $request->working_hours,
            "available_hours" => $request->available_hours,
            "comments" => $request->comments,
            "regalia" => $request->regalia,
            "program" => $request->program,
        ]);

        return [
            "status" => "true",
            "coach" => $coach
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = Validator::make(
            $request->all(),
            [
                "name" => ["required"],
                "price" => ["required"],
                "working_hours" => ["required"],
                "program" => ["required"]
            ]
        );

        if ($validator->fails()) {
            return [
                "status" => "falls",
                "errors" => $validator->errors()
            ];
        }

        $coach = Coach::find($id);

        $coach->name = $request->name;
        $coach->currency = $request->currency;
        $coach->price = $request->price;
        $coach->available_hours -= $coach->working_hours - $request->working_hours;
        $coach->working_hours = $request->working_hours;
        $coach->comments = $request->comments;
        $coach->regalia = $request->regalia;
        $coach->program = $request->program;

        $coach->save();

        return [
            "status" => "true",
            "coach" => $coach
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coach = Coach::find($id);
        $coach->delete();

        return [
            "status" => "success",
            "message" => "coach was deleted"
        ];
    }
}
