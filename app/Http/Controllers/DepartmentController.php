<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function createDepartment(Request $request)
    {
        $depName = $request->only('name');

        $validator = Validator::make($depName, [
            'name' => 'string|required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $department = new Department;
        $department->name = $depName['name'];
        $department->save();

        return response()->json(['success' => true], 200);
    }

    public function getAllDepartments()
    {
        $departments = Department::all();
        $departmentArr = [];

        foreach ($departments as $department) {
            $data = new \stdClass();
            $data->id = $department->id;
            $data->name = $department->name;
            $data->employeesCount = $department->getEmployeesCount();
            $data->maxSalary = $department->getMaxSalary();
            $departmentArr[] = $data;
        }

        return response()->json($departmentArr);
    }

    public function updateDepartment(int $id, Request $request)
    {
        $department = Department::find($id);

        if(!$department){
            return response()->json(['errors' => 'This department does not exist'], 422);
        }

        $payload = $request->only('name');

        $validator = Validator::make($payload, [
            'name' => 'string|required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $department->name = $payload['name'];
        $department->save();

        return response()->json($department);
    }
}
