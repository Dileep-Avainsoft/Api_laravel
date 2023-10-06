<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        if(count($user) > 0){
$response=[
    'message' => count($user).'User foun',
    'status' =>1,
    'data' => $user
];
     
        }
        else{
            $response=[
                'message' => count($user).' '.'User found',
                'status' =>0,
           
            ];
           

        }
        return response()->json($response,200);
    //    p($user);

    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
               $validator = Validator::make($request->all(),[
                    'name' => ['required'],
                    'email' => ['required','email','unique:users,email'],
                    'City' => ['required'],
                ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }
        else{
            $data = [

                'name' => $request->name,
                'email'=> $request->email,
                'City' => $request->City

            ];
            // p($data);
            DB::beginTransaction();
            try {
                $user = User::create($data);
                DB::commit();
            } 
            catch (\Exception $th) {
             DB::rollBack();
             p($th->getMessage());
             $user = null;
            }
        }
        if($user !=null){
            return response()->json([
                'message' =>  $request->name.' '.'registered successfully'
            ],200);
        }
        else{
            return response()->json([
                'message' => ' Internal server error'
            ],500);
        }
        // p($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if(is_null($user)){
            //user does not exits
        return response()->json([
            'status' => 0,
            'message' => 'User does not exits'
        ],404);
    }
    else{
        DB::beginTransaction();
        try{
            $user->name  = $request['name'];
            $user->email = $request['email'];
            $user->City = $request['City'];
            $user->save();
            DB::commit();
        }
        catch(\Exception $err){
            DB::rollBack();
            $user = null;
        }

        if(is_null($user)){
            return response()->json(
                [
                    'status'=> 0,
                    'message' => 'Internal server Error'
                ],500
                );
        }
        else{
            return response()->json(
                [
                    'status'=> 1,
                    'message' => 'data updated Successfully'
                ],200
                );
        }
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
     $user = User::find($id);
     if(is_null($user)){
        $response = [
            'message' => 'User does not exists',
            'status' => 0

        ];
        $responsecode =  404;
     }
     else{
        DB::beginTransaction();
        try{
              $user->delete();
              DB::commit();
              $response=[
                'message' => " User delete Successfully",
                'status' => 1
              ];
              $responsecode =  200;

        }
        catch(\Exception $err){

            DB::rollBack();
            $response =[
                'message' => 'Internal Server Error',
                'status' => 0
            ];
            $responsecode =  500;

        }
     }
     
     return response()->json($response,$responsecode);

    }
}
