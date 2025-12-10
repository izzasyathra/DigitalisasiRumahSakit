<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index()
    {
        $users = User::with('poli')->orderBy('role', 'asc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        $polis = Poli::all();
        return view('admin.users.create', compact('polis'));
    }

    /**
     * Menyimpan user baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'dokter', 'pasien'])],
            // Wajib isi Poli jika role adalah dokter
            'poli_id' => [
                'nullable', 
                'exists:polis,id',
                Rule::requiredIf($request->role === 'dokter')
            ],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'poli_id' => ($request->role === 'dokter') ? $request->poli_id : null,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(User $user)
    {
        $polis = Poli::all();
        return view('admin.users.edit', compact('user', 'polis'));
    }

    /**
     * Update data user.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'dokter', 'pasien'])],
            'poli_id' => [
                'nullable', 
                'exists:polis,id',
                Rule::requiredIf($request->role === 'dokter')
            ],
        ]);

        // 2. Siapkan Data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'poli_id' => ($request->role === 'dokter') ? $request->poli_id : null,
        ];

        // 3. Update Password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 4. Eksekusi Update
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}