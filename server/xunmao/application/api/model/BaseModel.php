<?php
namespace app\api\model;

use think\Model;

class BaseModel extends Model {
    public $hidden = ['delete_time' , "update_time"];

  
}