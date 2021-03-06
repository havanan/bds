<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivity;
use Spatie\Activitylog\LogsActivityInterface;

class ProductCategory extends Model implements LogsActivityInterface
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected $fillable = ['name','status'];

    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'Product Category "' . $this->name . '" was created';
        }

        if ($eventName == 'updated')
        {
            return 'Product Category "' . $this->name . '" was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'Product Category "' . $this->name . '" was deleted';
        }
        return '';
    }
    protected $hidden=['getAllType'];
    public function getAllType(){
        return $this->hasMany(ProductType::class,'category_id','id')->where('status',1)->orderBy('id','desc');
    }
}
