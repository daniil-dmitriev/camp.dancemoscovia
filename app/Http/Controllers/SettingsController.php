<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Settings::find(1);
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
        $settings = Settings::find(1);
        if ($request->file()) {
            $file_name = time() . '_' . $request->image->getClientOriginalName();
            $file_path = $request->file('image')->storeAs('images', $file_name, 'public');
            $settings->image = './storage/' . $file_path;
            $settings->save();

            return [
                "status" => "success",
                "message" => "image was updated"
            ];
        }

        return [
            "status" => "false"
        ];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {

        $settings = Settings::find(1);

        try {
            $settings->name = $request->name;
            $settings->dates = $request->dates;
            $settings->place = $request->place;
            $settings->special_guests = $request->special_guests;
            $settings->step = $request->step;
            $settings->dates_array = $request->dates_array;
            $settings->save();
            
            return ["status" => "true", "message" => "Settings was succesfully updated!"];
        } catch (\Throwable $th) {
            return ["status" => "falls", "err" => $th];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
