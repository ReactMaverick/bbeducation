<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    public function all_company()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Company";
        $companies = DB::table('company')->where('is_delete', 0)->get();
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
        $request->validate([
            'profileImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'admin_username' => 'required|unique:tbl_user,user_name'
        ]);

        if ($request->file('company_logo')) {
            $image = $request->file('company_logo');
            $extension = $image->extension();
            $file_name = mt_rand(100000, 999999);
            $rand = mt_rand(100000, 999999);
            $filename1 = 'web/company_logo/' . time() . "_" . $rand . "_" . $file_name . '.' . $extension;
            $image->move(public_path('web/company_logo'), $filename1);
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
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'sort_code' => $request->sort_code,
            'terms_and_condition' => $request->terms_and_condition,
            'payment_terms' => $request->payment_terms,
        ]);

        if ($request->file('invoice_logo')) {
            foreach ($request->file('invoice_logo') as $key => $logo) {
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

        $image = $request->file('profileImage');
        $extension = $image->extension();
        $file_name = mt_rand(100000, 999999);
        $rand = mt_rand(100000, 999999);
        $filename3 = time() . "_" . $rand . "_" . $file_name . '.' . $extension;
        $image->move(public_path('images/userimages'), $filename3);

        $adminUserId = DB::table('tbl_user')
            ->insertGetId([
                'company_id' => $newCompanyId,
                'admin_type' => 1,
                'firstName_txt' => $request->admin_firstName,
                'surname_txt' => $request->admin_surName,
                'user_name' => $request->admin_username,
                'profileImage' => $filename3,
                'isActive' => $request->status,
                'profileImageLocation_txt' => 'images/userimages',
                'timestamp_ts' => date('Y-m-d H:i:s')
            ]);
        // return response()->json(['status' => 'success']);
        $companyDetail = DB::table('company')
            ->select('company.*')
            ->where('company.company_id', $newCompanyId)
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

            if (File::exists(public_path($company->company_logo))) {
                File::delete(public_path($company->company_logo));
            }
            $image = $request->file('company_logo');
            $extension = $image->extension();
            $file_name = mt_rand(100000, 999999);
            $rand = mt_rand(100000, 999999);
            $filename1 = 'web/company_logo/' . time() . "_" . $rand . "_" . $file_name . '.' . $extension;
            $image->move(public_path('web/company_logo'), $filename1);
        } else {
            $filename1 = $company->company_logo;
        }
        if ($request->file('invoice_logo')) {
            foreach ($request->file('invoice_logo') as $key => $logo) {
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
            ]);
        return redirect('/all-company');
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

    public function allUsers()
    {
        $title = array('pageTitle' => "Management");
        $headerTitle = "Management";
        $userAdmins = DB::table('tbl_user')
            ->where('tbl_user.is_delete', 0)
            ->where('tbl_user.admin_type', 1)
            ->leftJoin('company', 'company.company_id', '=', 'tbl_user.company_id')
            ->get();

        return view("web.company.allUsers", ['title' => $title, 'headerTitle' => $headerTitle, 'userAdmins' => $userAdmins]);
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
        $request->validate([
            'edit_profileImage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $adminUser = DB::table('tbl_user')->where('user_id', $request->adminUserId)->first();

        if ($request->file('edit_profileImage')) {
            $imagePath = public_path($adminUser->profileImageLocation_txt . '/' . $adminUser->profileImage);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $image = $request->file('edit_profileImage');
            $extension = $image->extension();
            $file_name = mt_rand(100000, 999999);
            $rand = mt_rand(100000, 999999);
            $filename = time() . "_" . $rand . "_" . $file_name . '.' . $extension;
            $image->move(public_path('images/userimages'), $filename);
        } else {
            $filename = $request->old_image;
        }

        $user = DB::table('tbl_user')
            ->where('user_id', $request->adminUserId)
            ->update([
                'firstName_txt' => $request->edit_admin_firstName,
                'surname_txt' => $request->edit_admin_surName,
                'user_name' => $request->edit_admin_username,
                'isActive' => $request->edit_status,
                'profileImageLocation_txt' => 'images/userimages',
                'profileImage' => $filename,
            ]);
        return back()->with('success', 'User edited Successfully');
    }

    public function userDelete(Request $request)
    {
        if (isset($request->adminId)) {
            DB::table('tbl_user')->where('user_id', $request->adminId)->update(['is_delete' => 1]);
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
    
}
