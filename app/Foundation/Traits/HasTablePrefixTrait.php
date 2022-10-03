<?php


namespace App\Foundation\Traits;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

trait HasTablePrefixTrait
{
    protected string $prefix;

    public function getPrefix()
    {
        $module_name = $this->getModuleName();
        $default_prefix = '';
        if ($module_name){
            $default_prefix = config(strtolower($module_name).'.database.prefix');
        }
        return $this->prefix ?? $default_prefix;
    }

    public function getModuleName()
    {
        $current_path = explode("\\", get_class());
        return @$current_path[array_search( 'Modules',$current_path) + 1];
    }


    public function getTable()
    {
        return $this->table ?? $this->getPrefix() . Str::snake(Str::pluralStudly(class_basename($this)));
    }

    public static function getTableName()
    {
        return with(new static())->getTable();
    }
}
