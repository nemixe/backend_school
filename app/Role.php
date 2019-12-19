<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Employee;

class Role extends Model
{
    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}

?>
