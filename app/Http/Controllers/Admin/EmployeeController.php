<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Requests\MassDestroyEmployeeRequest;
use App\Models\Company;

class EmployeeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('isAdmin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::with(['company'])->get();

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        abort_if(Gate::denies('isAdmin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company = Company::pluck('company_name', 'id')->prepend('Please Select Company', '');

        return view('admin.employees.create', compact('company'));
    }

    public function store(StoreEmployeeRequest $request)
    {

        Employee::create($request->all());

        return redirect()->route('admin.employees.index');
    }

    public function edit(Employee $employee)
    {
        abort_if(Gate::denies('isAdmin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $company = Company::pluck('company_name', 'id')->prepend('Please Select Company', '');

        $employee->load('company');

        return view('admin.employees.edit', compact('company', 'employee'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->all());

        return redirect()->route('admin.employees.index');
    }

    public function show(Employee $employee)
    {
        abort_if(Gate::denies('isAdmin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employees.show', compact('company'));
    }

    public function destroy(Employee $employee)
    {
        abort_if(Gate::denies('isAdmin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmployeeRequest $request)
    {
        Employee::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
