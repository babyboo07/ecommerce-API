<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $address_user = $request->get('address_user');
        $receiverName = $request->get('receiverName');
        $phoneNumber = $request->get('phoneNumber');
        $userId = $request->get('userId');

        $address = array(
            'address_user' => $address_user,
            'receiverName' => $receiverName,
            'phoneNumber' => $phoneNumber,
            'userId' => $userId,
        );

        DB::table('address')->insert($address);
        return response()->json($address);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = DB::table('address')
        ->where('userId' ,$id)->get();
        return response()->json($address);
    }

    public function details($id){
        $address = DB::table('address')
        ->where('id' ,$id)->get();
        return response()->json($address);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $ret = ['status' => 'failed', 'message' => ''];
        $address = Address::find($id);

        if (!$address) {
            $ret['message'] = 'Cannot found address with id =' . $id;

            return response()->json($ret);
        }

        $address->receiverName = $request->get('receiverName');
        $address->phoneNumber = $request->get('phoneNumber');
        $address->address_user = $request->get('address_user');
        $address->userId = $request->get('userId');

        $address->update();

        $ret['status'] = 'success';
        $ret['message'] = 'Updated address successfully';
        $ret['data'] = $address;

        return response()->json($ret);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAddressRequest  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}
