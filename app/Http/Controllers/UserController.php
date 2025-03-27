<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $companies = Company::all();
        return view('catalogs.users', compact('users', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'company_id' => 'required|integer',
            'password' => 'required|string|min:8|confirmed', // Confirmación de contraseña
            'admin' => 'required|integer|in:0,1',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->company_id = $request->input('company_id');
        $user->password = Hash::make($request->input('password'));
        $user->admin = $request->input('admin');
        $user->save();

        return response()->json(['success' => 'Usuario creado correctamente']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|integer',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->company_id = $request->input('company_id');
        $user->save();

        return response()->json(['success' => 'Usuario actualizado correctamente']);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }
}
