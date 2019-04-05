<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function createEmployee(Request $request)
    {
        $payload = $request->all();

        $validator = Validator::make($payload, [
            'first_name' => 'string|min:2|required',
            'last_name' => 'string|required',
            'department_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $employee = new Employee;

        $employee->first_name = $payload['first_name'];
        $employee->last_name = $payload['last_name'];
        $employee->patronymic = $payload['patronymic'];
        $employee->gender = $payload['gender'];
        $employee->salary = $payload['salary'];

        $employee->save();

        $department = Department::find($payload['department_id']);
        $employee->departments()->attach($department);

        return response()->json(['success' => true], 200);
    }

    public function getAllEmployees()
    {
        $employees = Employee::all();
        $employeesArr = [];
        foreach ($employees as $employee) {
            $data['id'] = $employee->id;
            $data['firstName'] = $employee->first_name;
            $data['lastName'] = $employee->last_name;
            $data['fullName'] = $employee->getFullNameAttribute();
            $data['patronymic'] = $employee->patronymic;
            $data['gender'] = $employee->gender;
            $data['salary'] = $employee->salary;
            $data['departments'] = $employee->getDepartmentsName();
            $data['depNames'] = implode(', ', Arr::flatten($data['departments']));
            $employeesArr[] = $data;
        }

        return response()->json($employeesArr);
    }

    public function updateEmployee(int $id, Request $request)
    {
        $payload = $request->all();

        $employee = Employee::find($id);

        if(!$employee){
            return response()->json(['errors' => 'This employee does not exist'], 422);
        }

        $validator = Validator::make($payload, [
            'first_name' => 'string|min:2|required',
            'last_name' => 'string|required',
            'patronymic' => 'string|nullable',
            'gender' => 'string|nullable',
            'salary' => 'integer|nullable',
            'department_id' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $employee->update($payload);

        $department = Department::find($payload['department_id']);
        $employee->departments()->sync($department);

        return response()->json($employee);
    }
}
