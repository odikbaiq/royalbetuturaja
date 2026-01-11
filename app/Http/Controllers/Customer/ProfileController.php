<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil.
     */
    public function index()
    {
        return view('customer.profile');
    }

    /**
     * Memperbarui informasi profil (Nama, Email, Foto).
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if ($user->profile_picture && Storage::disk('public')->exists('profiles/' . $user->profile_picture)) {
                Storage::disk('public')->delete('profiles/' . $user->profile_picture);
            }

            // Buat nama file unik
            $filename = time() . '_' . $user->id . '.' . $request->file('profile_picture')->getClientOriginalExtension();

            // Simpan file asli
            $request->file('profile_picture')->storeAs('profiles', $filename, 'public');

            // Resize menggunakan Intervention Image
            $imagePath = storage_path('app/public/profiles/' . $filename);
            $image = Image::read($imagePath);

            // Resize ke 500x500 (Crop/Fit lebih baik untuk avatar)
            $image->cover(500, 500);
            $image->save();

            $user->profile_picture = $filename;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Memperbarui keamanan/password.
     */
    public function changePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password baru minimal 8 karakter.'
        ]);

        // Cek apakah password lama benar
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.'])
                ->with('active_tab', 'password'); // Agar tetap di tab keamanan saat error
        }

        // Update password baru
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()
            ->with('success', 'Password berhasil diubah.')
            ->with('active_tab', 'password'); // Agar tetap di tab keamanan saat sukses
    }
}
