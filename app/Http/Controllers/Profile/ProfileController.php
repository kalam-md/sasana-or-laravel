<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request, $username)
    {
        $user = Auth::user();

        // Validasi data input untuk tabel users
        $validatedUserData = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'photo.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // Update data di tabel users
        if ($request->filled('password')) {
            $validatedUserData['password'] = Hash::make($request->password);
        } else {
            unset($validatedUserData['password']);
        }

        // Cek jika ada gambar baru
        if ($request->hasFile('photo')) {
            // Hapus gambar lama jika ada
            if ($user->photo && file_exists(public_path('profile/' . $user->photo))) {
                unlink(public_path('profile/' . $user->photo));
            }

            // Simpan gambar baru
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile'), $filename);

            // Set nama file gambar baru di database
            $validatedUserData['photo'] = $filename;
        }

        User::where('id', $user->id)->update($validatedUserData);
        return redirect()->route('dashboard')->with('success', 'Profile berhasil diperbarui');
    }
}
