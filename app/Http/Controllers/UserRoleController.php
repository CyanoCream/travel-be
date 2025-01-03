<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRoleRequest;
use App\Models\Master\UserRole;
use App\Models\Master\Users;
use App\Models\Master\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class UserRoleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $roleCodes = UserRole::with(['user', 'role']);

            if ($request->search) {
                $roleCodes->whereHas('user', function($query) use ($request) {
                    $query->where('name', 'like', "%{$request->search}%");
                })->orWhereHas('role', function($query) use ($request) {
                    $query->where('name', 'like', "%{$request->search}%");
                });
            }

            $roleCodes = $roleCodes->paginate(10);
            $users = Users::all();
            $roles = Role::all();

            return view('master.user_role.index', compact('roleCodes', 'users', 'roles'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(UserRoleRequest $request)
    {
        DB::beginTransaction();
        try {
            UserRole::createUserRole($request->validated());
            DB::commit();
            return redirect()->back()->with('success', 'Role Code berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Role Code: ' . $e->getMessage());
        }
    }

    public function show(UserRole $roleCode)
    {
        try {
            $users = Users::all();
            $roles = Role::all();
            return view('master.user_role.edit', compact('roleCode', 'users', 'roles'))
                ->with('viewMode', true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(UserRole $userRole)
    {
        try {
            $users = Users::all();
            $roles = Role::all();
            return view('master.user_role.edit', compact('userRole', 'users', 'roles'))
                ->with('viewMode', false);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(UserRoleRequest $request, UserRole $roleCode)
    {
        DB::beginTransaction();
        try {
            $roleCode->updateUserRole($request->validated());
            DB::commit();
            return redirect()
                ->route('user-roles.index')
                ->with('success', 'Role Code berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui Role Code: ' . $e->getMessage());
        }
    }

    public function destroy(UserRole $roleCode)
    {
        DB::beginTransaction();
        try {
            $roleCode->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Role Code berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus Role Code: ' . $e->getMessage());
        }
    }
}
