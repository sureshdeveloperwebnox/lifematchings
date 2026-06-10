<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhysicalAttribute;
use Validator;
use Redirect;

class PhysicalAttributeController extends Controller
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
         $this->rules = [
             'height'       => [ 'required','numeric','min:0','max:300'],
             'weight'       => [ 'required','numeric','min:0','max:500'],
             'eye_color'    => [ 'required','max:50'],
             'hair_color'   => [ 'required','max:50'],
             'complexion'   => [ 'required','max:50'],
             'blood_group'  => [ 'required','max:3'],
             'body_type'    => [ 'required','max:50'],
             //'body_art'     => [ 'required','max:50'],
             'disability'   => [ 'max:255'],
         ];
         $this->messages = [
             'height.required'      => translate('Height is required'),
             'height.numeric'       => translate('Height must be a number'),
             'height.min'           => translate('Height must be at least 0'),
             'height.max'           => translate('Height must not exceed 300'),
             'weight.required'      => translate('Weight is required'),
             'weight.numeric'       => translate('Weight must be a number'),
             'weight.min'           => translate('Weight must be at least 0'),
             'weight.max'           => translate('Weight must not exceed 500'),
             'eye_color.required'   => translate('Eye Color is required'),
             'eye_color.max'        => translate('Eye Color must not exceed 50 characters'),
             'hair_color.required'  => translate('Hair Color is required'),
             'hair_color.max'       => translate('Hair Color must not exceed 50 characters'),
             'complexion.required'  => translate('Complexion is required'),
             'complexion.max'       => translate('Complexion must not exceed 50 characters'),
             'blood_group.required' => translate('Blood Group is required'),
             'blood_group.max'      => translate('Blood Group must not exceed 3 characters'),
             'body_type.required'   => translate('Body Type is required'),
             'body_type.max'        => translate('Body Type must not exceed 50 characters'),
             'body_art.required'    => translate('Body Art is required'),
             'body_art.max'         => translate('Body Art must not exceed 50 characters'),
             'disability.max'       => translate('Disability must not exceed 255 characters'),
         ];

         $rules = $this->rules;
         $messages = $this->messages;
         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {
             $errors = $validator->errors()->all();
             foreach ($errors as $error) {
                 flash($error)->error();
             }
             return Redirect::back()->withErrors($validator);
         }

         $physical_attribute = PhysicalAttribute::where('user_id', $id)->first();
         if(empty($physical_attribute)){
             $physical_attribute = new PhysicalAttribute;
         }

         $physical_attribute->fill([
             'user_id'      => $id,
             'height'       => $request->height,
             'weight'       => $request->weight,
             'eye_color'    => $request->eye_color,
             'hair_color'   => $request->hair_color,
             'complexion'   => $request->complexion,
             'blood_group'  => $request->blood_group,
             'body_type'    => $request->body_type,
             'body_art'     => $request->body_art,
             'disability'   => $request->disability
         ]);

         try {
             if($physical_attribute->save()){
                 flash(translate('Physical Attribute Info has been updated successfully'))->success();
                 return back();
             }
             else {
                 flash(translate('Sorry! Something went wrong while saving physical attributes.'))->error();
                 return back();
             }
         } catch (\Exception $e) {
             flash(translate('Error: ') . $e->getMessage())->error();
             return back();
         }

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
