<?php

namespace Database\Seeders;

use App\Helpers\Registry;
use App\Models\Master\Category;
use App\Models\Master\Coach;
use App\Models\Master\CoachManagement;
use App\Models\Master\Management;
use App\Models\Master\Student;
use App\Models\System\Permission;
use App\Models\System\Role;
use App\Models\System\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            'name' => 'Lari',
            'code' => "C0001",
        ];
        $category = Category::query()->updateOrCreate($category, $category);
        Role::query()->truncate();
        Permission::query()->truncate();
        User::query()->truncate();
        Management::query()->truncate();
        Student::query()->truncate();
        Coach::query()->truncate();
        CoachManagement::query()->truncate();

        $superAdmin = Role::create(['name' => Registry::ROLE_SUPER_ADMIN]);
        $management = Role::create(['name' => Registry::ROLE_MANAGEMENT]);
        $coach = Role::create(['name' => Registry::ROLE_COACH]);
        $student = Role::create(['name' => Registry::ROLE_STUDENT]);

        $userAdmin = User::factory(1)->create([
            'phone_number' => 'admin'
        ]);
        $userAdmin[0]->assignRole($superAdmin);

        $userManagement = User::factory(1)->create([
            'phone_number' => 'management'
        ]);
        $userManagement[0]->assignRole($management);
        $myManagement = Management::factory(1)->create([
           'user_id' => $userManagement[0]->id,
           'category_id' => $category->id
        ]);

        $userCoach = User::factory(1)->create([
            'phone_number' => 'coach'
        ]);
        $userCoach[0]->assignRole($coach);
        $myCoach = Coach::factory(1)->create([
            'user_id' => $userCoach[0]->id,
        ]);

        $myManagement[0]->assignCoach($myCoach[0]);

        $userStudent = User::factory(1)->create([
            'phone_number' => 'student'
        ]);
        $userStudent[0]->assignRole($student);
        Student::factory(1)->create([
            'user_id' => $userStudent[0]->id,
        ]);
    }
}
