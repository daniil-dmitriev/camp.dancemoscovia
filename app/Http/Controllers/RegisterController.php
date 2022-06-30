<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Register;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Register::all();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $register = Register::find($id);

        $coach = Coach::where("name", $register->coach)->firstOrFail();
        $coach->available_hours += $register->taked_hours;
        $coach->save();

        $register->delete();

        return [
            "status" => "success",
            "message" => "This registration has been removed successfully"
        ];
    }

    public function getCorrectRecordPrice(Request $request)
    {
        $member_main = $request->all();
        $type = "couple";

        if ($member_main['1']['name'] == "") {
            $type = "solo";
        }

        if (!is_numeric($member_main['0']['name']) && !is_numeric($member_main['1']['name']) && $type == "couple") {
            return "COUPLE, NOT NUMERIC";
        }

        if (!is_numeric($member_main['0']['name']) && $type == "solo") {
            return "SOLO, NOT NUMERIC";
        }

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('./storage/xlsx/coaches_and_members.xlsx');
            $sheet = $spreadsheet->getActiveSheet();

            $maxRow = $sheet->getHighestDataRow();

            $maleNumbers = $sheet->rangeToArray('O3:S' . $maxRow, null, true, true, true);
            $femaleNumbers = $sheet->rangeToArray('T3:X' . $maxRow, null, true, true, true);
            $members = array_merge($maleNumbers, $femaleNumbers);

            $maleCategory = "";
            $femaleCategory = "";

            $male_name = "";
            $male_birthdate = "";
            $male_age = "";

            $female_name = "";
            $female_birthdate = "";
            $female_age = "";

            foreach ($maleNumbers as $member => $value) {
                if ($value['O'] == $member_main['0']['name']) {
                    $maleCategory = $value['Q'];
                    $male_name = $value['P'];
                    $male_birthdate = $value['R'];
                    $male_age = $value['S'];

                    $femaleCategory = $femaleNumbers[$member]['V'];
                    $female_name = $femaleNumbers[$member]['U'];
                    $female_birthdate = $femaleNumbers[$member]['W'];
                    $female_age = $femaleNumbers[$member]['X'];

                    break;
                }
            }


            if ($maleCategory == "") {
                foreach ($femaleNumbers as $member => $value) {
                    if ($value['T'] == $member_main['0']['name']) {
                        $maleCategory = $value['V'];
                        $male_name = $value['U'];
                        $male_birthdate = $value['W'];
                        $male_age = $value['X'];
                        break;
                    }
                }
            }

            if ($maleCategory == "") {
                return;
            }


            $coach_price_list = [];


            $coach_list = $sheet->rangeToArray("A3:M20", null, true, true, true);
            foreach ($coach_list as $coach => $value) {
                array_push($coach_price_list, [
                    "name" => $value['A'],
                    "A" => $value['B'],
                    "B" => $value['D'],
                    "C" => $value['F'],
                    "D" => $value['H'],
                    "Z" => $value['L']
                ]);
            }

            /*
            male and female categories
            coach list
            solo => coach['category'] -> return new pricelist
            couple => coach ['maleCategory'] / 2 + coach['femaleCategory'] / 2 -> return new priceList
            problem is price details
*/
            
            $coach_list = [];
            if (!$female_name) {
                foreach ($coach_price_list as $coach_price => $value) {
                    array_push($coach_list, [
                        "name" => $value["name"],
                        "price" => $value[$maleCategory]
                    ]);
                }
                $members = [
                    [
                        "name" => $male_name,
                        "birthdate" => $male_birthdate,
                        "age" => $male_age
                    ]
                ];

                return ["status" => true, "coaches" => $coach_list, "type" => $type, "members" => $members];
            }

            foreach ($coach_price_list as $coach_price => $value) {
                array_push($coach_list, [
                    "name" => $value["name"],
                    "price" => $value[$maleCategory] / 2 + $value[$femaleCategory] / 2,
                    'malePrice' => $value[$maleCategory] / 2,
                    'femalePrice' => $value[$femaleCategory] / 2
                ]);
            }

            $members = [
                [
                    "name" => $male_name,
                    "birthdate" => $male_birthdate,
                    "age" => $male_age
                ],
                [
                    "name" => $female_name,
                    "birthdate" => $female_birthdate,
                    "age" => $female_age
                ]
            ];


            return ["status" => true, "coaches" => $coach_list, "type" => $type, "members" => $members];
        } catch (\Throwable $th) {
            return;
        }
    }
}
