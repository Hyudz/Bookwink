<?php

namespace App\Http\Controllers;

use App\Models\users_table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class forget_password_controller extends Controller
{
    function forgot_password() {
        //ETO YUNG PAG CLICK NG FORGOT PASSWORD
        return view('forgot');
    }

    function forgot_password_post(Request $request){

        //ETO NAMAN YUNG FUNCTION PAG PININDOT YUNG SUBMIT AFTER MAG-INPUT NG EMAIL

        $request -> validate([
            'email' => 'required|email|exists:users_tables,email',
        ]);

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::send("emails.forget-password", ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset your password');
        });

        return redirect()->to(route('forgot_password'))->with('success', 'We have e-mailed your password reset link!');

    }

    function reset_password($token, $email) {
        //ETO YUNG FUNCTION PAG NAG-CLICK YUNG USER SA LINK NA NAKA-EMAIL SA KANYA
        return view('new_password', compact('token', 'email'));
    }

    function reset_password_post(Request $request) {
        //ETO NAMAN YUNG SA CHANGE PASSWORD NG USER
        $request -> validate([
            "password" => "required|string|min:6|confirmed",
            "password_confirmation" => "required",
        ]);

        $updatePassword = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

        if (!$updatePassword) {
            return redirect()->to(route('forgot_password'))->with('error', 'Invalid token!');
        }

        users_table::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        return redirect()->to(route('login'))->with('success', 'Your password has been changed!');

    }
}
