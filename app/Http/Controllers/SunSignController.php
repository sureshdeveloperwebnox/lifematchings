<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SunSign;
use App\Models\MoonSign;
use Redirect;
use Validator;

class SunSignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_sun_signs'])->only('index');
        $this->middleware(['permission:add_sun_signs'])->only('store');
        $this->middleware(['permission:edit_sun_signs'])->only('edit');
        $this->middleware(['permission:delete_sun_signs'])->only('destroy');

        $this->rules = [
            'name'      => ['required','max:255'],
        ];

        $this->messages = [
            'name.required'    => translate('Name is required'),
            'name.max'         => translate('Max 255 characters'),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $sort_search   = null;
      $sun_signs = SunSign::latest();

      if ($request->has('search')){
          $sort_search       = $request->search;
          $sun_signs  = $sun_signs->where('name', 'like', '%'.$sort_search.'%');
        }
      $sun_signs = $sun_signs->paginate(10);
      $moon_signs = MoonSign::orderBy('name')->get();
      
      // Load mapped moon signs for each sun sign
      foreach ($sun_signs as $sun_sign) {
          if ($sun_sign->moon_sign_ids && is_array($sun_sign->moon_sign_ids) && count($sun_sign->moon_sign_ids) > 0) {
              $sun_sign->mapped_moon_signs = MoonSign::whereIn('id', $sun_sign->moon_sign_ids)->get();
          } else {
              $sun_sign->mapped_moon_signs = collect([]);
          }
      }

      return view('admin.member_profile_attributes.sun_signs.index', compact('sun_signs','sort_search', 'moon_signs'));
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
        $rules      = $this->rules;
        $messages   = $this->messages;
        $validator  = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $sun_sign              = new SunSign;
        $sun_sign->name        = $request->name;
        if($sun_sign->save())
        {
            flash('New Rasi/Zodiac Sign has been added successfully')->success();
            return redirect()->route('sun-signs.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }

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
        $sun_sign       = SunSign::findOrFail(decrypt($id));
        return view('admin.member_profile_attributes.sun_signs.edit', compact('sun_sign'));
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
        $rules      = $this->rules;
        $messages   = $this->messages;
        $validator  = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $sun_sign              = SunSign::findOrFail($id);
        $sun_sign->name        = $request->name;
        if($sun_sign->save())
        {
            flash('Rasi/Zodiac Sign has been updated successfully')->success();
            return redirect()->route('sun-signs.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
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
        if (SunSign::destroy($id)) {
            flash('Rasi/Zodiac Sign info has been deleted successfully')->success();
            return redirect()->route('sun-signs.index');
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    /**
     * Show the form for mapping moon signs to sun sign.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMapping($id)
    {
        $sun_sign = SunSign::findOrFail(decrypt($id));
        $moon_signs = MoonSign::orderBy('name')->get();
        $selected_moon_sign_ids = $sun_sign->moon_sign_ids ?? [];
        return view('admin.member_profile_attributes.sun_signs.mapping', compact('sun_sign', 'moon_signs', 'selected_moon_sign_ids'));
    }

    /**
     * Update moon sign mapping for sun sign.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMapping(Request $request, $id)
    {
        $sun_sign = SunSign::findOrFail($id);
        $moon_sign_ids = $request->moon_sign_ids ?? [];
        $sun_sign->moon_sign_ids = $moon_sign_ids;
        
        if($sun_sign->save())
        {
            flash('Star/Nakshatra mapping has been updated successfully')->success();
            return redirect()->route('sun-signs.index');
        }
        else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    /**
     * Get Star/Nakshatra for a given Rasi/Zodiac Sign ID (AJAX)
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMoonSignsBySunSign($id)
    {
        try {
            $sun_sign = SunSign::findOrFail($id);
            $moon_sign_ids = $sun_sign->moon_sign_ids ?? [];
            
            if (empty($moon_sign_ids)) {
                return response()->json([
                    'success' => true,
                    'moon_signs' => []
                ]);
            }
            
            $moon_signs = MoonSign::whereIn('id', $moon_sign_ids)
                ->orderBy('name')
                ->get(['id', 'name']);
            
            return response()->json([
                'success' => true,
                'moon_signs' => $moon_signs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching Star/Nakshatra',
                'moon_signs' => []
            ], 500);
        }
    }
}
