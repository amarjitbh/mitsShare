<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyTypeSectionFieldOption extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public function propertytypesectionfield(){
        return $this->belongsTo('App\PropertyTypeSectionField');
    }

    public function getDisplayValues( $ids ){
        return $this
            ->whereIn('id',$ids)
            ->pluck('display_value','id')
            ->toArray();
    }
}
