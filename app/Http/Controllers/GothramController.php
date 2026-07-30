<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gothram;
use Redirect;
use Validator;

class GothramController extends Controller
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
        $gothrams    = Gothram::latest();

        if ($request->has('search')) {
            $sort_search = $request->search;
            $gothrams    = $gothrams->where('name', 'like', '%' . $sort_search . '%');
        }
        $gothrams = $gothrams->paginate(10);
        return view('admin.member_profile_attributes.gothrams.index', compact('gothrams', 'sort_search'));
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

        $gothram       = new Gothram;
        $gothram->name = $request->name;
        if ($gothram->save()) {
            flash(translate('New Gothram has been added successfully'))->success();
            return redirect()->route('gothrams.index');
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
        $gothram = Gothram::findOrFail(decrypt($id));
        return view('admin.member_profile_attributes.gothrams.edit', compact('gothram'));
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

        $gothram       = Gothram::findOrFail($id);
        $gothram->name = $request->name;
        if ($gothram->save()) {
            flash(translate('Gothram has been updated successfully'))->success();
            return redirect()->route('gothrams.index');
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
        if (Gothram::destroy($id)) {
            flash(translate('Gothram info has been deleted successfully'))->success();
            return redirect()->route('gothrams.index');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }
}
