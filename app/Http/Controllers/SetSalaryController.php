<?php

namespace App\Http\Controllers;

use App\Models\AccountList;
use App\Models\Allowance;
use App\Models\AllowanceOption;
use App\Models\Commission;
use App\Models\DeductionOption;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\LoanOption;
use App\Models\OtherPayment;
use App\Models\Overtime;
use App\Models\PayslipType;
use App\Models\SaturationDeduction;
use App\Models\SalaryBreakup;
use App\Models\SalaryCalculations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SetSalaryController extends Controller
{
    public function index()
    {
        if (\Auth::user()->can('Manage Set Salary')) {
            $employees = Employee::where(
                [
                    'created_by' => \Auth::user()->creatorId(),
                ]
            )->get();

            return view('setsalary.index', compact('employees'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('Edit Set Salary')) {

            $payslip_type      = PayslipType::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $allowance_options = AllowanceOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $loan_options      = LoanOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $deduction_options = DeductionOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            $salary_breakup = SalaryBreakup::where('created_by', \Auth::user()->creatorId())->get();
            print_r($salary_breakup);
            if (\Auth::user()->type == 'employee') {
                $currentEmployee      = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $allowances           = Allowance::where('employee_id', $currentEmployee->id)->get();
                $commissions          = Commission::where('employee_id', $currentEmployee->id)->get();
                $loans                = Loan::where('employee_id', $currentEmployee->id)->get();
                $saturationdeductions = SaturationDeduction::where('employee_id', $currentEmployee->id)->get();
                $otherpayments        = OtherPayment::where('employee_id', $currentEmployee->id)->get();
                $overtimes            = Overtime::where('employee_id', $currentEmployee->id)->get();
                $employee             = Employee::where('user_id', '=', \Auth::user()->id)->first();

                return view('setsalary.employee_salary', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances', 'salary_breakup'));
            } else {
                $allowances           = Allowance::where('employee_id', $id)->get();
                $commissions          = Commission::where('employee_id', $id)->get();
                $loans                = Loan::where('employee_id', $id)->get();
                $saturationdeductions = SaturationDeduction::where('employee_id', $id)->get();
                $otherpayments        = OtherPayment::where('employee_id', $id)->get();
                $overtimes            = Overtime::where('employee_id', $id)->get();
                $employee             = Employee::find($id);

                return view('setsalary.edit', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances', 'salary_breakup'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
        
        $payslip_type      = PayslipType::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $allowance_options = AllowanceOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $loan_options      = LoanOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $deduction_options = DeductionOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $salary_breakup = SalaryBreakup::where('created_by', \Auth::user()->creatorId())->get();
        $employeesId      = \Auth::user()->employeeIdFormat($this->employeeNumber());
        
        if (\Auth::user()->type == 'employee') {
            $currentEmployee      = Employee::where('user_id', '=', \Auth::user()->id)->first();
            $allowances           = Allowance::where('employee_id', $currentEmployee->id)->get();
            $commissions          = Commission::where('employee_id', $currentEmployee->id)->get();
            $loans                = Loan::where('employee_id', $currentEmployee->id)->get();
            $saturationdeductions = SaturationDeduction::where('employee_id', $currentEmployee->id)->get();
            $otherpayments        = OtherPayment::where('employee_id', $currentEmployee->id)->get();
            $overtimes            = Overtime::where('employee_id', $currentEmployee->id)->get();
            $employee             = Employee::where('user_id', '=', \Auth::user()->id)->first();

            foreach ($allowances as  $value) {
                if ($value->type == 'percentage') {
                    $employee          = Employee::find($value->employee_id);
                    $empsal  = $value->amount * $employee->salary / 100;
                    $value->tota_allow = $empsal;
                }
            }

            foreach ($commissions as  $value) {
                if ($value->type == 'percentage') {
                    $employee          = Employee::find($value->employee_id);
                    $empsal  = $value->amount * $employee->salary / 100;
                    $value->tota_allow = $empsal;
                }
            }

            foreach ($loans as  $value) {
                if ($value->type == 'percentage') {
                    $employee          = Employee::find($value->employee_id);
                    $empsal  = $value->amount * $employee->salary / 100;
                    $value->tota_allow = $empsal;
                }
            }

            foreach ($saturationdeductions as  $value) {
                if ($value->type == 'percentage') {
                    $employee          = Employee::find($value->employee_id);
                    $empsal  = $value->amount * $employee->salary / 100;
                    $value->tota_allow = $empsal;
                }
            }

            foreach ($otherpayments as  $value) {
                if ($value->type == 'percentage') {
                    $employee          = Employee::find($value->employee_id);
                    $empsal  = $value->amount * $employee->salary / 100;
                    $value->tota_allow = $empsal;
                }
            }


            return view('setsalary.employee_salary', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances'));
        } else {
            $allowances           = Allowance::where('employee_id', $id)->get();
            $commissions          = Commission::where('employee_id', $id)->get();
            $loans                = Loan::where('employee_id', $id)->get();
            $saturationdeductions = SaturationDeduction::where('employee_id', $id)->get();
            $otherpayments        = OtherPayment::where('employee_id', $id)->get();
            $overtimes            = Overtime::where('employee_id', $id)->get();
            $employee             = Employee::find($id);

            foreach ($allowances as  $value) {
                if ($value->type == 'percentage') {
                    $employee          = Employee::find($value->employee_id);
                    $empsal  = $value->amount * $employee->salary / 100;
                    $value->tota_allow = $empsal;
                }
            }

            foreach ($commissions as  $value) {
                if ($value->type == 'percentage') {
                    $employee          = Employee::find($value->employee_id);
                    $empsal  = $value->amount * $employee->salary / 100;
                    $value->tota_allow = $empsal;
                }
            }

            foreach ($loans as  $value) {
                if ($value->type == 'percentage') {
                    $employee          = Employee::find($value->employee_id);
                    $empsal  = $value->amount * $employee->salary / 100;
                    $value->tota_allow = $empsal;
                }
            }

            foreach ($saturationdeductions as  $value) {
                if ($value->type == 'percentage') {
                    $employee          = Employee::find($value->employee_id);
                    $empsal  = $value->amount * $employee->salary / 100;
                    $value->tota_allow = $empsal;
                }
            }

            foreach ($otherpayments as  $value) {
                if ($value->type == 'percentage') {
                    $employee          = Employee::find($value->employee_id);
                    $empsal  = $value->amount * $employee->salary / 100;
                    $value->tota_allow = $empsal;
                }
            }

            return view('setsalary.employee_salary', compact('employee', 'payslip_type', 'allowance_options', 'commissions', 'loan_options', 'overtimes', 'otherpayments', 'saturationdeductions', 'loans', 'deduction_options', 'allowances', 'salary_breakup', 'employeesId'));
        }
    }


    public function employeeUpdateSalary(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'salary_type' => 'required',
                'salary' => 'required',
                'account_type' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $employee = Employee::findOrFail($id);
        $input    = $request->all();
        $employee->fill($input)->save();

        return redirect()->back()->with('success', 'Employee Salary Updated.');
    }

    public function employeeSalary()
    {
        if (\Auth::user()->type == "employee") {
            $employees = Employee::where('user_id', \Auth::user()->id)->get();
            return view('setsalary.index', compact('employees'));
        }
    }

    public function employeeBasicSalary($id)
    {
        $payslip_type = PayslipType::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $payslip_type->prepend('Select Payslip Type', '');
        $accounts = AccountList::where('created_by', \Auth::user()->creatorId())->get()->pluck('account_name', 'id');
        $accounts->prepend('Select Account Type', '');

        $employee     = Employee::find($id);

        return view('setsalary.basic_salary', compact('employee', 'payslip_type', 'accounts'));
    }

    public function salaryBreakupPage()
    {
        if (\Auth::user()->type == "company") {
            $breackups = SalaryBreakup::where(
                [
                    'created_by' => \Auth::user()->creatorId(),
                ]
            )->get();

            return view('setsalary.breakup', compact('breackups'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function createSalaryBreakup()
    {
        if (\Auth::user()->type == "company") {            
            return view('setsalary.create-breakup');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function storeSalaryBreakup(Request $request)
    {
        if (\Auth::user()->type == "company") {

            $validator = \Validator::make(
                $request->all(),
                [
                    'component_name' => 'required',
                    'component_value_type' => 'required',
                    'component_type' => 'required'
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $salaryb = SalaryBreakup::where('component_value_type', $request->component_value_type)->get();
            // print_r($salaryb);
            // exit;
            if(count($salaryb) > 0 && $request->component_value_type == "Base Salary"){
                return redirect()->back()->with('error', __('You have already added base salary field. You can add Base Salary Field only one time.'));
            }else{
                $salery_breakup = new SalaryBreakup();
                $salery_breakup->component_name = $request->component_name;
                $salery_breakup->component_value_type = $request->component_value_type;
                $salery_breakup->created_by = \Auth::user()->creatorId();
                $salery_breakup->component_type = $request->component_type;
                $salery_breakup->save();

                return redirect()->route('salarybreakup')->with('success', __('Salary Breakup successfully created.'));
            }
            
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function editSalaryBreakup($id)
    {
        if (\Auth::user()->type == "company") {
            $salarybreakup = SalaryBreakup::find($id);
            if ($salarybreakup->created_by == \Auth::user()->creatorId()) {
                return view('setsalary.edit-breakup', compact('salarybreakup'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function updateSalaryBreakup(Request $request)
    {
        if (\Auth::user()->type == "company") {
            $salery_breakup = SalaryBreakup::find($request->id);
            if ($salery_breakup->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'component_name' => 'required',
                        'component_value_type' => 'required',
                        'component_type' => 'required'
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $salaryb = SalaryBreakup::where('component_value_type', $request->component_value_type)->get();                
                if(count($salaryb) > 0 && $request->component_value_type == "Base Salary"){
                    return redirect()->back()->with('error', __('You have already added base salary field. You can add Base Salary Field only one time.'));
                }else{
                    $salery_breakup->component_name = $request->component_name;
                    $salery_breakup->component_value_type = $request->component_value_type;
                    $salery_breakup->component_type = $request->component_type;
                    $salery_breakup->save();

                    return redirect()->route('salarybreakup')->with('success', __('Salary breakup successfully updated.'));
                }
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroySalaryBreakup($id)
    {
        if (\Auth::user()->type == "company") {
            $salarybreakup = SalaryBreakup::find($id);
            if ($salarybreakup->created_by == \Auth::user()->creatorId()) {
                $salarybreakup->delete();
                return redirect()->route('salarybreakup')->with('success', __('Salary breakup successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    function employeeNumber()
    {
        $latest = Employee::where('created_by', '=', \Auth::user()->creatorId())->latest('id')->first();
        if (!$latest) {
            return 1;
        }

        return $latest->id + 1;
    }

    public function storeSalaryComputation(Request $request)
    {
        if (\Auth::user()->type == "company" || \Auth::user()->type == "hr") {

            $validator = \Validator::make(
                $request->all(),
                [
                    'employee_id' => 'required'
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            //$salaryb = SalaryBreakup::where('component_value_type', $request->component_value_type)->get();
            // print_r($request->all());
            // exit;
            // if(count($salaryb) > 0 && $request->component_value_type == "Base Salary"){
            //     return redirect()->back()->with('error', __('You have already added base salary field. You can add Base Salary Field only one time.'));
            // }else{
            //     $salery_breakup = new SalaryBreakup();
            //     $salery_breakup->component_name = $request->component_name;
            //     $salery_breakup->component_value_type = $request->component_value_type;
            //     $salery_breakup->created_by = \Auth::user()->creatorId();
            //     $salery_breakup->component_type = $request->component_type;
            //     $salery_breakup->save();

                //return redirect()->back()->with('success', __('Salary Breakup successfully created.'));
           // }
            
        } else {
            //return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
