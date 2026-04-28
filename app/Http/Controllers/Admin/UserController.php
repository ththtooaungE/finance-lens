<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $users = User::select(
                'id',
                'name',
                'email',
                'is_active',
                'email_verified_at',
                'created_at'
            )
                ->where('id', '!=', auth()->id());

            return datatables()
                ->of($users)
                ->editColumn('is_active', function ($user) {
                    return $user->is_active ? 'Active' : 'Inactive';
                })
                ->editColumn('email_verified_at', function ($user) {
                    return $user->email_verified_at ? 'Verified' : 'Unverified';
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('Y-m-d');
                })
                ->addColumn('actions', function ($user) {
                    $editUrl = route('admin.users.edit', $user->id);
                    $deleteUrl = route('admin.users.delete', $user->id);

                    $btn = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">Edit</a>';
                    $btn .= '<form action="' .  $deleteUrl . '" method="post" style="display:inline-block">' 
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.users.index');
    }

    public function edit($id) 
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserUpdateRequest $request, $id) 
    {
        $data = $request->validated();

        $user = User::findOrFail($id);

        $user->update($data);

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully!');
    }

    public function statusToggle(Request $request, $id) {
        
    }
}
