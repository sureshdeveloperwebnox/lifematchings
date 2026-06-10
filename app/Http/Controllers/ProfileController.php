<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use App\Models\AstrologyReport;
use Exception;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.admin_profile.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $user             = User::findOrFail($id);
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }
        $user->photo = $request->photo;
        if($user->save()){
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
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

    public function getAstrologyReport(Request $request)
    {
        try {
            // Validate the request input
            $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);
    
            // Find the user
            $user = User::findOrFail($request->user_id);
           
            // Fetch the astrology report
            $report = AstrologyReport::where('memberId', $user->id)->first();
    
            // Check if report exists
            if (!$report) {
                return response()->json([
                    'status' => false,
                    'message' => 'No astrology report found for the given user.',
                    'payload' => null
                ], 404);
            }
    
            // Return success response with report data
            return response()->json([
                'status' => true,
                'message' => 'Astrology report retrieved successfully.',
                'payload' => $report
            ], 200);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
                'payload' => null
            ], 404);
        } catch (Exception $e) {
            // General exception (e.g., database error)
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while retrieving the astrology report.',
                'payload' => null,
                'error' => env('APP_DEBUG') ? $e->getMessage() : null // Only show error in debug mode
            ], 500);
        }
    }
}
