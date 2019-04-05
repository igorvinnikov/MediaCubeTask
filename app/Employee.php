<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['first_name', 'last_name', 'patronymic', 'gender', 'salary'];

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function getFullNameAttribute()
    {
        $parts = array_merge([$this->first_name], [$this->last_name]);

        if($this->patronymic != null && strlen($this->patronymic) > 0){
            $parts[] = $this->patronymic;
        }
        return implode(" ", $parts);
    }

    public function getDepartmentsName()
    {
        $departmentNames = [];

        foreach ($this->departments as $department) {
            $departmentNames[$department->id]['name'] = $department->name;
        }

        return $departmentNames;
    }
}
