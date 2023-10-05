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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
