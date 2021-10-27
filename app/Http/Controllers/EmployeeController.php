<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Salary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Salary::get();
        return view('employees.index', compact('employees'));
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
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'name_name' => 'required|string',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $employee->storeData($request->all());

        return response()->json(['success' => 'Employee added successfully']);
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
                    <input type="text" class="form-control" name="email" id="editemail" value="' . $data->email . '" onkeypress="return isNumberKey(this, event);">
                </div>
                <div class="form-group">
                    <label for="Password">Password:</label>
                    <input type="password" class="form-control" name="password" id="editpassword" >
                </div>

                <div class="form-group">
                    <label for="Image">Image:</label>
                    <input type="file" class="form-control" name="image" id="editimage" >
                </div>';

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
            'name' => 'required|string',
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $product = new Product;
        $product->updateData($id, $request->all());

        return response()->json(['success' => 'Product updated successfully']);
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
