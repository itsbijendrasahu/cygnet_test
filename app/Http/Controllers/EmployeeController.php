<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salaries = Salary::get();
        return view('employee.index', compact('salaries'));
    }

    public function getEmployees(Request $request, Employee $employee)
    {
        $data = $employee->getData();
        return \DataTables::of($data)
            ->addColumn('Actions', function ($data) {
                return '<button type="button" class="btn btn-success btn-sm" id="getEditEmployeeData" data-id="' . $data->id . '">Edit</button>
                    <button type="button" data-id="' . $data->id . '" data-toggle="modal" data-target="#DeleteEmployeeModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
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
    public function store(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(), [
            'salary_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        try {
            $employee->salary_id = $request->salary_id;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->password = Hash::make($request->password);
            $file = $request->file('image');
            if (isset($file)) {
                $destinationPath = 'images';
                $fname = rand(1000, 9999) . "_" . $request->image->getClientOriginalName();
                $request->image->move($destinationPath, $fname);
                $employee->image = "$destinationPath/$fname";
            }
            $employee->save();

            return response()->json(['success' => 'Employee added successfully']);
        } catch (\Exception $e) {
            return response()->json(['errors' => [$e->getMessage()]]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = new Employee;
        $data = $employee->findData($id);
        $salaries = Salary::get();

        $htmlsals = '';
        foreach ($salaries as $salary) {
            $pselected = $data->salary_id == $salary->id ? 'selected' : '';
            $htmlsals .= '<option ' . $pselected . '  value="' . $salary->id . '">' . $salary->salary . '</option>';
        }

        $html = '<div class="form-group">
                    <label for="salary_id">Salary:</label>
                    <select name="salary_id" id="editsalary_id" class="form-control salary_id">
                        <option value="">Select Salary</option>
                         ' . $htmlsals . '
                    </select>
                </div>
                <div class="form-group">
                    <label for="employee_name">Employee Name:</label>
                    <input type="text" class="form-control" name="name" id="editemployee_name" value="' . $data->name . '">
                </div>
                <div class="form-group">
                    <label for="Email">Email:</label>
                    <input type="text" class="form-control" name="email" id="editemail" value="' . $data->email . '">
                </div>
                <div class="form-group">
                    <label for="Password">Password:</label>
                    <input type="password" class="form-control" name="password" id="editpassword" >
                </div>

                ';

        return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'salary_id' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', Rule::unique('employees')->ignore($id)]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        try {
            $employee = Employee::find($id);
            $employee->salary_id = $request->salary_id;
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->password = $request->password != '' ? Hash::make($request->password) : $employee->password;
            $employee->save();

            return response()->json(['success' => 'Employee updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['errors' => [$e->getMessage()]]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = new Employee();
        $product->deleteData($id);

        return response()->json(['success' => 'Employee deleted successfully']);
    }
}
