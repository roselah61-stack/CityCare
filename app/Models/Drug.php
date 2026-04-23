<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    //
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'quantity',
        'description',
        'expiry_date',
        'low_stock_threshold'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inventoryLogs()
    {
        return $this->hasMany(DrugInventoryLog::class);
    }

    public function prescriptionItems()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

public function treatments()
{
    return $this->hasMany(Treatment::class);
}
}
