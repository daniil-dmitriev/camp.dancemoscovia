<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Register;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//php office dependence
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SpreadsheetController extends Controller
{
    public function createCoachReport(Request $request)
    {
        // phpOffice initialize
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // header of report
        $sheet = SpreadsheetController::headerRegister($sheet, ["Педагог", "Танцор", "Категория", "Кол-во уроков", "Стоимость", "Комментарии", "Дата заявки"]);


        // fill data
        $sheet = SpreadsheetController::fillRegisterByCoach($sheet);


        // add style
        $sheet = SpreadsheetController::styleRegister($sheet);


        // save and download report from storage
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/xlsx/' . $request->filename);

        return Storage::download('public/xlsx/' . $request->filename);
    }

    public function addCampInfoFromExcel(Request $request)
    {
        $path = "";
        if ($request->file()) {
            $file_name = $request->xlsx->getClientOriginalName();
            $file_path = $request->file('xlsx')->storeAs('xlsx', $file_name, 'public');
            $path = "./storage/" . $file_path;
        }

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();

        $maxRow = $sheet->getHighestRow();
        // Store coaches data from the activeSheet to the varibale in the form of Array
        $data = $sheet->rangeToArray('A5:G' . $maxRow, null, true, true, true);
        foreach ($data as $coach) {
            if (!Coach::where('name', $coach['A'])->first()) {
                Coach::create([
                    "name" => trim($coach['A']),
                    "program" => $coach['B'],
                    "currency" => $coach['C'],
                    "price" => $coach['D'],
                    "working_hours" => $coach['E'],
                    "available_hours" => $coach['E'],
                    "regalia" => $coach['F'],
                    "comments" => $coach['G'],
                ]);
            } else {
                $databaseCoach = Coach::where('name', $coach['A'])->first();
                $databaseCoach->update([
                    "name" => $coach['A'],
                    "program" => $coach['B'],
                    "currency" => $coach['C'],
                    "price" => $coach['D'],
                    "regalia" => $coach['F'],
                    "comments" => $coach['G'],
                ]);
            }
        }

        // store camp info from the activeSheet 
        $camp_info = $sheet->rangeToArray('A2:G2', null, true, true, true);
        $settings = Settings::find(1);
        $settings->name = $camp_info[2]['A'];
        $settings->dates = $camp_info[2]['B'];
        $settings->dates_array = $camp_info[2]['C'];
        $settings->place = $camp_info[2]['D'];
        $settings->step = $camp_info[2]['E'];
        $settings->special_guests = $camp_info[2]['F'];
        $settings->tarifs = $camp_info[2]['G'];

        $settings->save();

        return ["status" => "success", "message" => "xlsx file has been succesfully upload"];
    }

    public function addMoscoviaFromExcel(Request $request)
    {
        $path = "";
        if ($request->file()) {
            $file_name = "coaches_and_members.xlsx";
            $file_path = $request->file('xlsx')->storeAs('xlsx', $file_name, 'public');
            $path = "./storage/" . $file_path;
        }

        return ["status" => true];
    }

    public function addCoachPrice(Request $request)
    {
        // ading coach_price.pdf file to storage
        $path = "";
        if ($request->file()) {
            $file_name = $request->pdf->getClientOriginalName();
            $file_path = $request->file('pdf')->storeAs('pdf', $file_name, 'public');
            $path = "./storage/" . $file_path;

            $settings = Settings::find(1);
            $settings->coach_price = $path;
            $settings->save();
        }

        return ["status" => "success", "message" => "xlsx file has been succesfully upload"];
    }

    public function createVisitorReport(Request $request)
    {
        // phpOffice initialize
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();


        // header of report
        $sheet = SpreadsheetController::headerRegister($sheet, ["Танцор", "Педагог", "Категория", "Кол-во уроков", "Стоимость", "Комментарии", "Дата заявки"]);

        // fill data
        $sheet = SpreadsheetController::fillRegisterByVisitor($sheet);


        // add style
        $sheet = SpreadsheetController::styleRegister($sheet);


        // save and download report from storage
        $writer = new Xlsx($spreadsheet);
        $writer->save('storage/xlsx/' . $request->filename);

        return Storage::download('public/xlsx/' . $request->filename);
    }
    ////////////////////////
    // REGISTER FUNCTIONS //
    ////////////////////////
    public static function headerRegister($sheet, $array)
    {
        $sheet->fromArray($array, NULL, "A1");

        return $sheet;
    }
    public static function styleRegister($sheet)
    {
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF'
                ],
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'rotation' => 90,
                'startColor' => [
                    'rgb' => '850252',
                ],
            ],
        ];
        $bodyStyle = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);
        $sheet->getStyle($sheet->calculateWorksheetDimension())->applyFromArray($bodyStyle);
        // $sheet->getColumnDimensions()->setAutoSize(true);
        foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
            if ($col !== 'F') {
                $sheet
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
            } else {
                $sheet
                    ->getColumnDimension($col)
                    ->setWidth(50);
                $sheet->getStyle('F2:F' . $sheet->getHighestDataRow())->getAlignment()->setWrapText(true);
            }
        }


        return $sheet;
    }
    public static function fillRegisterByCoach($sheet)
    {
        $coaches = Coach::all();
        $row = 1;

        foreach ($coaches as $coach) {
            $hours_count = 0;
            $price_count = 0;

            if ($coach->working_hours !== $coach->available_hours) {
                $row++;

                $coach_registers = Register::where('coach', $coach->name)->get();

                foreach ($coach_registers as $register) {
                    $arr_from_obj = [$register->coach, $register->dancers, $register->category, $register->taked_hours, $register->price, $register->comments, $register->created_at];

                    $sheet->fromArray($arr_from_obj, NULL, 'A' . $row);

                    $hours_count += $register->taked_hours;
                    $price_count += $register->price;
                    $row++;
                }

                $sheet->setCellValue('D' . $row, $hours_count);
                $sheet->setCellValue('E' . $row, $price_count);
                $sheet->getStyle('A' . $row . ":G" . $row)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '8FBC8F'
                        ]
                    ]
                ]);
                $row++;
            }
        }

        return $sheet;
    }
    public static function fillRegisterByVisitor($sheet)
    {
        $users = User::all()->except('Auth::id()');
        $row = 1;

        foreach ($users as $user) {
            $hours_count = 0;
            $price_count = 0;

            $row++;

            $user_registers = Register::where('dancers', $user->name)->get();

            if (count($user_registers) > 0) {
                foreach ($user_registers as $register) {
                    $arr_from_obj = [$register->dancers, $register->coach, $register->category, $register->taked_hours, $register->price, $register->comments, $register->created_at];

                    $sheet->fromArray($arr_from_obj, NULL, 'A' . $row);

                    $hours_count += $register->taked_hours;
                    $price_count += $register->price;
                    $row++;
                }

                $sheet->setCellValue('D' . $row, $hours_count);
                $sheet->setCellValue('E' . $row, $price_count);
                $sheet->getStyle('A' . $row . ":G" . $row)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '8FBC8F'
                        ]
                    ]
                ]);
            } else {
                $arr_from_obj = [
                    $user->name, "", $user->category, 0,
                    $user->comments, $user->created_at
                ];
                $sheet->fromArray($arr_from_obj, NULL, 'A' . $row);

                $sheet->setCellValue('D' . $row, $hours_count);
                $sheet->getStyle('A' . $row . ":G" . $row)->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '8FBC8F'
                        ]
                    ]
                ]);
            }
            $row++;
        }

        return $sheet;
    }
}
