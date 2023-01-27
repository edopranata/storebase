<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'status'        => 'date:Y-m-d',
        'created_at'    => 'date:Y-m-d',
        'updated_at'    => 'date:Y-m-d'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function details()
    {
        return $this->hasMany(AdjustmentProductDetail::class);
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class, 'product_id', 'product_id');
    }

    public function adjustment()
    {
        return $this->belongsTo(Adjustment::class);
    }
}
