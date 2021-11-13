<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class PatientController extends Controller
{
    public function index()
    {
        try {
            if (! $user = FacadesJWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        $data=Patient::all();
        return response()->json($data);
    }
 
    public function create()
    {
        //
    }
 
    public function store(Request $request)
    {
        try {
            if (! $user = FacadesJWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        
        $this->validate($request,[
            'patient_id' => 'required',
            'patient_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
        ]);

        Patient::create([
            'patient_id' => $request->patient_id,
            'patient_name' => $request->patient_name,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);
    
        return response()->json(array('message'=>'Input Success'));
    }

    public function show($id)
    {
        //
    }
 
    public function edit($id)
    {
        //
    }
 
    public function update(Request $request, $id)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        
        $this->validate($request,[
            'patient_id' => 'required',
            'patient_name' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
        ]);
        
        $row=Patient::find($id);
        $row->patient_id = $request->patient_id;
        $row->patient_name = $request->patient_name;
        $row->gender = $request->gender;
        $row->birth_date = $request->birth_date;
        $row->birth_place = $request->birth_place;
        $row->address = $request->address;
        $row->phone_number = $request->phone_number;
        $row->save();
        
        return response()->json(array('message'=>'Update Success'));
    }

    public function destroy($id)
    {
        try {
            if (! $user = FacadesJWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        
        $row=Patient::find($id);
        $row->delete();
        
        return response()->json(array('message'=>'Delete Success'));
    }
}
