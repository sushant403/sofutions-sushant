<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'companies';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'company_name',
        'company_email',
        'company_logo',
        'company_website',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function companydata()
    {
        return $this->hasMany(CompanyData::class);
    }
}
