<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogsActivity;
use Spatie\Activitylog\LogsActivityInterface;

class Bill extends Model implements LogsActivityInterface
{
    use LogsActivity;
    use SoftDeletes;

    protected $softDelete = true;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'Bill "' . $this->name . '" was created';
        }

        if ($eventName == 'updated')
        {
            return 'Bill "' . $this->name . '" was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'Bill "' . $this->name . '" was deleted';
        }
        return '';
    }
    protected $hidden=['getStaff','getDeletedUser'];
    protected $fillable = ['staff_id','status','content','total','total_money','price_final','discount','customer_name','table_number','note','user_deleted'];
    public function getStaff(){
        return $this->hasOne(User::class,'id','staff_id')->where('status',1);
    }
    public function getDeletedUser(){
        return $this->hasOne(Admin::class,'id','user_deleted');
    }
    public function getType(){
        return $this->hasOne(ProductType::class,'id','type_id');
    }
}
