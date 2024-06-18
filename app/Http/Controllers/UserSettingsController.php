<?php

namespace App\Http\Controllers;

use App\Models\UserSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSettingsController extends Controller
{
    public function NewPassword()
    {
        return view('users.cambiar_contraseña');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $userPassword = $user->password;

        if ($request->password_actual != "") {
            $NuewPass = $request->password;
            $confirPass = $request->confirm_password;

            if (Hash::check($request->password_actual, $userPassword)) {
                if ($NuewPass == $confirPass) {
                    if (strlen($NuewPass) >= 6) {
                        $user->password = Hash::make($request->password);
                        $sqlBD = DB::table('users')
                            ->where('id', $user->id)
                            ->update(['password' => $user->password]);

                        return redirect()->back()->with('updateClave', 'La clave fue cambiada correctamente.');
                    } else {
                        return redirect()->back()->with('clavemenor', 'Recuerde que la clave debe ser mayor a 6 caracteres.');
                    }
                } else {
                    return redirect()->back()->with('claveIncorrecta', 'Por favor, verifique que las claves no coinciden.');
                }
            } else {
                return back()->withErrors(['password_actual' => 'La clave no coincide.']);
            }
        } else {
            return redirect()->back()->with('updateClave', 'La clave fue cambiada correctamente.');
        }
    }
}