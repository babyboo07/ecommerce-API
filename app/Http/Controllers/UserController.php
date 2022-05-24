<?php

namespace App\Http\Controllers;

use App\Common\Common;
use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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
        $users = DB::table('users')->join('roles','users.roleId', '=','roles.id')->select('users.*','roles.roleName');
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
        $password = $request->get('password');
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

        $usersData = array('fullName' => $fullname, 
                        'password' => $password, 
                        'phone' => $phone, 
                        'email'=>$email,
                        'address' => $address,
                        'dob' => $dob,
                        'gender'=>$gender,
                        'roleId'=> $role,
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
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationRequest  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        //
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
        $users = DB::table('users')->where('id',$id)->delete();
        return response()->json('$users');
    }
}
