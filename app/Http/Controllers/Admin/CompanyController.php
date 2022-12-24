<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Requests\MassDestroyCompanyRequest;
use App\Models\CompanyData;

class CompanyController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('isAdmin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::all();

        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        abort_if(Gate::denies('isAdmin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companies.create');
    }

    public function store(StoreCompanyRequest $request)
    {

        $company = Company::create($request->all());
        $companyID = $company->id;

        // dd($companyID);

        if (!$request->isNotFilled('email') || !$request->isNotFilled('phone')) {
            $this->addCompanyData($request, $companyID);
        }

        return redirect()->route('admin.companies.index');
    }

    public function edit(Company $company)
    {
        abort_if(Gate::denies('isAdmin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->all());

        if (!$request->isNotFilled('email') || !$request->isNotFilled('phone')) {
            $this->updateCompanyData($request, $company);
        }

        return redirect()->route('admin.companies.index');
    }

    public function show(Company $company)
    {
        abort_if(Gate::denies('isAdmin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.companies.show', compact('company'));
    }

    public function destroy(Company $company)
    {
        abort_if(Gate::denies('isAdmin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company->delete();

        return back();
    }

    public function massDestroy(MassDestroyCompanyRequest $request)
    {
        Company::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function addCompanyData($request, $companyID)
    {
        $company = new CompanyData();
        $company->company_id = $companyID;
        $company->phone = $request->phone;
        $company->email = $request->email;
        $company->save();
    }

    public function updateCompanyData($request, $company)
    {
        // dd($request->all(), $company);

        $companyData = CompanyData::where('company_id', $company->id)->first();
        if ($companyData) {
            $companyData->update([
                'phone' => $request->phone,
                'email' => $request->email
            ]);
        } else{
            $this->addCompanyData($request, $company->id);
        }
    }
}
