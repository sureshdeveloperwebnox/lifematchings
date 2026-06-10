<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MoonSign;
use Redirect;
use Validator;

class MoonSignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_moon_signs'])->only('index');
        $this->middleware(['permission:add_moon_signs'])->only('store');
        $this->middleware(['permission:edit_moon_signs'])->only('edit');
        $this->middleware(['permission:delete_moon_signs'])->only('destroy');

        $this->rules = [
            'name'      => ['required','max:255'],
        ];

        $this->messages = [
            'name.required'    => translate('Name is required'),
            'name.max'         => translate('Max 255 characters'),
        ];
    }

    public function index(Request $request)
    {
      $sort_search   = null;
      $moon_signs = MoonSign::latest();

      if ($request->has('search')){
          $sort_search       = $request->search;
          $moon_signs  = $moon_signs->where('name', 'like', '%'.$sort_search.'%');
      }
      $moon_signs = $moon_signs->paginate(10);
      return view('admin.member_profile_attributes.moon_signs.index', compact('moon_signs','sort_search'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $rules      = $this->rules;
        $messages   = $this->messages;
        $validator  = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $moon_sign              = new MoonSign;
        $moon_sign->name        = $request->name;
        if($moon_sign->save())
        {
            flash('New Star/Nakshatra has been added successfully')->success();
            return redirect()->route('moon-signs.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $moon_sign       = MoonSign::findOrFail(decrypt($id));
        return view('admin.member_profile_attributes.moon_signs.edit', compact('moon_sign'));
    }

    public function update(Request $request, $id)
    {
        $rules      = $this->rules;
        $messages   = $this->messages;
        $validator  = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $moon_sign              = MoonSign::findOrFail($id);
        $moon_sign->name        = $request->name;
        if($moon_sign->save())
        {
            flash('Star/Nakshatra has been updated successfully')->success();
            return redirect()->route('moon-signs.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();  
        }
    }

    public function destroy($id)
    {
        if (MoonSign::destroy($id)) {
            flash('Star/Nakshatra info has been deleted successfully')->success();
            return redirect()->route('moon-signs.index');
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }
}
