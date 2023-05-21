<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'company_id', 
        'email',
        'phone',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public static function create_employee($first_name,$last_name,$company,$email,$phone) {
        return Employee::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'company_id'  => $company,
            'email'   => $email,
            'phone'  => $phone
        ]);
    }
}
