<?php

namespace App\Http\Controllers;

use App\Models\AdditionalAttribute;
use App\Models\Address;
use App\Models\AnnualSalaryRange;
use App\Models\Astrology;
use App\Models\AstrologyReport;
use App\Models\Attitude;
use App\Models\Career;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Package;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Religion;
use App\Models\Caste;
use App\Models\ChatThread;
use App\Models\Education;
use App\Models\ExpressInterest;
use App\Models\Family;
use App\Models\SubCaste;
use App\Models\MemberLanguage;
use App\Models\FamilyValue;
use App\Models\GalleryImage;
use App\Models\HappyStory;
use App\Models\Hobby;
use App\Models\IgnoredUser;
use App\Models\Lifestyle;
use App\Models\MaritalStatus;
use App\Models\OnBehalf;
use App\Models\PackagePayment;
use App\Models\PartnerExpectation;
use App\Models\PhysicalAttribute;
use App\Models\ProfileMatch;
use App\Models\Recidency;
use App\Models\ReportedUser;
use App\Models\Setting;
use App\Models\Shortlist;
use App\Models\SpiritualBackground;
use App\Models\Staff;
use App\Models\Upload;
use App\Models\Wallet;
use App\Models\User;
use Hash;
use Validator;
use Redirect;
use Auth;
use App\Utility\EmailUtility;
use App\Utility\SmsUtility;
use MehediIitdu\CoreComponentRepository\CoreComponentRepository;
use PDF;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\DB;
use App\Mail\AstrologyReportMail;
use Notification;
use App\Notifications\DbStoreNotification;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_members'])->only('index');
        $this->middleware(['permission:create_member'])->only('create');
        $this->middleware(['permission:edit_member'])->only('edit');
        $this->middleware(['permission:delete_member'])->only('destroy');
        $this->middleware(['permission:view_member_profile'])->only('show');
        $this->middleware(['permission:block_member'])->only('block');
        $this->middleware(['permission:update_member_package'])->only('package_info');
        $this->middleware(['permission:login_as_member'])->only('login');
        $this->middleware(['permission:deleted_member_show'])->only('deleted_members');
        $this->middleware(['permission:show_unapproved_profile_picrures'])->only('unapproved_profile_pictures');
        $this->middleware(['permission:approve_profile_picrures'])->only('approve_profile_image');
        $this->middleware(['permission:approve_member'])->only('show_verification_info');
        

        $this->rules = [
            'first_name'        => ['required', 'max:255'],
            'last_name'         => ['required', 'max:255'],
            'email'             => ['max:255', 'unique:users,email'],
            'gender'            => ['required'],
            'date_of_birth'     => ['required'],
            'on_behalf'         => ['required'],
            'package'           => ['required'],
            'password'          => ['min:8', 'required_with:confirm_password', 'same:confirm_password'],
            'confirm_password'  => ['min:8'],

        ];

        $this->messages = [
            'first_name.required'       => translate('First name is required'),
            'first_name.max'            => translate('Max 255 characters'),
            'last_name.required'        => translate('First name is required'),
            'last_name.max'             => translate('Max 255 characters'),
            'email.max'                 => translate('Max 255 characters'),
            'email.unique'              => translate('Email Should be unique'),
            'gender.required'           => translate('Gender is required'),
            'date_of_birth.required'    => translate('Gender is required'),
            'on_behalf.required'        => translate('On behalf is required'),
            'package.required'          => translate('Package is required'),
            'password.min'              => translate('Minimum 8 characters'),
            'password.required_with'    => translate('Password and Confirm password are required'),
            'password.same'             => translate('Password and Confirmed password did not matched'),
            'confirm_password.min'      => translate('Minimum 8 characters'),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        CoreComponentRepository::instantiateShopRepository();
        CoreComponentRepository::initializeCache();

        $sort_search  = null;
        $members      = User::latest()->where('user_type', 'member')->where('membership', $id);

        if ($request->has('search')) {
            $sort_search  = $request->search;
            $members  = $members->where('code', $sort_search)->orwhere('first_name', 'like', '%' . $sort_search . '%')->orWhere('last_name', 'like', '%' . $sort_search . '%');
        }

        $members = $members->paginate(10);
        return view('admin.members.index', compact('members', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        if ($request->email == null && $request->phone == null) {
            flash(translate('Email and Phone both can not be null.'))->error();
            return back();
        }

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email or Phone already exists.'))->error();
                return back();
            }
        } elseif (User::where('phone', '+' . $request->country_code . $request->phone)->first() != null) {
            flash(translate('Phone already exists.'))->error();
            return back();
        }

        $user               = new user;
        $user->user_type    = 'member';
        $user->code         = unique_code();
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->password     = Hash::make($request->password);
        $user->photo        = $request->photo;
        $user->email        = $request->email;
        if ($request->phone != null) {
            $user->phone        = '+' . $request->country_code . $request->phone;
        }
        if ($request->member_verification == 1) {
            $user->email_verified_at     = date('Y-m-d h:m:s');
        }
        if ($user->save()) {
            $member                             = new Member;
            $member->user_id                    = $user->id;
            $member->gender                     = $request->gender;
            $member->on_behalves_id             = $request->on_behalf;
            $member->birthday                   = date('Y-m-d', strtotime($request->date_of_birth));

            $package                                = Package::where('id', $request->package)->first();
            $member->current_package_id             = $package->id;
            $member->remaining_interest             = $package->express_interest;
            $member->remaining_photo_gallery        = $package->photo_gallery;
            $member->remaining_contact_view         = $package->contact;
            $member->remaining_profile_viewer_view  = $package->profile_viewers_view;
            $member->remaining_profile_image_view   = $package->profile_image_view;
            $member->remaining_gallery_image_view   = $package->gallery_image_view;
            $member->auto_profile_match             = $package->auto_profile_match;
            $member->package_validity               = Date('Y-m-d', strtotime($package->validity . " days"));
            $membership                             = $package->id == 1 ? 1 : 2;
            $member->save();

            $user_update                = User::findOrFail($user->id);
            $user_update->membership    = $membership;
            $user_update->save();

            // Account opening email to member
            if ($user->email != null  && env('MAIL_USERNAME') != null && (get_email_template('account_oppening_email', 'status') == 1)) {
                EmailUtility::account_oppening_email($user->id, $request->password);
            }

            // Account Opening SMS to member
            if ($user->phone != null && addon_activation('otp_system') && (get_sms_template('account_opening_by_admin', 'status') == 1)) {
                SmsUtility::account_opening_by_admin($user, $request->password);
            }

            flash('New member has been added successfully')->success();
            return redirect()->route('members.index', $membership);
        }

        flash('Sorry! Something went wrong.')->error();
        return back();
    }

    public function verification_form ()
    {   
        $user = auth()->user();
        if ($user->verification_info == null) {
            return view('frontend.member.member_verifiction_form', compact('user'));
        } else {
            flash(translate('Sorry! You have sent verification request already.'))->error();
            return back();
        }
    }

    public function verification_info_store(Request $request) {
        $data = array();
        $i = 0;
        foreach (json_decode(Setting::where('type', 'verification_form')->first()->value) as $key => $element) {
            $item = array();
            if ($element->type == 'text') {
                $item['type'] = 'text';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'select' || $element->type == 'radio') {
                $item['type'] = 'select';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'multi_select') {
                $item['type'] = 'multi_select';
                $item['label'] = $element->label;
                $item['value'] = json_encode($request['element_' . $i]);
            } elseif ($element->type == 'file') {
                $item['type'] = 'file';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i]->store('uploads/verification_form');
            }
            array_push($data, $item);
            $i++;
        }
        $user = auth()->user();
        $user->verification_info = json_encode($data);
        if ($user->save()) {

            $users = User::where('user_type', 'admin')->get();
            foreach ($users as $admin) {
                try {
                    $notify_type = 'member_verification';
                    $id = unique_notify_id();
                    $notify_by = $user->id;
                    $info_id = $user->id;
                    $message = translate('Member has sent verification info.');
                    $route = route('member.show_verification_info', encrypt($user->id));
    
                    Notification::send($admin, new DbStoreNotification($notify_type, $id, $notify_by, $info_id, $message, $route));
                } catch (\Exception $e) {
                    // dd($e);
                }
            }
            flash(translate('Your verification request has been submitted successfully!'))->success();
            return redirect()->route('dashboard');
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = User::findOrFail(decrypt($id));
        $present_address = Address::where('user_id',$member->id)->where('type','present')->first();
        $educations = Education::where('user_id',$member->id)->orderBy('is_highest_degree', 'desc')->get();
        $careers = Career::where('user_id',$member->id)->orderBy('present', 'desc')->get();
        $permanent_address = Address::where('user_id', $member->id)->where('type', 'permanent')->first();
        $additional_attributes  = AdditionalAttribute::where('status', 1)->get();

        return view('admin.members.view', compact('member', 'present_address', 'educations', 'careers', 'permanent_address', 'additional_attributes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['member']             = User::findOrFail(decrypt($id));
        $data['countries']          = Country::where('status', 1)->get();
        $data['states']             = State::all();
        $data['cities']             = City::all();
        $data['religions']          = Religion::all();
        $data['castes']             = Caste::all();
        $data['sub_castes']         = SubCaste::all();
        $data['family_values']      = FamilyValue::all();
        $data['marital_statuses']   = MaritalStatus::all();
        $data['on_behalves']        = OnBehalf::all();
        $data['languages']          = MemberLanguage::all();
        $data['additional_attributes']  = AdditionalAttribute::where('status', 1)->get();
        $data['annual_salary_ranges'] = AnnualSalaryRange::orderBy('min_salary','asc')->get();

        return view('admin.members.edit.index', $data);
    }


    public function introduction_edit(Request $request)
    {
        $member = User::findOrFail($request->id);
        return view('admin.members.edit_profile_attributes.introduction', compact('member'));
    }

    public function introduction_update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->introduction = $request->introduction;
        if ($member->save()) {
            flash('Member introduction info has been updated successfully')->success();
            return back();
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }

    public function basic_info_update(Request $request, $id)
    {
        $this->rules = [
            'first_name'    => ['required', 'max:255'],
            'last_name'     => ['required', 'max:255'],
            'gender'        => ['required'],
            'date_of_birth' => ['required'],
            'on_behalf'     => ['required'],
            'marital_status' => ['required'],
            'annual_salary_range' => ['required'],
        ];
        $this->messages = [
            'first_name.required'             => translate('First Name is required'),
            'first_name.max'                  => translate('Max 255 characters'),
            'last_name.required'              => translate('First Name is required'),
            'last_name.max'                   => translate('Max 255 characters'),
            'gender.required'                 => translate('Gender is required'),
            'date_of_birth.required'          => translate('Date Of Birth is required'),
            'on_behalf.required'              => translate('On Behalf is required'),
            'marital_status.required'         => translate('Marital Status is required'),
            'annual_salary_range.required'         => translate('Marital Status is required'),
        ];

        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }
        if ($request->email == null && $request->phone == null) {
            flash(translate('Email and Phone number both can not be null. '))->error();
            return back();
        }

        $user               = User::findOrFail($request->id);
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;

        if (get_setting('profile_picture_approval_by_admin') && $request->photo != $user->photo && auth()->user()->user_type == 'member') {
            $user->photo_approved = 0;
        }
        $user->photo        = $request->photo;
        $user->phone        = $request->phone;
        $user->save();

        $member                     = Member::where('user_id', $request->id)->first();
        $member->gender             = $request->gender;
        $member->on_behalves_id     = $request->on_behalf;
        $member->birthday           = date('Y-m-d', strtotime($request->date_of_birth));
        $member->marital_status_id  = $request->marital_status;
        $member->children           = $request->children;
        $member->annual_salary_range_id = $request->annual_salary_range;
        
        if ($member->save()) {
            flash('Member basic info  has been updated successfully')->success();
            return back();
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }

    public function language_info_update(Request $request, $id)
    {
        $member                     = Member::where('user_id', $request->id)->first();
        $member->mothere_tongue     = $request->mothere_tongue;
        $member->known_languages    = $request->known_languages;

        if ($member->save()) {
            flash('Member language info has been updated successfully')->success();
            return back();
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }

    public function show_verification_info ($id)
    {
        $user = User::findOrFail(decrypt($id));
        return view('admin.members.verification_info', compact('user'));
    }

    public function approve_verification($id)
    {
        $user             = User::findOrFail($id);
        $user->approved   = 1;
        if ($user->save()) {

            $status = 'Approved';
            
            // Member verification email send to members
            if ($user->email != null && get_email_template('member_verification_email', 'status')) {
                EmailUtility::member_verification_email($user, $status);
            }

            flash('Member Verified Successfully')->success();
            return redirect()->route('members.index', $user->membership);
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }
    
    public function reject_verification($id)
    {
        $user             = User::findOrFail($id);
        $user->verification_info   = null;
        if ($user->save()) {
            $status = 'Rejected';
            
            // Member verification email send to members
            if ($user->email != null && get_email_template('member_verification_email', 'status')) {
                EmailUtility::member_verification_email($user, $status);
            }

            flash('Member Verification Rejected.')->success();
            return redirect()->route('members.index', $user->membership);

        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }

    public function deleted_members(Request $request)
    {
        $sort_search        = null;
        $deleted_members    = User::onlyTrashed();
       
        if ($request->has('search')) {
            $sort_search  = $request->search;
            $deleted_members  = $deleted_members->where(function ($query) use ($sort_search){
                $query->where('code', $sort_search)
                    ->orwhere('first_name', 'like', '%' . $sort_search . '%')->orWhere('last_name', 'like', '%' . $sort_search . '%');
            });
        }
        $deleted_members = $deleted_members->paginate(10);
        return view('admin.members.deleted_members', compact('deleted_members', 'sort_search'));
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
        $user = User::findOrFail($id);

        $user->member()->delete();
        $user->addresses()->delete();
        $user->education()->delete();
        $user->career()->delete();
        $user->physical_attributes()->delete();
        $user->hobbies()->delete();
        $user->attitude()->delete();
        $user->recidency()->delete();
        $user->lifestyles()->delete();
        $user->astrologies()->delete();
        $user->families()->delete();
        $user->partner_expectations()->delete();
        $user->spiritual_backgrounds()->delete();
        $user->happy_story()->delete();
        $user->uploads()->delete();
        
        $chatThreads = ChatThread::where('sender_user_id', $user->id)->orWhere('receiver_user_id', $user->id)->get();
        foreach($chatThreads as $chatThread){
            $chatThread->chats()->delete(); 
        }
        foreach($chatThreads as $chatThread){
            $chatThread->delete(); 
        }

        if (User::destroy($id)) {
            flash('Member has been added to the deleted member list')->success();
        } else {
            flash('Sorry! Something went wrong.')->error();
        }
        return back();
    }

    public function restore_deleted_member($id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        $user->member()->withTrashed()->restore();
        $user->addresses()->withTrashed()->restore();
        $user->education()->withTrashed()->restore();
        $user->career()->withTrashed()->restore();
        $user->physical_attributes()->withTrashed()->restore();
        $user->hobbies()->withTrashed()->restore();
        $user->attitude()->withTrashed()->restore();
        $user->recidency()->withTrashed()->restore();
        $user->lifestyles()->withTrashed()->restore();
        $user->astrologies()->withTrashed()->restore();
        $user->families()->withTrashed()->restore();
        $user->partner_expectations()->withTrashed()->restore();
        $user->spiritual_backgrounds()->withTrashed()->restore();
        $user->happy_story()->withTrashed()->restore();
        $user->uploads()->withTrashed()->restore();
        
        $chatThreads = ChatThread::withTrashed()->where('sender_user_id', $user->id)->orWhere('receiver_user_id', $user->id)->get();
        foreach($chatThreads as $chatThread){
            $chatThread->chats()->withTrashed()->restore(); 
        }
        foreach($chatThreads as $chatThread){
            $chatThread->restore(); 
        }

        if (User::withTrashed()->where('id', $id)->restore()) {
            flash('Member has been restored successfully')->success();
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
        return back();
    }
    public function member_permanemtly_delete($id)
    {
        try {
            $user = User::withTrashed()->where('id', $id)->first();

            if (!$user) {
                flash(translate('User not found'))->error();
                return back();
            }

            $uploads = $user->uploads;
            if ($uploads) {
                foreach ($uploads as $upload) {
                    if (file_exists(public_path() . '/' . $upload->file_name)) {
                        unlink(public_path() . '/' . $upload->file_name);
                        $upload->withTrashed()->forcedelete();
                    }
                }
            }

            $user->addresses()->withTrashed()->forcedelete();
            $user->education()->withTrashed()->forcedelete();
            $user->career()->withTrashed()->forcedelete();
            $user->physical_attributes()->withTrashed()->forcedelete();
            $user->hobbies()->withTrashed()->forcedelete();
            $user->attitude()->withTrashed()->forcedelete();
            $user->recidency()->withTrashed()->forcedelete();
            $user->lifestyles()->withTrashed()->forcedelete();
            $user->astrologies()->withTrashed()->forcedelete();
            $user->families()->withTrashed()->forcedelete();
            $user->partner_expectations()->withTrashed()->forcedelete();
            $user->spiritual_backgrounds()->withTrashed()->forcedelete();
            $user->happy_story()->withTrashed()->forcedelete();
            $user->uploads()->withTrashed()->forcedelete();

            $user->gallery_images()->delete();
            Shortlist::where('user_id', $user->id)->orWhere('shortlisted_by',$user->id)->delete();
            IgnoredUser::where('user_id', $user->id)->orWhere('ignored_by',$user->id)->delete();
            ReportedUser::where('user_id', $user->id)->orWhere('reported_by',$user->id)->delete();
            ExpressInterest::where('user_id', $user->id)->orWhere('interested_by',$user->id)->delete();
            ProfileMatch::where('user_id', $user->id)->orWhere('match_id',$user->id)->delete();
            
            $chatThreads = ChatThread::withTrashed()->where('sender_user_id', $user->id)->orWhere('receiver_user_id', $user->id)->get();
            foreach($chatThreads as $chatThread){
                $chatThread->chats()->withTrashed()->forcedelete(); 
            }

            foreach($chatThreads as $chatThread){
                $chatThread->forcedelete(); 
            }
            
            $user->member()->withTrashed()->forcedelete();
            $user->forcedelete();

            flash(translate('Member permanently deleted successfully'))->success();
            return back();
        } catch (\Exception $e) {
            \Log::error('Error in member_permanemtly_delete: ' . $e->getMessage());
            flash(translate('Sorry! Something went wrong while deleting the member.'))->error();
            return back();
        }
    }

    public function package_info(Request $request)
    {
        $member = Member::where('user_id', $request->id)->first();
        return view('admin.members.package_modal', compact('member'));
    }

    public function get_package(Request $request)
    {
        $member_id = $request->id;
        $packages  = Package::where('active', 1)->get();
        return view('admin.members.get_package', compact('member_id', 'packages'));
    }

    public function package_do_update(Request $request, $id)
    {

        $member                                 = Member::where('id', $id)->first();
        $package                                = Package::where('id', $request->package_id)->first();
        $member->current_package_id             = $package->id;
        $member->remaining_interest             = $member->remaining_interest + $package->express_interest;
        $member->remaining_photo_gallery        = $member->remaining_photo_gallery + $package->photo_gallery;
        $member->remaining_contact_view         = $member->remaining_contact_view + $package->contact;
        $member->remaining_profile_viewer_view  = $member->remaining_profile_viewer_view + $package->profile_viewers_view;
        $member->remaining_profile_image_view   = $member->remaining_profile_image_view + $package->profile_image_view;
        $member->remaining_gallery_image_view   = $member->remaining_gallery_image_view + $package->gallery_image_view;

        $member->auto_profile_match         = $package->auto_profile_match;
        $member->package_validity           = date('Y-m-d', strtotime($member->package_validity . ' +' . $package->validity . 'days'));
        $membership                         = $package->id == 1 ? 1 : 2;

        if ($member->save()) {
            $user                = User::where('id', $member->user_id)->first();
            $user->membership    = $membership;
            if ($user->save()) {
                flash(translate('Member package has been updated successfully'))->success();
                return redirect()->route('members.index', $membership);
            }
        }
        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function member_wallet_balance_update(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        $wallet                   = new Wallet;
        $wallet->user_id          = $user->id;
        $wallet->amount           = $request->wallet_amount;
        $wallet->payment_method   = $request->payment_option;
        $wallet->payment_details  = '';
        $wallet->save();

        if ($request->payment_option == 'added_by_admin') {
            $user->balance = $user->balance + $request->wallet_amount;
        } elseif ($request->payment_option == 'deducted_by_admin') {
            $user->balance = $user->balance - $request->wallet_amount;
        }

        if ($user->save()) {
            flash(translate('Wallet Balance Updated Successfully'))->success();
            return back();
        } else {
            flash(translate('Something Went Wrong!'))->error();
            return back();
        }
    }

    public function block(Request $request)
    {
        $user           = User::findOrFail($request->member_id);
        $user->blocked  = $request->block_status;
        if ($user->save()) {
            $member                 = Member::where('user_id', $user->id)->first();
            $member->blocked_reason = !empty($request->blocking_reason) ? $request->blocking_reason : "";
            if ($member->save()) {

                flash($user->blocked == 1 ? translate('Member Blocked !') : translate('Member Unblocked !'))->success();
                return back();
            }
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }

    public function blocking_reason(Request $request)
    {
        $blocked_reason = Member::where('user_id', $request->id)->first()->blocked_reason;
        return $blocked_reason;
    }

    // Login by admin as a Member
    public function login($id)
    {
        $user = User::findOrFail(decrypt($id));
        auth()->login($user, true);

        return redirect()->route('dashboard');
    }

    // Member Profile settings Frontend
    public function profile_settings()
    {
        $data['member']                 = User::findOrFail(Auth::user()->id);
        $data['countries']              = Country::where('status', 1)->get();
        $data['religions']              = Religion::all();
        $data['castes']                 = Caste::all();
        $data['family_values']          = FamilyValue::all();
        $data['marital_statuses']       = MaritalStatus::all();
        $data['on_behalves']            = OnBehalf::all();
        $data['languages']              = MemberLanguage::all();
        $data['additional_attributes']  = AdditionalAttribute::where('status', 1)->get();
        $data['annual_salary_ranges']   = AnnualSalaryRange::orderBy('min_salary','asc')->get();

        return view('frontend.member.profile.index', $data);
    }

    public function unapproved_profile_pictures()
    {
        $users = User::where('user_type', 'member')->where('photo_approved', 0)->latest()->paginate(10);
        return view('admin.members.unapproved_member_profile_pictures', compact('users'));
    }

    public function approve_profile_image(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->photo_approved = 1;
        if ($user->save()) {
            flash(translate('Profile Picture Approved Successfully'))->success();
            return 1;
        }
        return 0;
    }

    // Change Password
    public function change_password()
    {
        return view('frontend.member.password_change');
    }

    public function password_update(Request $request, $id)
    {
        $rules = [
            'old_password'      => ['required'],
            'password'          => ['min:8', 'required_with:confirm_password', 'same:confirm_password'],
            'confirm_password'  => ['min:8'],
        ];

        $messages = [
            'old_password.required'     => translate('Old Password is required'),
            'password.required_with'    => translate('Password and Confirm password are required'),
            'password.same'             => translate('Password and Confirmed password did not matched'),
            'confirm_password.min'      => translate('Max 8 characters'),
        ];

        $validator  = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $user = User::findOrFail($id);

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            flash(translate('Passwoed Updated successfully.'))->success();
            return redirect()->route('member.change_password');
        } else {
            flash(translate('Old password do not matched.'))->error();
            return back();
        }
    }

    public function update_account_deactivation_status(Request $request)
    {
        $user = Auth::user();
        $user->deactivated = $request->deacticvation_status;
        $deacticvation_msg = $request->deacticvation_status == 1 ? translate('deactivated') : translate('reactivated');
        if ($user->save()) {
            flash(translate('Your account ') . $deacticvation_msg . translate(' successfully!'))->success();
            return redirect()->route('dashboard');
        }
        flash(translate('Something Went Wrong!'))->error();
        return back();
    }
    public function account_delete(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->member ?  $user->member->delete() : '';
            Address::where('user_id', $user->id)->delete();
            Education::where('user_id', $user->id)->delete();
            Career::where('user_id', $user->id)->delete();
            PhysicalAttribute::where('user_id', $user->id)->delete();
            Hobby::where('user_id', $user->id)->delete();
            Attitude::where('user_id', $user->id)->delete();
            Recidency::where('user_id', $user->id)->delete();
            Lifestyle::where('user_id', $user->id)->delete();
            Astrology::where('user_id', $user->id)->delete();
            Family::where('user_id', $user->id)->delete();
            PartnerExpectation::where('user_id', $user->id)->delete();
            SpiritualBackground::where('user_id', $user->id)->delete();
            PackagePayment::where('user_id', $user->id)->delete();
            HappyStory::where('user_id', $user->id)->delete();
            Staff::where('user_id', $user->id)->delete();
            ChatThread::where('sender_user_id', auth()->user()->id)->orWhere('receiver_user_id', auth()->user()->id)->delete();
            Upload::where('user_id', $user->id)->delete();
            User::destroy(auth()->user()->id);
            flash(translate('Your account has deleted successfully!'))->success();
            auth()->guard()->logout();
        }
        flash(translate('Something Went Wrong!'))->error();
        return back();
    }

    public function uploadAstrologyReport($id)
    {
       $member = User::findOrFail(decrypt($id));
       $memberId = decrypt($id);
       
       // Fetch astrologies with left joins for sun_sign, moon_sign, and lagnam
       $astrologies = Astrology::where('user_id', $memberId)
           ->leftJoin('sun_signs', function($join) {
               $join->where(function($query) {
                   $query->whereColumn('astrologies.sun_sign', DB::raw('CAST(sun_signs.id AS CHAR)'))
                         ->orWhereColumn('astrologies.sun_sign', 'sun_signs.name');
               });
           })
           ->leftJoin('moon_signs', function($join) {
               $join->where(function($query) {
                   $query->whereColumn('astrologies.moon_sign', DB::raw('CAST(moon_signs.id AS CHAR)'))
                         ->orWhereColumn('astrologies.moon_sign', 'moon_signs.name');
               });
           })
           ->leftJoin('sun_signs as lagnam_sun_signs', function($join) {
               $join->where(function($query) {
                   $query->whereColumn('astrologies.lagnam', DB::raw('CAST(lagnam_sun_signs.id AS CHAR)'))
                         ->orWhereColumn('astrologies.lagnam', 'lagnam_sun_signs.name');
               });
           })
           ->select(
               'astrologies.*',
               'sun_signs.id as sun_sign_id',
               'sun_signs.name as sun_sign_name',
               'moon_signs.id as moon_sign_id',
               'moon_signs.name as moon_sign_name',
               'lagnam_sun_signs.id as lagnam_id',
               'lagnam_sun_signs.name as lagnam_name'
           )
           ->first();
       
       $report = AstrologyReport::where('memberId', $memberId)->first();
       
       // Get all sun signs and moon signs for dropdowns
       $sun_signs = \App\Models\SunSign::orderBy('name')->get();
       $moon_signs = \App\Models\MoonSign::orderBy('name')->get();
       
       return view('admin.members.uploadAstrologyReport', compact('member', 'memberId', 'report', 'astrologies', 'sun_signs', 'moon_signs'));
    }

    public function storeAstrologyReport(Request $request)
    {
     
        try {
            // Sanitize and prepare array data
            $rasiData = array_map(function($value) {
                return $value ?: '';
            }, array_values($request->rasi));
            
            $navamsaData = array_map(function($value) {
                return $value ?: '';
            }, array_values($request->navamsa));
            
            // Get names from IDs if provided (handle both ID and name for backward compatibility)
            $birth_star_name = null;
            if ($request->birth_star) {
                if (is_numeric($request->birth_star)) {
                    $moon_sign = \App\Models\MoonSign::find($request->birth_star);
                    $birth_star_name = $moon_sign ? $moon_sign->name : $request->birth_star;
                } else {
                    $birth_star_name = $request->birth_star;
                }
            }
            
            $birth_rasi_name = null;
            if ($request->birth_rasi) {
                if (is_numeric($request->birth_rasi)) {
                    $sun_sign = \App\Models\SunSign::find($request->birth_rasi);
                    $birth_rasi_name = $sun_sign ? $sun_sign->name : $request->birth_rasi;
                } else {
                    $birth_rasi_name = $request->birth_rasi;
                }
            }
            
            $birth_lagnam_name = null;
            if ($request->birth_lagnam) {
                if (is_numeric($request->birth_lagnam)) {
                    $lagnam_sign = \App\Models\SunSign::find($request->birth_lagnam);
                    $birth_lagnam_name = $lagnam_sign ? $lagnam_sign->name : $request->birth_lagnam;
                } else {
                    $birth_lagnam_name = $request->birth_lagnam;
                }
            }
            
            // Update or create Astrology record with sun sign and moon sign from request
            $astrologies = Astrology::where('user_id', $request->memberId)->first();
            if (empty($astrologies)) {
                $astrologies = new Astrology();
                $astrologies->user_id = $request->memberId;
            }
            
            // Update sun sign, moon sign, and lagnam from request
            if ($request->birth_rasi) {
                $astrologies->sun_sign = $request->birth_rasi;
            }
            if ($request->birth_star) {
                $astrologies->moon_sign = $request->birth_star;
            }
            if ($request->birth_lagnam) {
                $astrologies->lagnam = $request->birth_lagnam;
            }
            $astrologies->save();
            
            $report = AstrologyReport::where('memberId', $request->memberId)->first();

            if ($report) {
                // Update existing
                $report->birth_star = $birth_star_name;
                $report->birth_rasi = $birth_rasi_name;
                $report->birth_lagnam = $birth_lagnam_name;
                $report->dasa_bukthi = $request->dasa_bukthi;
                $report->dosham = $request->dosham;
                $report->parigaram = $request->parigaram;
                $report->rasi = json_encode($rasiData);
                $report->navamsa = json_encode($navamsaData);
                $report->rec_stars = $request->rec_stars;
                $report->rec_rasi = $request->rec_rasi;
                $report->rec_lagnams = $request->rec_lagnams;
                $report->rec_dosham = $request->rec_dosham;
                $report->direction = $request->direction;
                $report->location = $request->location;
                $report->save();
            } else {
                // Create new
                $report = new AstrologyReport();
                $report->memberId = $request->memberId;
                $report->birth_star = $birth_star_name;
                $report->birth_rasi = $birth_rasi_name;
                $report->birth_lagnam = $birth_lagnam_name;
                $report->dasa_bukthi = $request->dasa_bukthi;
                $report->dosham = $request->dosham;
                $report->parigaram = $request->parigaram;
                $report->rasi = json_encode($rasiData);
                $report->navamsa = json_encode($navamsaData);
                $report->rec_stars = $request->rec_stars;
                $report->rec_rasi = $request->rec_rasi;
                $report->rec_lagnams = $request->rec_lagnams;
                $report->rec_dosham = $request->rec_dosham;
                $report->direction = $request->direction;
                $report->location =$request->location;
                $report->save();
            }
            
            // Generate PDF report and send email
            $reportStatus = $this->sendReportMail($request->memberId);

            if (!empty($reportStatus['pdf_generated'])) {
                if (!empty($reportStatus['email_sent'])) {
                    flash(translate('Astrology report created, PDF generated and emailed successfully!'))->success();
                } else {
                    flash(translate('Astrology report created and PDF generated, but email delivery failed. Please check mail settings.'))->warning();
                }
            } else {
                flash(translate('Astrology report created but PDF generation failed. Please try again.'))->warning();
            }
            
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error('Astrology report creation error: ' . $e->getMessage());
            flash(translate('Failed to create astrology report: ' . $e->getMessage()))->error();
            return redirect()->back()->withInput();
        }
    }

    // public function sendReportMail($memberId)
    // {
    //     try {
    //         $member = User::find($memberId);
    //         $report = AstrologyReport::where('memberId', $memberId)->first();
            
    //         if (!$member || !$report) {
    //             throw new \Exception("Member or report not found");
    //         }

    //         // Configuration array for PDF
    //         $config = [
    //             'mode' => 'utf-8',
    //             'format' => 'A4',
    //             'orientation' => 'portrait',
    //             'margin_top' => 15,
    //             'margin_right' => 15,
    //             'margin_bottom' => 15,
    //             'margin_left' => 15,
    //             'dpi' => 300,
    //             'isHtml5ParserEnabled' => true,
    //             'isRemoteEnabled' => true,
    //             'defaultFont' => 'sans-serif',
    //             'enable_css_float' => true,
    //             'chroot' => public_path()
    //         ];

    //         // Generate PDF with configuration
    //         $pdf = PDF::loadView('admin.members.astrologyreportpdf', [
    //             'member' => $member,
    //             'report' => $report
    //         ], [], $config);

    //         // Storage path
    //         $storagePath = storage_path('app/public/astrology_reports/');
    //         if (!file_exists($storagePath)) {
    //             mkdir($storagePath, 0777, true);
    //         }

    //         $pdfName = 'report_'.time().'.pdf';
    //         $fullPath = $storagePath.$pdfName;

    //         // Save using output() instead of save()
    //         file_put_contents($fullPath, $pdf->output());

    //         // Update database
    //         if ($report) {
    //             $report->pdfName = $pdfName;
    //             $report->save();
    //         }

    //         return true;

    //     } catch (\Exception $e) {
    //         \Log::error('PDF Generation Error: '.$e->getMessage());
    //         return false;
    //     }
    // }

    public function sendReportMail($memberId)
    {
        $status = [
            'pdf_generated' => false,
            'email_sent' => false,
        ];

        try {
            $member = User::with(['member'])->find($memberId);
            $report = AstrologyReport::where('memberId', $memberId)->first();
            
            if (!$member || !$report) {
                throw new \Exception("Member or report not found");
            }

            // Fetch astrologies with left joins for sun_sign, moon_sign, and lagnam
            $astrologies = Astrology::where('user_id', $memberId)
                ->leftJoin('sun_signs', function($join) {
                    $join->where(function($query) {
                        $query->whereColumn('astrologies.sun_sign', DB::raw('CAST(sun_signs.id AS CHAR)'))
                              ->orWhereColumn('astrologies.sun_sign', 'sun_signs.name');
                    });
                })
                ->leftJoin('moon_signs', function($join) {
                    $join->where(function($query) {
                        $query->whereColumn('astrologies.moon_sign', DB::raw('CAST(moon_signs.id AS CHAR)'))
                              ->orWhereColumn('astrologies.moon_sign', 'moon_signs.name');
                    });
                })
                ->leftJoin('sun_signs as lagnam_sun_signs', function($join) {
                    $join->where(function($query) {
                        $query->whereColumn('astrologies.lagnam', DB::raw('CAST(lagnam_sun_signs.id AS CHAR)'))
                              ->orWhereColumn('astrologies.lagnam', 'lagnam_sun_signs.name');
                    });
                })
                ->select(
                    'astrologies.*',
                    'sun_signs.id as sun_sign_id',
                    'sun_signs.name as sun_sign_name',
                    'moon_signs.id as moon_sign_id',
                    'moon_signs.name as moon_sign_name',
                    'lagnam_sun_signs.id as lagnam_id',
                    'lagnam_sun_signs.name as lagnam_name'
                )
                ->first();

            // Prepare data for the view with robust error handling
            try {
                $rasiValues = [];
                $navamsaValues = [];
                
                if ($report->rasi) {
                    $decodedRasi = json_decode($report->rasi, true);
                    if (is_array($decodedRasi)) {
                        $rasiValues = $decodedRasi;
                    }
                }
                
                if ($report->navamsa) {
                    $decodedNavamsa = json_decode($report->navamsa, true);
                    if (is_array($decodedNavamsa)) {
                        $navamsaValues = $decodedNavamsa;
                    }
                }
                
                // Ensure arrays have exactly 12 elements with numeric keys
                $rasiValues = array_values(array_pad($rasiValues, 12, ''));
                $navamsaValues = array_values(array_pad($navamsaValues, 12, ''));
                
                // Log for debugging
                \Log::info('Rasi Values: ' . json_encode($rasiValues));
                \Log::info('Navamsa Values: ' . json_encode($navamsaValues));
                
            } catch (\Exception $e) {
                \Log::error('Error preparing chart data: ' . $e->getMessage());
                $rasiValues = array_fill(0, 12, '');
                $navamsaValues = array_fill(0, 12, '');
            }
            
            // Use names from joined tables, fallback to report values if not available
            $birth_rasi_name = $astrologies && $astrologies->sun_sign_name ? $astrologies->sun_sign_name : ($report->birth_rasi ?? 'N/A');
            $birth_star_name = $astrologies && $astrologies->moon_sign_name ? $astrologies->moon_sign_name : ($report->birth_star ?? 'N/A');
            $birth_lagnam_name = $astrologies && $astrologies->lagnam_name ? $astrologies->lagnam_name : ($report->birth_lagnam ?? 'N/A');
            
            $data = [
                'member' => $member,
                'report' => $report,
                'rasiValues' => $rasiValues,
                'navamsaValues' => $navamsaValues,
                'currentDate' => now()->format('d-m-Y'),
                'birth_rasi_name' => $birth_rasi_name,
                'birth_star_name' => $birth_star_name,
                'birth_lagnam_name' => $birth_lagnam_name
            ];
            
            // DEBUG: Log the actual values
            \Log::info('PDF Data - birth_rasi_name: ' . $birth_rasi_name);
            \Log::info('PDF Data - birth_star_name: ' . $birth_star_name);
            \Log::info('PDF Data - birth_lagnam_name: ' . $birth_lagnam_name);
            \Log::info('Birth rasi Unicode: ' . bin2hex(mb_substr($birth_rasi_name, 0, 10)));
            \Log::info('Birth star Unicode: ' . bin2hex(mb_substr($birth_star_name, 0, 10)));

            // PDF configuration - Tamil support requires proper font
            $droidSansFallbackPath = base_path('public/assets/fonts/DroidSansFallback.ttf');
            $notoSansTamilPath = base_path('public/assets/fonts/NotoSansTamil-Regular.ttf');
            $arnamuPath = base_path('public/assets/fonts/arnamu.ttf');
            $defaultFont = 'freesans'; // Default font
            
            // Get the PDF config and conditionally remove fonts if files don't exist
            $pdfConfig = config('pdf', []);
            
            // Check for fonts in order of preference
            $useDroidSansFallback = false;
            $useNotoSans = false;
            $useArnamu = false;
            
            \Log::info('Checking DroidSansFallback path: ' . $droidSansFallbackPath);
            \Log::info('DroidSansFallback exists: ' . (file_exists($droidSansFallbackPath) ? 'YES' : 'NO'));
            
            if (file_exists($droidSansFallbackPath)) {
                $fileInfo = @file_get_contents($droidSansFallbackPath, false, null, 0, 4);
                if ($fileInfo && bin2hex($fileInfo) !== '3c68746d6c' && $fileInfo[0] !== '<') {
                    $useDroidSansFallback = true;
                    $defaultFont = 'droidsansfallback';
                    \Log::info('✓ Using DroidSansFallback font - supports BOTH English AND Tamil');
                }
            }
            
            if (!$useDroidSansFallback && file_exists($notoSansTamilPath)) {
                $fileInfo = @file_get_contents($notoSansTamilPath, false, null, 0, 4);
                if ($fileInfo && bin2hex($fileInfo) !== '3c68746d6c' && $fileInfo[0] !== '<') {
                    $useNotoSans = true;
                    $defaultFont = 'notosanstamil';
                    \Log::info('⚠ Using NotoSansTamil font - Tamil only, English may not display');
                }
            }
            
            if (!$useNotoSans && file_exists($arnamuPath)) {
                $fileInfo = @file_get_contents($arnamuPath, false, null, 0, 4);
                if ($fileInfo && bin2hex($fileInfo) !== '3c68746d6c' && $fileInfo[0] !== '<') {
                    $useArnamu = true;
                    $defaultFont = 'arnamu';
                    \Log::info('Using arnamu font for PDF generation');
                } else {
                    \Log::warning('arnamu.ttf exists but appears to be invalid. Removing from config.');
                    unset($pdfConfig['font_data']['arnamu']);
                }
            }
            
            if (!$useDroidSansFallback && isset($pdfConfig['font_data']['droidsansfallback'])) {
                unset($pdfConfig['font_data']['droidsansfallback']);
            }
            if (!$useNotoSans && isset($pdfConfig['font_data']['notosanstamil'])) {
                unset($pdfConfig['font_data']['notosanstamil']);
            }
            if (!$useArnamu && isset($pdfConfig['font_data']['arnamu'])) {
                unset($pdfConfig['font_data']['arnamu']);
            }
            
            if (!$useDroidSansFallback && !$useNotoSans && !$useArnamu) {
                \Log::warning('No valid Tamil font file found. Using freesans. Tamil characters may not display correctly.');
            }
            
            $config = array_merge($pdfConfig, [
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'portrait',
                'margin_top' => 15,
                'margin_right' => 15,
                'margin_bottom' => 15,
                'margin_left' => 15,
                'default_font' => $defaultFont,
                'font_path' => base_path('public/assets/fonts/'),
                'tempDir' => base_path('temp/'),
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'autoScriptToLang' => true,
                'autoLangToFont' => true,
                'autoVietnamese' => true,
                'autoArabic' => true
            ]);
            
            \Log::info('Final PDF default_font: ' . $defaultFont);
            \Log::info('Available fonts in config: ' . json_encode(array_keys($config['font_data'] ?? [])));
            \Log::info('Font path: ' . ($config['font_path'] ?? 'NOT SET'));
            \Log::info('DroidSansFallback config: ' . json_encode($config['font_data']['droidsansfallback'] ?? 'NOT SET'));

            $pdfName = null;
            $fullPath = null;

            // Generate PDF with error handling - Use direct mPDF for Tamil support
            try {
                // Get mPDF default font directories and add our custom fonts
                $defaultFontDirs = (new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'];
                $defaultFontData = (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'];
                
                // Only include fonts that actually exist in our directory
                $customFonts = [];
                if ($useDroidSansFallback && isset($config['font_data']['droidsansfallback'])) {
                    $customFonts['droidsansfallback'] = $config['font_data']['droidsansfallback'];
                }
                if ($useNotoSans && isset($config['font_data']['notosanstamil'])) {
                    $customFonts['notosanstamil'] = $config['font_data']['notosanstamil'];
                }
                
                // Load the full PDF config with Tamil font support
                $mpdf = new Mpdf([
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'tempDir' => base_path('temp/'),
                    'fontDir' => array_merge($defaultFontDirs, [base_path('public/assets/fonts/')]),
                    'fontdata' => array_merge($defaultFontData, $customFonts),
                    'default_font' => $defaultFont,
                    'autoScriptToLang' => true,
                    'autoLangToFont' => true,
                ]);
                
                $html = view('admin.members.astrologyreportpdf', $data)->render();
                
                \Log::info('HTML contains Tamil: ' . (preg_match('/[\x{0B80}-\x{0BFF}]/u', $html) ? 'YES' : 'NO'));
                \Log::info('mPDF initialized with font: ' . $defaultFont);
                \Log::info('Custom fonts loaded: ' . json_encode(array_keys($customFonts)));
                
                $mpdf->WriteHTML($html);
                
                $storagePath = storage_path('app/public/astrology_reports/');
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0777, true);
                }

                $pdfName = 'astrology_report_'.$memberId.'_'.time().'.pdf';
                $fullPath = $storagePath.$pdfName;

                file_put_contents($fullPath, $mpdf->Output('', 'S'));
                $status['pdf_generated'] = true;
                
                \Log::info('PDF generated successfully with direct mPDF - Tamil support enabled');
                
            } catch (\Exception $pdfError) {
                \Log::error('PDF Generation Error: ' . $pdfError->getMessage());
                \Log::error('PDF Error trace: ' . $pdfError->getTraceAsString());
                throw $pdfError;
            }

            if ($status['pdf_generated'] && $report) {
                $report->pdfName = $pdfName;
                $report->save();
            }

            if ($status['pdf_generated'] && $fullPath && file_exists($fullPath)) {
                if (!empty($member->email)) {
                    try {
                        Mail::to($member->email)->send(new AstrologyReportMail($member, $report, $fullPath, $pdfName));
                        $status['email_sent'] = true;
                        \Log::info('Astrology report emailed to '.$member->email);
                    } catch (\Exception $mailException) {
                        \Log::error('Astrology report email error for member '.$memberId.': '.$mailException->getMessage());
                        $status['email_error'] = $mailException->getMessage();
                    }
                } else {
                    \Log::warning('Astrology report email skipped: member '.$memberId.' has no email address.');
                }
            }

            return $status;

        } catch (\Exception $e) {
            \Log::error('PDF Generation Error for member '.$memberId.': '.$e->getMessage());
            $status['error'] = $e->getMessage();
            return $status;
        }
    }

    public function testtr()
    {
        try {
            // Use direct mPDF with minimal config - let it auto-detect Tamil
            $mpdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
            ]);

            $data = ['message' => 'வணக்கம் உலகம்! இது ஒரு தமிழ் PDF.'];
            
            // Render the view
            $html = view('test_tamil_pdf', $data)->render();
            
            $mpdf->WriteHTML($html);
            
            return $mpdf->Output('tamil_test_' . time() . '.pdf', 'D');
            
        } catch (\Exception $e) {
            \Log::error('Tamil PDF Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
