<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'building_id',
        'unit_id',
        'amount',
        'expense_date',
        'description',
		'invoice_image',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
	public function images()
    {
    return $this->hasMany(ExpenseImage::class);
    }

}
