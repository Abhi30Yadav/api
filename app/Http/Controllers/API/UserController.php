<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($flag)
    {
        $query = User::select('email','name');
        if($flag == 1){
            $query->where('status',1);
        }elseif($flag == 0){
            // $query->where('status',0);
        }else{
            return response()->json([
                'massage' => 'Invalid Parameter Passed, it can be either 1 or 0',
                'status' => 0,
            ],400);
        }
        $user = $query->get();
            if(count($user)>0)
            {
                // user exits
                $response = [
                    'massage' => count($user) .' '.'User Found',
                    'status' => 1,
                    'data' => $user
                ];
                return response()->json($response, 200);
            }
            else
            {
                // does not exits
                $response = [
                    'massage' => count($user) .' '.'User  Found',
                    'status' => 0,
                ];
                return response()->json($response, 200);
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|min:1|max:250',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ],[
            'name.required' => 'name is must.',
            'name.min' => 'name must have 1 char.',
            'name.max' => 'name must have 250 char.',
            'name.string' => 'name must is string.',

            'email.required' => 'email is must.',
            'email.email' => 'please correct enter email formate example@gmail.com.',
            'email.unique' => 'email already exit.',

            'password.required' => 'password is must.',
            'password.min' => 'password min 8 char.',
        ]
        );
        if($validate->fails()){
            return response()->json($validate->messages(), 400);
        }else{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ];
            DB::beginTransaction();
            try{
                $user = User::create($data);

                DB::commit();
            }catch(\Exception $e){
                // DB::rollBack();
                p($e->getMessage());
                $user = null;
            }
            if($user !=null){
                return response()->json([
                    'massage' => 'User register successfully'
                ],200);
            }else{
                return response()->json([
                    'massage' => 'Internal Server Error'
                ],500);
            }
        }
        // p($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $user = User::find($id);
       if(is_null($user)){

        $response = ([
            'massage' => 'User not found',
            'status' => 0,
        ]);
        return response()->json($response, 200);
       }else{
        $response = ([
            'massage' => 'User found',
            'status' => 1,
            'data' =>$user
        ]);
        return response()->json($response, 200);
       }
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
        $user = User::find($id);
        if(is_null($user)){
            $response = [
                'massage' => 'User does not exits',
                'status' => 0,
            ];
            $respCode = 404;
        }else{
            DB::beginTransaction();
            try{
                $user->delete();
                DB::commit();
                $response = [
                    'massage' => 'User Delete Succesfully',
                    'status' => 1
                ];
                $respCode = 200;
            }catch(\Exception $e){
                DB::rollBack();
                $response = [
                    'massage' => 'Internal Server Error',
                    'status' => 0
                ];
                $respCode = 500;
            }
        }

        return response()->json($response,$respCode);
    }
}
