<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryImage;
use App\Models\Member;
use Auth;

class GalleryImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gallery_images = GalleryImage::where('user_id',Auth::user()->id)->latest()->paginate(10);
        return view('frontend.member.gallery_image.index', compact('gallery_images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $uploaded_photos_count = GalleryImage::where('user_id', Auth::user()->id)->count();
      if ($uploaded_photos_count < 3 || package_validity(Auth::user()->id)) {
        if ($uploaded_photos_count < 3 || get_remaining_package_value(Auth::user()->id,'remaining_photo_gallery') > 0) {
          return view('frontend.member.gallery_image.create');
        }
        else{
          flash(translate('You have 0 Remaining Gallery Photo upload. Please update your package.'))->error();
          return redirect()->route('packages');
        }
      }
      else{
        flash(translate('Your package has been expired. Please update your package.'))->error();
        return redirect()->route('packages');
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $uploaded_photos_count = GalleryImage::where('user_id', Auth::user()->id)->count();
      if ($uploaded_photos_count < 3 || package_validity(Auth::user()->id)) {
        if ($uploaded_photos_count < 3 || get_remaining_package_value(Auth::user()->id,'remaining_photo_gallery') > 0) {
          $gallery_image          = new GalleryImage;
          $gallery_image->user_id = Auth::user()->id;
          $gallery_image->image   = $request->gallery_image;
          if($gallery_image->save()){
              $member = Member::where('user_id', Auth::user()->id)->first();
              if ($member->remaining_photo_gallery > 0) {
                  $member->remaining_photo_gallery = $member->remaining_photo_gallery - 1;
                  $member->save();
              }
              flash(translate('Gallery image uploaded successfully.'))->success();
              return redirect()->route('gallery-image.index');
          }
          else{
            flash(translate('Something went Wrong.'))->error();
            return back();
          }
        }
        else{
          flash(translate('You have 0 Remaining Gallery Photo upload. Please update your package.'))->error();
          return back();
        }
      }
      else{
        flash(translate('Your package has been expired. Please update your package.'))->error();
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
        $gallery_image = GalleryImage::find($id);
        if ($gallery_image && (Auth::user()->user_type == 'admin' || $gallery_image->user_id == Auth::user()->id)) {
            if ($gallery_image->delete()) {
                flash(translate('Image deleted successfully'))->success();
                return redirect()->route('gallery-image.index');
            }
        }
        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    // Admin: upload gallery image for any member
    public function adminStore(Request $request)
    {
        $request->validate([
            'user_id'       => 'required|exists:users,id',
            'gallery_image' => 'required',
        ]);

        $gallery_image          = new GalleryImage;
        $gallery_image->user_id = $request->user_id;
        $gallery_image->image   = $request->gallery_image;

        if ($gallery_image->save()) {
            flash(translate('Gallery image uploaded successfully.'))->success();
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
        }

        return back();
    }

    // Admin: delete gallery image for any member
    public function adminDestroy($id)
    {
        $gallery_image = GalleryImage::findOrFail($id);
        if ($gallery_image->delete()) {
            flash(translate('Image deleted successfully.'))->success();
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
        }
        return back();
    }
}
