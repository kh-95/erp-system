<?php
namespace App\Modules\Reception\Traits;

trait Prefix {


   static public function getTableName($model) : string {
    $prefix = config('reception.name');
    return strtolower($prefix).'_'.$model->getTable();
   }

}
