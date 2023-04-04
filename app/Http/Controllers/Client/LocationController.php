<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadDistrict(Request $request){
        $districts=District::where('province_id',$request->province_id)->get();
        $html=' <option disabled selected value="">Chọn Quận/Huyện</option>';
        foreach($districts as $district){
            $html.='<option value="'.$district->id.'">'.$district->name.'</option>';
        }
        return response()->json(['data'=>$html],200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadWard(Request $request){
        $wards=Ward::where('district_id',$request->district_id)->get();
        $html='<option disabled selected value="">Chọn Phường/Xã</option>';
        foreach($wards as $ward){
            $html.='<option value="'.$ward->id.'">'.$ward->name.'</option>';
        }
        return response()->json(['data'=>$html],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
