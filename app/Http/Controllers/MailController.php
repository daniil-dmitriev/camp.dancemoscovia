<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\Coach;
use App\Models\Register;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $details = [
            'main' => $request->main,
            'club' => $request->club,
            'hotel' => $request->hotel,
            'category' => $request->category,
            'dates' => $request->dates,
            'tax' => $request->tax,
            'companions' => $request->companions,
            'companions_info' => $request->companions_info,
            'email' => $request->email,
            'comments' => $request->comments,
            'coaches' => $request->coaches,
            'camp_cost' => $request->camp_cost
        ];

        $content = null;
        
        // if (User::where('email', $details['email'])->first()) {
        //     return ["status" => false, "message" => "Этот электронный адрес уже используется!"];
        // }
        // validation
        if ($details['main'][0]['name'] && $details['main'][0]['birthdate'] && $details['club']['name'] && $details['club']['city'] && $details['category'] && $details['dates'][0] && $details['email'] && $details['tax']) {

            if ($request->type == "couple") {
                $member_names = implode(', ', array_column($request->main, 'name'));
            } else {
                $member_names = $details['main'][0]['name'];
            }

        
        

            foreach ($details['coaches'] as $key => $coaches) {
                $coach = Coach::find($coaches['id']);
                Register::create([
                    'coach' => $coach->name,
                    'dancers' => $member_names,
                    'taked_hours' => $coaches['taked_hours'],
                    'category' => $details['category'],
                    'comments' => $details['comments'],
                    'price' => $coaches['price'] * $coaches['taked_hours']
                ]);
                if ($coach->available_hours <= $coaches['taked_hours']) {
                    $details['coaches'][$key]['taked_hours'] = $coach->available_hours;
                    $coach->available_hours = 0;
                    $coach->closed = 1;
                    $coach->save();
                } else {
                    $coach->available_hours = $coach->available_hours - $coaches['taked_hours'];
                    $coach->save();
                }
            }
            User::create([
                'email' => $details['email'],
                'name' => $member_names,
                'password' => Hash::make('qwertyasdfgh'),
                'comments' => $details['comments'],
                'category' => $details['category']
            ]);

            Mail::to(trim($details['email']))->send(new TestMail($details));
            Mail::to('daniildmitriev8@yandex.ru')->send(new TestMail($details));
            Mail::to('dancecampmoscovia@mail.ru')->send(new TestMail($details));
            
            return ["status" => true];
        } else {
            return ["status" => false, "message" => "Заполнены не все поля!"];
        }
    }
}
