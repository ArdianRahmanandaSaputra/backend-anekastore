<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $apiKey = '36878ac22f61b56062bd8beae3e310ac';

    public function province(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: " . $this->apiKey
        ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        $response = curl_exec($curl);
        $provinces = json_decode($response);

        return response()->json(['provinces' => $provinces->rajaongkir->results]);
    }

    public function provinceById(Request $req){
        $id = $req->id;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province?id=" . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: " . $this->apiKey
        ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        $response = curl_exec($curl);
        $province = json_decode($response);

        return response()->json(['province' => $province->rajaongkir->results]);
    }

    public function cityByProvince(Request $req){
        $id = $req->id;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=" . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: " . $this->apiKey
        ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        $response = curl_exec($curl);
        $cities = json_decode($response);

        return response()->json(['cities' => $cities->rajaongkir->results]);
    }

    public function cityById(Request $req){
        $id = $req->id;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?id=" . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: " . $this->apiKey
        ),
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        $response = curl_exec($curl);
        $city = json_decode($response);

        return response()->json(['city' => $city->rajaongkir->results]);
    }

    public function update(Request $req){
        $user = User::findOrFail($req->id);

        $user->name = $req->name;
        $user->email = $req->email;
        
        if(!empty($req->password)){
            $user->password = Hash::make($req->password);
        }
        $user->save();

        $userDetail = UserDetail::where('user_id', $req->id)->first();

        if($userDetail){
            $userDetail->province = $req->province;
            $userDetail->province_code = $req->province_code;
            $userDetail->city = $req->city;
            $userDetail->city_code = $req->city_code;
            $userDetail->phone = $req->phone;
            $userDetail->postal_code = $req->postal_code;
            $userDetail->detail_address = $req->detail_address;
            $userDetail->gender = $req->gender;
        }else{
            $userDetail = new UserDetail;
            $userDetail->user_id = $req->id;
            $userDetail->province = $req->province;
            $userDetail->province_code = $req->province_code;
            $userDetail->city = $req->city;
            $userDetail->city_code = $req->city_code;
            $userDetail->phone = $req->phone;
            $userDetail->postal_code = $req->postal_code;
            $userDetail->detail_address = $req->detail_address;
            $userDetail->gender = $req->gender;
        }

        if($req->hasFile('photo')){
            $validatedData = $req->validate([
                'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
            if(File::exists('uploads/user/' . $userDetail->photo)) {
                File::delete('uploads/user/' . $userDetail->photo);
            }

            $foto = $req->file('photo')->getClientOriginalName();
            $path = $req->file('photo')->move('uploads/user/' , $user->id . $foto);
            $userDetail->photo = $user->id . $foto;
        }
        $userDetail->save();

        return response()->json(['message' => 'profile successfully updated']);
    }
}
