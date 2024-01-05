<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SuperadminController extends Controller
{
    public function __construct()
    {
        $this->middleware('superadmin');
    }

    public function dashboard()
    {
        return redirect('/all-company');
    }

    public function all_company()
    {
        $title = array('pageTitle' => "Dashboard");
        $headerTitle = "Dashboard";
        $companies = DB::table('company')
            ->select('company.*', DB::raw('COUNT(tbl_user.user_id) as user_count'))
            ->leftJoin('tbl_user', function ($join) {
                $join->on('company.company_id', '=', 'tbl_user.company_id')
                    ->where('tbl_user.is_delete', '=', 0)
                    ->where('tbl_user.admin_type', '=', 1);
            })
            ->where('company.is_delete', 0)
            ->groupBy('company.company_id')
            ->get();
        return view('web.company.all_company', ['title' => $title, 'headerTitle' => $headerTitle, 'companies' => $companies]);
    }

    public function create_company()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Company";
        return view('web.company.add_company', ['title' => $title, 'headerTitle' => $headerTitle]);
    }

    public function storeCompany(Request $request)
    {
        // $request->validate([
        //     'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        //     'admin_username' => 'required|unique:tbl_user,user_name'
        // ]);
        $filename1 = '';
        if ($request->file('company_logo')) {
            $image = $request->file('company_logo');
            $maxSize = 1024 * 1024;
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if ($image->getSize() <= $maxSize && in_array($image->getClientOriginalExtension(), $allowedExtensions)) {
                $extension = $image->extension();
                $file_name = mt_rand(100000, 999999);
                $rand = mt_rand(100000, 999999);
                $filename1 = 'web/company_logo/' . time() . "_" . $rand . "_" . $file_name . '.' . $extension;
                $image->move(public_path('web/company_logo'), $filename1);
            } else {
                $filename1 = '';
            }
        }

        $newCompanyId = DB::table('company')->insertGetId([
            'company_name' => $request->company_name,
            'company_phone' => $request->company_phone,
            'company_logo' => $filename1,
            'vat_registration' => $request->vat_registration,
            'address1_txt' => $request->address1_txt,
            'address2_txt' => $request->address2_txt,
            'address3_txt' => $request->address3_txt,
            'address4_txt' => $request->address4_txt,
            'postcode_txt' => $request->postcode_txt,
            'website' => $request->website,
            'finance_query_mail' => $request->finance_query_mail,
            'compliance_mail' => $request->compliance_mail,
            'vetting_enquiry_mail' => $request->vetting_enquiry_mail,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'sort_code' => $request->sort_code,
            'terms_and_condition' => $request->terms_and_condition,
            'payment_terms' => $request->payment_terms,
            'pref_payment_method' => $request->pref_payment_method,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if ($request->file('invoice_logo')) {
            foreach ($request->file('invoice_logo') as $key => $logo) {
                $maxSize = 1024 * 1024;
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                if ($logo->getSize() <= $maxSize && in_array($logo->getClientOriginalExtension(), $allowedExtensions)) {
                    $extension = $logo->extension();
                    $file_name = mt_rand(100000, 999999);
                    $rand = mt_rand(100000, 999999);
                    $filename2 = time() . "_" . $rand . "_" . $file_name . '.' . $extension;
                    $logo->move(public_path('web/company_logo/footer_images/'), $filename2);

                    DB::table('company_logo')->insert([
                        'company_id' => $newCompanyId,
                        'image_name' => $filename2,
                        'path' => 'web/company_logo/footer_images/'
                    ]);
                }
            }
        }

        // $image = $request->file('profileImage');
        // $extension = $image->extension();
        // $file_name = mt_rand(100000, 999999);
        // $rand = mt_rand(100000, 999999);
        // $filename3 = time() . "_" . $rand . "_" . $file_name . '.' . $extension;
        // $image->move(public_path('images/userimages'), $filename3);

        // $adminUserId = DB::table('tbl_user')
        //     ->insertGetId([
        //         'company_id' => $newCompanyId,
        //         'admin_type' => 1,
        //         'firstName_txt' => $request->admin_firstName,
        //         'surname_txt' => $request->admin_surName,
        //         'user_name' => $request->admin_username,
        //         'profileImage' => $filename3,
        //         'isActive' => $request->status,
        //         'profileImageLocation_txt' => 'images/userimages',
        //         'timestamp_ts' => date('Y-m-d H:i:s')
        //     ]);
        // return response()->json(['status' => 'success']);
        // $companyDetail = DB::table('company')
        //     ->select('company.*')
        //     ->where('company.company_id', $newCompanyId)
        //     ->first();

        // if ($request->admin_username) {
        //     $uID = base64_encode($adminUserId);
        //     $mailData['companyDetail'] = $companyDetail;
        //     $mailData['firstName_txt'] = $request->admin_firstName;
        //     $mailData['surname_txt'] = $request->admin_surName;
        //     $mailData['mail'] = $request->admin_username;
        //     $mailData['rUrl'] = url('/adminUser/set-password') . '/' . $uID;
        //     $myVar = new AlertController();
        //     $myVar->adminUserAddMail($mailData);
        // }

        return redirect('/all-company')->with('success', 'Company created successfully. Check user email for a password setup link.');
    }

    public function editCompany($id)
    {
        $title = array('pageTitle' => "Company");
        $headerTitle = "Company";
        if ($id) {
            $company = DB::table('company')->where('company_id', $id)->first();
            $companyImages = DB::table('company_logo')->where('company_id', $company->company_id)->get();
            return view('web.company.edit_company', ['title' => $title, 'headerTitle' => $headerTitle, 'company' => $company, 'companyImages' => $companyImages]);
        } else {
            return redirect()->back();
        }
    }

    public function updateCompany(Request $request)
    {
        $company = DB::table('company')->where('company_id', $request->company_id)->first();

        if ($request->file('company_logo')) {
            $image = $request->file('company_logo');
            $maxSize = 1024 * 1024;
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if ($image->getSize() <= $maxSize && in_array($image->getClientOriginalExtension(), $allowedExtensions)) {
                $extension = $image->extension();
                $file_name = mt_rand(100000, 999999);
                $rand = mt_rand(100000, 999999);
                $filename1 = 'web/company_logo/' . time() . "_" . $rand . "_" . $file_name . '.' . $extension;
                $image->move(public_path('web/company_logo'), $filename1);

                if (File::exists(public_path($company->company_logo))) {
                    File::delete(public_path($company->company_logo));
                }
            } else {
                $filename1 = $company->company_logo;
            }
        } else {
            $filename1 = $company->company_logo;
        }

        if ($request->file('invoice_logo')) {
            foreach ($request->file('invoice_logo') as $key => $logo) {
                $maxSize = 1024 * 1024;
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                if ($logo->getSize() <= $maxSize && in_array($logo->getClientOriginalExtension(), $allowedExtensions)) {
                    $extension = $logo->extension();
                    $file_name = mt_rand(100000, 999999);
                    $rand = mt_rand(100000, 999999);
                    $filename2 = time() . "_" . $rand . "_" . $file_name . '.' . $extension;
                    $logo->move(public_path('web/company_logo/footer_images/'), $filename2);

                    DB::table('company_logo')->insert([
                        'company_id' => $request->company_id,
                        'image_name' => $filename2,
                        'path' => 'web/company_logo/footer_images/'
                    ]);
                }
            }
        }

        DB::table('company')
            ->where('company_id', $request->company_id)
            ->update([
                'company_name' => $request->company_name,
                'company_phone' => $request->company_phone,
                'company_logo' => $filename1,
                'vat_registration' => $request->vat_registration,
                'address1_txt' => $request->address1_txt,
                'address2_txt' => $request->address2_txt,
                'address3_txt' => $request->address3_txt,
                'address4_txt' => $request->address4_txt,
                'postcode_txt' => $request->postcode_txt,
                'website' => $request->website,
                'finance_query_mail' => $request->finance_query_mail,
                'compliance_mail' => $request->compliance_mail,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'sort_code' => $request->sort_code,
                'terms_and_condition' => $request->terms_and_condition,
                'payment_terms' => $request->payment_terms,
                'pref_payment_method' => $request->pref_payment_method,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        return redirect()->back()->with('success', 'Company updated successfully.');
    }

    public function deleteCompany(Request $request)
    {
        if (isset($request->companyId)) {
            DB::table('company')->where('company_id', $request->companyId)->update(['is_delete' => 1]);
            DB::table('tbl_user')->where('company_id', $request->companyId)->update(['is_delete' => 1]);
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function allUsers($id)
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Management";
        $company = DB::table('company')->where('company_id', $id)->first();
        if (isset($company)) {

            $userAdmins = DB::table('tbl_user')
                ->where('is_delete', 0)
                ->where('admin_type', 1)
                ->where('company_id', $id)
                ->get();

            return view("web.company.allUsers", ['title' => $title, 'headerTitle' => $headerTitle, 'userAdmins' => $userAdmins, 'company' => $company]);
        } else {
            return redirect()->back();
        }
    }

    public function userEdit(Request $request)
    {
        $user_id = $request->adminId;

        $user = DB::table('tbl_user')->where('user_id', $user_id)->first();
        $imagePath = public_path($user->profileImageLocation_txt . '/' . $user->profileImage);
        if ($user->profileImage != '') {
            if (File::exists($imagePath)) {
                $image = asset($user->profileImageLocation_txt . '/' . $user->profileImage);
            } else {
                $image = '';
            }
        } else {
            $image = '';
        }

        return response()->json(['userAdmin' => $user, 'image' => $image]);
    }

    public function userUpdate(Request $request)
    {
        $emailExist = DB::table('tbl_user')
            ->where('company_id', $request->company_id)
            ->where('user_name', $request->edit_admin_username)
            ->where('admin_type', 1)
            ->where('is_delete', 0)
            ->where('user_id', '!=', $request->adminUserId)
            ->first();
        if ($emailExist) {
            return redirect()->back()->with('error', 'Email already exist.');
        }

        $adminUser = DB::table('tbl_user')->where('user_id', $request->adminUserId)->first();

        if ($request->file('edit_profileImage')) {
            $image = $request->file('edit_profileImage');
            $maxSize = 1024 * 1024;
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if ($image->getSize() <= $maxSize && in_array($image->getClientOriginalExtension(), $allowedExtensions)) {
                $extension = $image->extension();
                $file_name = mt_rand(100000, 999999);
                $rand = mt_rand(100000, 999999);
                $filename = time() . "_" . $rand . "_" . $file_name . '.' . $extension;
                $image->move(public_path('images/userimages'), $filename);

                $imagePath = public_path($adminUser->profileImageLocation_txt . '/' . $adminUser->profileImage);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
        } else {
            $filename = $request->old_image;
        }

        DB::table('tbl_user')
            ->where('user_id', $request->adminUserId)
            ->update([
                'firstName_txt' => $request->edit_admin_firstName,
                'surname_txt' => $request->edit_admin_surName,
                'user_name' => $request->edit_admin_username,
                'isActive' => $request->edit_status,
                'profileImageLocation_txt' => 'images/userimages',
                'profileImage' => $filename,
            ]);
        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function userDelete(Request $request)
    {
        if (isset($request->adminId)) {
            DB::table('tbl_user')->where('user_id', $request->adminId)->update(['is_delete' => 1, 'password' => '', 'isActive' => 0]);
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function userStatus(Request $request)
    {
        if (isset($request['adminId']) && isset($request['statusValue'])) {
            $adminUserid = $request['adminId'];
            DB::table('tbl_user')
                ->where('user_id', '=', $adminUserid)
                ->update([
                    'isActive' => $request['statusValue']
                ]);
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function deleteCompanyFooterImage(Request $request)
    {
        $imageDetails = DB::table('company_logo')->where('image_id', $request->imageId)->first();
        $imagePath = public_path($imageDetails->path . $imageDetails->image_name);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $status = DB::table('company_logo')->where('image_id', $request->imageId)->delete();
        if ($status) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function userAdd(Request $request)
    {
        $emailExist = DB::table('tbl_user')
            ->where('company_id', $request->company_id)
            ->where('user_name', $request->admin_username)
            ->where('admin_type', 1)
            ->where('is_delete', 0)
            ->first();

        if ($emailExist) {
            return redirect()->back()->with('error', 'Email already exist.');
        }
        // $request->validate([
        //     'profileImage' => 'required|image|mimes:jpeg,png,jpg|max:1024',
        //     'admin_username' => 'required|unique:tbl_user,user_name'
        // ]);

        $filename = '';
        if ($request->file('profileImage')) {
            $image = $request->file('profileImage');
            $maxSize = 1024 * 1024;
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if ($image->getSize() <= $maxSize && in_array($image->getClientOriginalExtension(), $allowedExtensions)) {
                $extension = $image->extension();
                $file_name = mt_rand(100000, 999999);
                $rand = mt_rand(100000, 999999);
                $filename = time() . "_" . $rand . "_" . $file_name . '.' . $extension;
                $image->move(public_path('images/userimages'), $filename);
            }
        }

        $adminUserId = DB::table('tbl_user')
            ->insertGetId([
                'company_id' => $request->company_id,
                'admin_type' => 1,
                'firstName_txt' => $request->admin_firstName,
                'surname_txt' => $request->admin_surName,
                'user_name' => $request->admin_username,
                'profileImage' => $filename,
                'isActive' => $request->status,
                'profileImageLocation_txt' => 'images/userimages',
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);

        $companyDetail = DB::table('company')
            ->select('company.*')
            ->where('company.company_id', $request->company_id)
            ->first();

        if ($request->admin_username) {
            $uID = base64_encode($adminUserId);
            $mailData['companyDetail'] = $companyDetail;
            $mailData['firstName_txt'] = $request->admin_firstName;
            $mailData['surname_txt'] = $request->admin_surName;
            $mailData['mail'] = $request->admin_username;
            $mailData['rUrl'] = url('/adminUser/set-password') . '/' . $uID;
            $myVar = new AlertController();
            $myVar->adminUserAddMail($mailData);
        }

        return redirect()->back()->with('success', 'User registered successfully. Check user email for a password setup link.');
    }

    /***************** system preference **************/
    public function system_assignment()
    {
        $title = array('pageTitle' => "Assignment Section");
        $headerTitle = "Assignment Section";

        $ageRangeList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 5)
            ->orderBy('tbl_description.description_txt', 'asc')
            ->get();

        $subjectList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 6)
            ->orderBy('tbl_description.description_txt', 'asc')
            ->get();

        $yearGrList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 34)
            ->orderBy('tbl_description.description_txt', 'asc')
            ->get();

        $assLengthList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 35)
            ->orderBy('tbl_description.description_txt', 'asc')
            ->get();

        $profTypeList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 7)
            ->orderBy('tbl_description.description_txt', 'asc')
            ->get();

        return view('web.superAdmin.assignment_sec', ['title' => $title, 'headerTitle' => $headerTitle, 'ageRangeList' => $ageRangeList, 'subjectList' => $subjectList, 'yearGrList' => $yearGrList, 'assLengthList' => $assLengthList, 'profTypeList' => $profTypeList]);
    }

    // age range
    public function sysAddAgeRange(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 5)
            ->where('description_txt', $request->age_range)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'Age range already exist.');
        }

        $maxDescriptionInt = DB::table('tbl_description')
            ->where('descriptionGroup_int', 5)
            ->max('description_int');
        DB::table('tbl_description')
            ->insertGetId([
                'descriptionGroup_int' => 5,
                'description_txt' => $request->age_range,
                'description_int' => $maxDescriptionInt + 1,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Age range added successfully.');
    }

    public function sysEditAgeRange(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 5)
            ->where('description_txt', $request->age_range)
            ->where('description_int', '!=', $request->ageId)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'Age range already exist.');
        }

        DB::table('tbl_description')
            ->where('descriptionGroup_int', 5)
            ->where('description_int', $request->ageId)
            ->update([
                'description_txt' => $request->age_range,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Age range updated successfully.');
    }

    public function sysDeleteAgeRange(Request $request)
    {
        if (isset($request->age_r_id)) {
            DB::table('tbl_description')
                ->where('descriptionGroup_int', 5)
                ->where('description_int', $request->age_r_id)
                ->delete();
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    // age range

    // subject
    public function sysAddSubject(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 6)
            ->where('description_txt', $request->subject)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'Subject already exist.');
        }

        $maxDescriptionInt = DB::table('tbl_description')
            ->where('descriptionGroup_int', 6)
            ->max('description_int');
        DB::table('tbl_description')
            ->insertGetId([
                'descriptionGroup_int' => 6,
                'description_txt' => $request->subject,
                'description_int' => $maxDescriptionInt + 1,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Subject added successfully.');
    }

    public function sysEditSubject(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 6)
            ->where('description_txt', $request->subject)
            ->where('description_int', '!=', $request->subjectId)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'Subject already exist.');
        }

        DB::table('tbl_description')
            ->where('descriptionGroup_int', 6)
            ->where('description_int', $request->subjectId)
            ->update([
                'description_txt' => $request->subject,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Subject updated successfully.');
    }

    public function sysDeleteSubject(Request $request)
    {
        if (isset($request->sub_id)) {
            DB::table('tbl_description')
                ->where('descriptionGroup_int', 6)
                ->where('description_int', $request->sub_id)
                ->delete();
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    // subject

    // year group
    public function sysAddYearGrp(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 34)
            ->where('description_txt', $request->year_group)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'Year group already exist.');
        }

        $maxDescriptionInt = DB::table('tbl_description')
            ->where('descriptionGroup_int', 34)
            ->max('description_int');
        DB::table('tbl_description')
            ->insertGetId([
                'descriptionGroup_int' => 34,
                'description_txt' => $request->year_group,
                'description_int' => $maxDescriptionInt + 1,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Year group added successfully.');
    }

    public function sysEditYearGrp(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 34)
            ->where('description_txt', $request->year_group)
            ->where('description_int', '!=', $request->yearId)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'Year group already exist.');
        }

        DB::table('tbl_description')
            ->where('descriptionGroup_int', 34)
            ->where('description_int', $request->yearId)
            ->update([
                'description_txt' => $request->year_group,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Year group updated successfully.');
    }

    public function sysDeleteYearGrp(Request $request)
    {
        if (isset($request->year_id)) {
            DB::table('tbl_description')
                ->where('descriptionGroup_int', 34)
                ->where('description_int', $request->year_id)
                ->delete();
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    // year group

    // Professional Type
    public function sysAddProfType(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 7)
            ->where('description_txt', $request->prof_type)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'Professional Type already exist.');
        }

        $maxDescriptionInt = DB::table('tbl_description')
            ->where('descriptionGroup_int', 7)
            ->max('description_int');
        DB::table('tbl_description')
            ->insertGetId([
                'descriptionGroup_int' => 7,
                'description_txt' => $request->prof_type,
                'description_int' => $maxDescriptionInt + 1,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Professional Type added successfully.');
    }

    public function sysEditProfType(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 7)
            ->where('description_txt', $request->prof_type)
            ->where('description_int', '!=', $request->profId)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'Professional Type already exist.');
        }

        DB::table('tbl_description')
            ->where('descriptionGroup_int', 7)
            ->where('description_int', $request->profId)
            ->update([
                'description_txt' => $request->prof_type,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Professional Type updated successfully.');
    }

    public function sysDeleteProfType(Request $request)
    {
        if (isset($request->prof_id)) {
            DB::table('tbl_description')
                ->where('descriptionGroup_int', 7)
                ->where('description_int', $request->prof_id)
                ->delete();
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    // Professional Type

    public function system_school()
    {
        $title = array('pageTitle' => "School Section");
        $headerTitle = "School Section";

        $ageRangeList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 28)
            ->orderBy('tbl_description.description_txt', 'asc')
            ->get();

        $schoolTypeList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 30)
            ->orderBy('tbl_description.description_txt', 'asc')
            ->get();

        return view('web.superAdmin.school_sec', ['title' => $title, 'headerTitle' => $headerTitle, 'ageRangeList' => $ageRangeList, 'schoolTypeList' => $schoolTypeList]);
    }

    // School age range
    public function sysAddSchAgeRange(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 28)
            ->where('description_txt', $request->age_range)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'Age range already exist.');
        }

        $maxDescriptionInt = DB::table('tbl_description')
            ->where('descriptionGroup_int', 28)
            ->max('description_int');
        DB::table('tbl_description')
            ->insertGetId([
                'descriptionGroup_int' => 28,
                'description_txt' => $request->age_range,
                'description_int' => $maxDescriptionInt + 1,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Age range added successfully.');
    }

    public function sysEditSchAgeRange(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 28)
            ->where('description_txt', $request->age_range)
            ->where('description_int', '!=', $request->ageId)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'Age range already exist.');
        }

        DB::table('tbl_description')
            ->where('descriptionGroup_int', 28)
            ->where('description_int', $request->ageId)
            ->update([
                'description_txt' => $request->age_range,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Age range updated successfully.');
    }

    public function sysDeleteSchAgeRange(Request $request)
    {
        if (isset($request->age_r_id)) {
            DB::table('tbl_description')
                ->where('descriptionGroup_int', 28)
                ->where('description_int', $request->age_r_id)
                ->delete();
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    // School age range

    // School School Type
    public function sysAddSchoolType(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 30)
            ->where('description_txt', $request->school_type)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'School Type already exist.');
        }

        $maxDescriptionInt = DB::table('tbl_description')
            ->where('descriptionGroup_int', 30)
            ->max('description_int');
        DB::table('tbl_description')
            ->insertGetId([
                'descriptionGroup_int' => 30,
                'description_txt' => $request->school_type,
                'description_int' => $maxDescriptionInt + 1,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'School Type added successfully.');
    }

    public function sysEditSchoolType(Request $request)
    {
        $NameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 30)
            ->where('description_txt', $request->school_type)
            ->where('description_int', '!=', $request->schoolId)
            ->first();
        if ($NameExist) {
            return redirect()->back()->with('error', 'School Type already exist.');
        }

        DB::table('tbl_description')
            ->where('descriptionGroup_int', 30)
            ->where('description_int', $request->schoolId)
            ->update([
                'description_txt' => $request->school_type,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'School Type updated successfully.');
    }

    public function sysDeleteSchoolType(Request $request)
    {
        if (isset($request->sch_id)) {
            DB::table('tbl_description')
                ->where('descriptionGroup_int', 30)
                ->where('description_int', $request->sch_id)
                ->delete();
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    // School School Type

    public function system_teacher()
    {
        $title = array('pageTitle' => "Teacher Section");
        $headerTitle = "Teacher Section";

        $bankList = DB::table('tbl_description')
            ->select('tbl_description.*')
            ->where('tbl_description.descriptionGroup_int', 36)
            ->orderBy('tbl_description.description_txt', 'asc')
            ->get();

        return view('web.superAdmin.teacher_sec', ['title' => $title, 'headerTitle' => $headerTitle, 'bankList' => $bankList]);
    }

    // bank
    public function sysAddBank(Request $request)
    {
        $bankNameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 36)
            ->where('description_txt', $request->bankName)
            ->first();
        if ($bankNameExist) {
            return redirect()->back()->with('error', 'Bank name already exist.');
        }

        $maxDescriptionInt = DB::table('tbl_description')
            ->where('descriptionGroup_int', 36)
            ->max('description_int');
        $bankId = DB::table('tbl_description')
            ->insertGetId([
                'descriptionGroup_int' => 36,
                'description_txt' => $request->bankName,
                'description_int' => $maxDescriptionInt + 1,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Bank added successfully.');
    }

    public function sysEditBank(Request $request)
    {
        $bankNameExist = DB::table('tbl_description')
            ->where('descriptionGroup_int', 36)
            ->where('description_txt', $request->bankName)
            ->where('description_int', '!=', $request->bankId)
            ->first();
        if ($bankNameExist) {
            return redirect()->back()->with('error', 'Bank name already exist.');
        }

        DB::table('tbl_description')
            ->where('descriptionGroup_int', 36)
            ->where('description_int', $request->bankId)
            ->update([
                'description_txt' => $request->bankName,
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        return redirect()->back()->with('success', 'Bank updated successfully.');
    }

    public function sysDeleteBank(Request $request)
    {
        if (isset($request->bank_id)) {
            DB::table('tbl_description')
                ->where('descriptionGroup_int', 36)
                ->where('description_int', $request->bank_id)
                ->delete();
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    // bank
    /***************** system preference **************/
}
