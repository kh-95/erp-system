<?php


namespace App\Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionDatabaseSeeder extends Seeder
{
    private function defaultPermissions()
    {
        return [
            'list' => 'السجل',
            'create' => 'إضافة',
            'edit' => 'تعديل',
            'delete' => 'حذف',
            'show' => 'عرض'
        ];
    }

    private function addAndExceptPermissions($module)
    {
        $defaultPermissions = $this->defaultPermissions();

        if (array_key_exists('extraPermissions', $module) && !empty($module['extraPermissions'])) {

            foreach ($module['extraPermissions'] as $key => $permission) {

                $defaultPermissions[$key] = $permission;

            }

        }

        if (array_key_exists('exceptPermissions', $module) && !empty($module['exceptPermissions'])) {

            foreach ($module['exceptPermissions'] as $permission) {

                unset($defaultPermissions[$permission]);

            }

        }

        return $defaultPermissions;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        foreach (config('permissions') as $key => $item) {
            $permissions = $this->addAndExceptPermissions($item);
            $this->savePermissions($key, $permissions, $item);

        }
    }

    private function savePermissions($model, $permissions, $item)
    {
        foreach ($permissions as $name => $slug) {
            Permission::updateOrCreate([
                'name' => $name . '-' . $model,
                'slug' => $slug . ' ' . $item['slug'],
                'module' => $item['module'],
            ], [
                'name' => $name . '-' . $model,
                'slug' => $slug . ' ' . $item['slug'],
                'module' => $item['module'],
            ]);
        }

        $this->setSuperAdminRole();
    }

    private function setSuperAdminRole()
    {
        $role = Role::firstOrCreate([
            'name' => 'Super Admin',
            'slug' => 'Super Admin',
        ]);

        $permissions = Permission::all()->pluck('id')->toArray();
        $role->syncPermissions($permissions);

    }

}

