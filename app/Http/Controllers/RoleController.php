<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Master\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $roles = Role::query();

            if ($request->search) {
                $roles->where('name', 'like', "%{$request->search}%")
                    ->orWhere('code', 'like', "%{$request->search}%");
            }

            $roles = $roles->paginate(10);
            return view('master.role.index', compact('roles'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function store(RoleRequest $request)
    {
        DB::beginTransaction();
        try {
            Role::createRole($request->validated());
            DB::commit();
            return redirect()->back()->with('success', 'Role berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan Role: ' . $e->getMessage());
        }
    }

    public function show(Role $role)
    {
        try {
            return view('master.role.edit', compact('role'))->with('viewMode', true);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Role $role)
    {
        try {
            return view('master.role.edit', compact('role'))->with('viewMode', false);
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(RoleRequest $request, Role $role)
    {
        DB::beginTransaction();
        try {
            $role->updateRole($request->validated());
            DB::commit();
            return redirect()
                ->route('roles.index')
                ->with('success', 'Role berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui Role: ' . $e->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        DB::beginTransaction();
        try {
            $role->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Role berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus Role: ' . $e->getMessage());
        }
    }
}
