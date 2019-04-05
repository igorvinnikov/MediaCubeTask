<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    public function getEmployeesCount()
    {
        return $this->employees()->count();
    }

    public function getMaxSalary()
    {
        return $this->employees()->get(['salary'])->max();
    }
}
