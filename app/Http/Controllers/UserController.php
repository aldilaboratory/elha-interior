<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {

        return view("administrator.user.index");
    }

    public function create()
    {
        $groups = Group::all();
        return view("administrator.user.create", compact('groups'));
    }

    public function edit($id)
    {
        $user = User::where("id", $id)->first();
        if (!$user) {
            return abort(404);
        }

        return view("administrator.user.edit", [
            "user" => $user
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "username" => "required|unique:user,username",
            "email" => "required|email|unique:user,email",
            "password" => "required|min:6",
            "group_id" => "required|exists:group,id",
            "alamat" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("user.create"))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "name" => $request->input("name"),
            "username" => $request->input("username"),
            "email" => $request->input("email"),
            "password" => Hash::make($request->input("password")),
            "group_id" => $request->input("group_id"),
            "alamat" => $request->input("alamat"),
        ];

        try {
            User::create($dataSave);
            return redirect(route("user.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("user.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $user = DB::table('user')
            ->join('group', 'user.group_id', '=', 'group.id')
            ->select(
                'user.*',
                'group.nama as group_name'
            );

        return DataTables::of($user)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && !empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function($q) use ($search) {
                        $q->where('user.name', 'like', "%{$search}%")
                          ->orWhere('user.phone', 'like', "%{$search}%")
                          ->orWhere('user.email', 'like', "%{$search}%")
                          ->orWhere('group.nama', 'like', "%{$search}%")
                          ->orWhere('user.alamat', 'like', "%{$search}%");
                    });
                }
            })
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $user = User::where("id", $id)->first();
        if (!$user) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "phone" => "required",
            "email" => "required|email|unique:user,email," . $id,
            "password" => "nullable|min:6",
            "alamat" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("user.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "name" => $request->input("name"),
            "phone" => $request->input("phone"),
            "email" => $request->input("email"),
            "alamat" => $request->input("alamat"),
        ];

        // Hanya update password jika diisi
        if ($request->filled("password")) {
            $dataSave["password"] = Hash::make($request->input("password"));
        }

        try {
            $user->update($dataSave);
            return redirect(route("user.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("user.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $user = User::where("id", $id)->first();
        if (!$user) {
            return abort(404);
        }

        try {
            $user->delete();
            return redirect(route("user.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("user.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }


}
