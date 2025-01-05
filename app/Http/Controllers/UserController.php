<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Master\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $users = Users::query();

            if ($request->search) {
                $users->where('first_name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            }

            $users = $users->paginate(10);
            return view('master.users.index', compact('users'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            Users::createUser($request->validated());
            DB::commit();
            return redirect()->back()->with('success', 'User berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan User: ' . $e->getMessage());
        }
    }

    public function show(Users $user)
    {
        try {
            return view('master.users.edit', compact('user'))->with('viewMode', true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Users $user)
    {
        try {
            return view('master.users.edit', compact('user'))->with('viewMode', false);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(UserRequest $request, Users $user)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            // Jika ada password baru, gunakan password baru
            if (!empty($request->password_new)) {
                $data['password'] = bcrypt($request->password_new);
            }

            $user->update($data);
            DB::commit();
            return redirect()
                ->route('users.index')
                ->with('success', 'User berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui User: ' . $e->getMessage());
        }
    }

    public function destroy(Users $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            return redirect()->back()->with('success', 'User berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus User: ' . $e->getMessage());
        }
    }
}
