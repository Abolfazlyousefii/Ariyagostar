<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public $ordering = 1;
    public $ids = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('general.permissions');

        foreach ($permissions as $name => $value) {
            $this->create($name, $value);
        }

        Permission::whereNotIn('id', $this->ids)->delete();
    }

    private function create($name, $value, $permission_id = null)
    {
        if (is_array($value)) {

            $permission = Permission::updateOrCreate(
                [
                    'name' => $name
                ],
                [
                    'title'         => $value['title'],
                    'ordering'      => $this->ordering++,
                    'permission_id' => $permission_id
                ]
            );

            $this->ids[] = $permission->id;

            foreach ($value['values'] as $n => $val) {
                $this->create($name . '.' . $n, $val, $permission->id);
            }
        } else {
            $permission = Permission::updateOrCreate(
                [
                    'name' => $name
                ],
                [
                    'title'         => $value,
                    'ordering'      => $this->ordering++,
                    'permission_id' => $permission_id
                ]
            );

            $this->ids[] = $permission->id;
        }
    }
}
