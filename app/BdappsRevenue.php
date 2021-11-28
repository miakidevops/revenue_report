<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BdappsRevenue extends Model
{
    protected $table="bdapps_revenue";

    protected $fillable=[
       'rev_date',
       'miaki_rev',
       'mmlbd_rev',
       'other_rev',
   ];
}
