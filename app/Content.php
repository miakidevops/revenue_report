<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table="content";

    protected $fillable=[
        'time',
        'service_id',
        'shortcode',
        'keyword',
        'product_id',
        'service_name',
        'service_type',
        'type',
        'company_name',
        'share',
        'total_revenue',
        'vat',
        'miaki_revenue',
        'order_number',
        'order_revenue',
        'reorder_number',
        'reorder_revenue',
        'on_demanded_number',
        'on_demanded_revenue',
        'third_party_revenue',
    ];
}
