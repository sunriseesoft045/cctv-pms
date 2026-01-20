<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    /**
     * Show company profile
     */
    public function index()
    {
        $company = CompanyProfile::first();
        return view('admin.company-profile.index', compact('company'));
    }

    /**
     * Update company profile
     */
    public function update(Request $request, $id = null)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $company = CompanyProfile::first() ?? new CompanyProfile();

        $company->company_name = $request->company_name;
        $company->address = $request->address;
        $company->phone = $request->phone;
        $company->email = $request->email;

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('company', 'public');
            $company->logo = $logoPath;
        }

        $company->save();

        return redirect()->route('admin.company-profile.index')->with('success', 'Company profile updated successfully');
    }
}
