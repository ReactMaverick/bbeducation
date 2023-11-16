<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return redirect('/all-company');

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

}
