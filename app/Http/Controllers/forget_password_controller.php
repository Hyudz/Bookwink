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
        return view('forgot');
    }

    function forgot_password_post(Request $request){

        $request -> validate([
            'email' => 'required|email|exists:users_tables,email',
        ]);

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::send("emails.forget-password", ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset your password');
        });

        return redirect()->to(route('forgot_password'))->with('success', 'We have e-mailed your password reset link!');

    }

    function reset_password($token) {
        return view('new_password', compact('token'));
    }

    function reset_password_post(Request $request) {
        $request -> validate([
            "email" => "required|email|exists:users_tables,email",
            "password" => "required|string|min:6|confirmed",
            "password_confirmation" => "required",
        ]);

        $updatePassword = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

        if (!$updatePassword) {
            return redirect()->to(route('forgot_password'))->with('message', 'Invalid token!');
        }

        users_table::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();
        return redirect()->to(route('login'))->with('message', 'Your password has been changed!');

    }
}
