<?php

namespace App\Http\Controllers;

use App\Common\Common;
use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

use function PHPUnit\Framework\isNull;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = DB::table('users')->join('roles', 'users.roleId', '=', 'roles.id')
        ->select('users.*', 'roles.roleName')->orderBy('users.id', 'asc');
        $users = $users->get();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $fullname = $request->get('fullName');
        $password = bcrypt($request->get('password'));
        $phone = $request->get('phone');
        $email = $request->get('email');
        $address = $request->get('address');
        $dob = date('Y-m-d', strtotime($request->get('dob')));
        $gender = $request->get('gender');
        $role = $request->get('role');
        $img = $request->get('image');
        $imgPath = '';

        if ($img !== null && $img !== '') {
            $imgPath = Common::saveImgBase64($img, 'images');
        }

        $usersData = array(
            'fullName' => $fullname,
            'password' => $password,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'dob' => $dob,
            'gender' => $gender,
            'roleId' => $role,
            'imgPath' => $imgPath
        );
        DB::table('users')->insert($usersData);
        return response()->json($usersData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $users = DB::table('users')
            ->where('id', $id)->first();
        return response()->json($users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $ret = ['status' => 'failed', 'message' => ''];
        $users = User::find($id);

        if (!$users) {
            $ret['message'] = 'Cannot found user with id =' . $id;

            return response()->json($ret);
        }
        $users->fullName = $request->get('fullName');
        $users->phone = $request->get('phone');
        $users->email = $request->get('email');
        $users->address = $request->get('address');
        $users->dob = date('Y-m-d', strtotime($request->get('dob')));
        $users->gender = $request->get('gender');
        $users->roleId = $request->get('roleId');
        $img = $request->get('image');
        if ($img && str_contains($img, ';base64,')) {
            $users->imgPath = Common::saveImgBase64($request->get('image'), 'images');
        }

        $users->update();

        $ret['status'] = 'success';
        $ret['message'] = 'Updated user successfully';
        $ret['data'] = $users;

        return response()->json($ret);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationRequest  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function editpassword($id, Request $request)
    {
        $ret = ['status' => 'failed', 'message' => ''];
        $users = User::find($id);

        if (!$users) {
            $ret['message'] = 'Cannot found user with id =' . $id;

            return response()->json($ret);
        }
        $users->password = bcrypt($request->get('password'));
        $users->save();

        $ret['status'] = 'success';
        $ret['message'] = 'Updated user successfully';
        $ret['data'] = $users;

        return response()->json($ret);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $users = DB::table('users')->where('id', $id)->delete();
        return response()->json($users);
    }

    public function getUserInfo()
    {
        return response()->json(auth()->user());
    }
}
