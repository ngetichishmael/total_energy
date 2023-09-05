<?php

namespace App\Http\Controllers;

use App\Helpers\SMS;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NewPasswordRegistrationController extends Controller
{
    public function getNewPassword()
    {
        return view('auth.passwords.email');
    }
    public function checkPhoneNumber(Request $request)
    {
        $phone_number = $request->phone;
        $password = $request->password;

        // Check if the provided phone number exists in the users table
        $user = User::where('phone_number', $phone_number)->first();

        if ($user) {
            $message = "Your login information is username " . $user->email . ' and password ' . $password;
            (new SMS())($phone_number, $message);
            $user->update([
                'password' => Hash::make($password),
            ]);

            return redirect()->route('password.registration')->with('status', 'Password Send Password Has Been Sent.');
        } else {
            // Phone number does not exist
            return redirect()->back()->withErrors(['phone' => 'Phone number not found. Kindly request admin to update your phone number']);
        }
    }

}
