<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
class ProertiesPolicyUpdation extends Model
{
   protected $table = 'properties_policy_updation';

    protected $fillable = [
        'id', 'property_id', 'policy_id' 
    ];
}
