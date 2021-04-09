<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SupervisorsController extends Controller
{
    public function __construct()
    {
        if (\auth()->check()) {
            $this->middleware('auth');
        } else {
            return view('backend.auth.login');
        }
    }

    public function index()
    {
        if (! \auth()->user()->ability('admin', 'manage_supervisors,show_supervisors')) {
            return redirect('admin/index');
        }

        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $status         = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'desc';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $supervisors = User::whereHas('roles', function ($query) {
            $query->where('name', 'editor');
        });
        if ($keyword != null)
        {
            $supervisors = $supervisors->search($keyword);
        }
        if ($status != null)
        {
            $supervisors = $supervisors->whereStatus($status);
        }

        $supervisors = $supervisors->orderBy($sort_by, $order_by);
        $supervisors = $supervisors->paginate($limit_by);

        return view('backend.supervisors.index', compact('supervisors'));
    }

    public function create()
    {
        if (! \auth()->user()->ability('admin', 'create_supervisors')) {
            return redirect('admin/index');
        }
        $permissions = Permission::pluck('display_name', 'id');
        return view('backend.supervisors.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        if (! \auth()->user()->ability('admin', 'create_supervisors')) {
            return redirect('admin/index');
        }

        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'username'      => 'required|max:20|min:3|unique:users',
            'email'         => 'required|email|max:255|unique:users',
            'mobile'        => 'required|numeric|unique:users',
            'status'        => 'required',
            'password'      => 'required|min:8',
            'permissions.*' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data['name']               = $request->name;
        $data['username']           = $request->username;
        $data['email']              = $request->email;
        $data['email_verified_at']  = Carbon::now();
        $data['mobile']             = $request->mobile;
        $data['password']           = bcrypt($request->password);
        $data['status']             = $request->status;
        $data['bio']                = $request->bio;
        $data['receive_email']      = $request->receive_email;

        if ($user_image = $request->file('user_image')) {
            $filename = Str::slug($request->user_image) . '.' . $user_image->getClientOriginalExtension();
            $path = public_path('assets/users/' . $filename);
            Image::make($user_image->getRealPath())->resize(300, 300, function($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $data['user_image'] = $filename;
        }

        $supervisor = User::create($data);
        $supervisor->attachRole(Role::whereName('editor')->first()->id);

        if (isset($request->permissions) && count($request->permissions) > 0) {
            $supervisor->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'User created successfully',
            'alert-type' => 'success'
        ]);
    }

    public function show($id)
    {
        if (! \auth()->user()->ability('admin', 'display_supervisors')) {
            return redirect('admin/index');
        }
        $supervisor = User::whereId($id)->first();

        if ($supervisor) {
            return view('backend.supervisors.show', compact('supervisor'));
        }

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function edit($id)
    {
        if (! \auth()->user()->ability('admin', 'update_supervisors')) {
            return redirect('admin/index');
        }
        $supervisor = User::whereId($id)->first();

        if ($supervisor) {
            $permissions = Permission::pluck('display_name', 'id');
            $userPermission = UserPermission::whereUserId($id)->pluck('permission_id');
            return view('backend.supervisors.edit', compact('supervisor', 'permissions', 'userPermission'));
        }

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function update(Request $request, $id)
    {
        if (! \auth()->user()->ability('admin', 'update_supervisors')) {
            return redirect('admin/index');
        }
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'username'      => 'required|max:20|min:3|unique:users,username,'.$id,
            'email'         => 'required|email|max:255|unique:users,email,'.$id,
            'mobile'        => 'required|numeric|unique:users,mobile,'.$id,
            'status'        => 'required',
            'password'      => 'nullable|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supervisor = User::whereId($id)->first();

        if ($supervisor) {

            $data['name']               = $request->name;
            $data['username']           = $request->username;
            $data['email']              = $request->email;
            $data['mobile']             = $request->mobile;
            if (trim($request->password) != null) {
                $data['password'] = bcrypt($request->password);
            }
            $data['status']             = $request->status;
            $data['bio']                = $request->bio;
            $data['receive_email']      = $request->receive_email;

            if ($user_image = $request->file('user_image')) {

                if ($supervisor->user_image != '') {
                    if (File::exists('assets/users/' . $supervisor->user_image)) {
                        unlink('assets/users/' . $supervisor->user_image);
                    }
                }

                $filename = Str::slug($request->username) . '.' . $user_image->getClientOriginalExtension();
                $path = public_path('assets/users/' . $filename);
                Image::make($user_image->getRealPath())->resize(300, 300, function($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $data['user_image'] = $filename;
            }

            $supervisor->update($data);

            if (isset($request->permissions) && count($request->permissions) > 0) {
                $supervisor->permissions()->sync($request->permissions);
            }

            return redirect()->route('admin.supervisors.index')->with([
                'message' => 'Supervisor updated successfully',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('admin.supervisors.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function destroy($id)
    {
        if (! \auth()->user()->ability('admin', 'delete_supervisors')) {
            return redirect('admin/index');
        }

        $supervisor = User::whereId($id)->first();

        if ($supervisor) {
            if ($supervisor->user_image != '') {
                if (File::exists('assets/users/' . $supervisor->user_image)) {
                    unlink('assets/users/' . $supervisor->user_image);
                }
            }

            $supervisor->delete();

            return redirect()->route('admin.supervisors.index')->with([
                'message' => 'Supervisor deleted successfully',
                'alert-type' => 'success'
            ]);
        }

        return redirect()->route('index.supervisors.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger'
        ]);
    }

    public function removeImage(Request $request)
    {
        if (!\auth()->user()->ability('admin', 'delete_supervisors')) {
            return redirect('admin/index');
        }

        $supervisor = User::whereId($request->user_id)->first();

        if ($supervisor) {
            if (File::exists('assets/users/' . $supervisor->user_image)) {
                unlink('assets/users/' . $supervisor->user_image);
            }
            $supervisor->user_image = null;
            $supervisor->save();
            return 'true';
        }

        return 'false';
    }
}
