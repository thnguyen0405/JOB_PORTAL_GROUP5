<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Video 26: List all users with pagination
    public function index()
    {
        $users = User::orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    // Video 27: Edit user form
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    // Video 27: Update user (AJAX)
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $user = User::findOrFail($id);
        $user->name        = $request->name;
        $user->email       = $request->email;
        $user->designation = $request->designation;
        $user->mobile      = $request->mobile;
        $user->role        = $request->role;
        $user->save();

        return response()->json([
            'status'   => true,
            'message'  => 'User updated successfully.',
            'redirect' => route('admin.users'),
        ]);
    }

    // Video 26: Delete user
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('success', 'User deleted successfully.');
        return response()->json(['status' => true]);
    }
}
