<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manglik;
use Redirect;
use Validator;

class ManglikController extends Controller
{
    public function __construct()
    {
        $this->rules = [
            'name' => ['required', 'max:255'],
        ];

        $this->messages = [
            'name.required' => translate('Name is required'),
            'name.max'      => translate('Max 255 characters'),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $mangliks    = Manglik::latest();

        if ($request->has('search')) {
            $sort_search = $request->search;
            $mangliks    = $mangliks->where('name', 'like', '%' . $sort_search . '%');
        }
        $mangliks = $mangliks->paginate(10);
        return view('admin.member_profile_attributes.mangliks.index', compact('mangliks', 'sort_search'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $manglik       = new Manglik;
        $manglik->name = $request->name;
        if ($manglik->save()) {
            flash(translate('New Manglik option has been added successfully'))->success();
            return redirect()->route('mangliks.index');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
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
        $manglik = Manglik::findOrFail(decrypt($id));
        return view('admin.member_profile_attributes.mangliks.edit', compact('manglik'));
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
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $manglik       = Manglik::findOrFail($id);
        $manglik->name = $request->name;
        if ($manglik->save()) {
            flash(translate('Manglik option has been updated successfully'))->success();
            return redirect()->route('mangliks.index');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
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
        if (Manglik::destroy($id)) {
            flash(translate('Manglik option has been deleted successfully'))->success();
            return redirect()->route('mangliks.index');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }
}
