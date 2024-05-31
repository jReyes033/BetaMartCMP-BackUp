<?php

namespace App\Http\Controllers;

use App\Models\account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $account = account::all();
        if ($account->count() > 0) {
            return response()->json([
                'status' => 200,
                'account' => $account
            ],200);
        } else {
            return response()->json([
                'status' => 404,
                'Message' => 'No Records Found'
            ],404);
        }
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
        $validate = Validator::make($request->all(), 
        [
            'name' => 'required | string | max:191',
            'email' => 'required|string|email|max:191|unique:users,email',
            'password' => 'required | string | min:8 | max:191',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->messages()
            ], 400);
        } 

        try {
            $account = account::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> $request->password
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Account Created Succesfully"
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Something went wrong: " . $e->getMessage()
            ], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(int $accountID)
    {
        $account = account::find($accountID);

        if ($account) {
            return response()->json([
                'status' => 200,
                'account' => $account
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No account found."
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $accountID)
    {
        $account = account::find($accountID);

        if ($account) {
            return response()->json([
                'status' => 200,
                'account' => $account
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No account found."
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $accountID)
    {
        $validate = Validator::make($request->all(), 
        [
            'name' => 'required | string | max:191',
            'email' => 'required|string|email|max:191|unique:users,email',
            'password' => 'required | string | min:8 | max:191',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validate->messages()
            ], 400);
        } 

        try {
            $account = account::find($accountID);

            $account->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> $request->password
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Account updated Succesfully"
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => "Something went wrong: " . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $accountID)
    {
        $account = account::find($accountID);

        if ($account) {
            $account->delete();
            return response()->json([
                'status' => 200,
                'message' => "Account deleted succesfully"
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "No valid account to delete."
            ], 404);
        }
    }
}
