<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'website',
        'logo'
    ];
    
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public static function create_company($company_name,$company_email,$comapny_website,$company_logo)
    {
        return Company::create([
            'name' => $company_name,
            'email'=> $company_email,
            'website'=> env('WEBSITE_URL').$comapny_website,
            'logo' => $company_logo
        ]);
    }
}
