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
];
    public function up()
{
    Schema::create('drugs', function (Blueprint $table) {
        
        $table->id();
        $table->string('name');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->decimal('price', 8, 2);
        $table->timestamps();
    });
}
public function category()
{
    return $this->belongsTo(Category::class);
}

public function treatments()
{
    return $this->hasMany(Treatment::class);
}
}
