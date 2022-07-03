<?php

namespace Database\Seeders;

use App\Models\Activities;
use App\Models\Analysis;
use App\Models\Classes;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\CourseTeacher;
use App\Models\Detection;
use App\Models\Dose;
use App\Models\PatientFrinds;
use App\Models\Permission;
use App\Models\PsychologicalAid;
use App\Models\Role;
use App\Models\Subjects;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $adminuser = User::query()->create([
            'name' => 'root',
            'password' => '123456789',
            'email' => 'root@gmail.com',
            'remember_token' => Str::random(10),
        ]);

        $patients = User::factory(10)
            ->hasDose(10)
            ->hasAnalysis(10)
            ->hasDetection(10)
            ->hasPsychologicalAid(10)
            ->create();
        $doctors = User::factory(10)->create();

        Activities::factory(10)->create();
        PatientFrinds::factory(10)->create();

        $admin = Role::create(['name' => 'admin']);
        $adminuser->attachRole($admin);
        $patient = Role::create(['name' => 'المرضى']);
        $patients->map(fn ($v) => $v->roles()->sync($patient));
        $doctor = Role::create(['name' => 'الاطباء']);
        $doctors->map(fn ($v) => $v->roles()->sync($doctor));

        $read = Permission::create(['name' => 'read']);
        $write = Permission::create(['name' => 'write']);
        $edit = Permission::create(['name' => 'edit']);

        $admin->attachPermissions([$read, $write, $edit]);
        $patient->attachPermission($read);
        $doctor->attachPermissions([$read, $write]);

        // Role
        // $owner = Role::create([
        //     'name' => 'owner',
        //     'display_name' => 'Project Owner', // optional
        //     'description' => 'User is the owner of a given project', // optional
        // ]);

        // $createPost = Permission::create([
        //     'name' => 'create-post',
        //     'display_name' => 'Create Posts', // optional
        //     'description' => 'create new blog posts', // optional
        // ]);

        // $admin->attachPermission($createPost); // parameter can be a Permission object, array or id
        // // equivalent to $admin->permissions()->attach([$createPost->id]);

        // $owner->attachPermissions([$createPost, $editUser]); // parameter can be a Permission object, array or id
        // // equivalent to $owner->permissions()->attach([$createPost->id, $editUser->id]);

        // $owner->syncPermissions([$createPost, $editUser]); // parameter can be a Permission object, array or id
        // // equivalent to $owner->permissions()->sync([$createPost->id, $editUser->id]);

        //         $user->attachRole($admin); // parameter can be a Role object, array, id or the role string name
        // // equivalent to $user->roles()->attach([$admin->id]);

        // $user->attachRoles([$admin, $owner]); // parameter can be a Role object, array, id or the role string name
        // // equivalent to $user->roles()->attach([$admin->id, $owner->id]);

        // $user->syncRoles([$admin->id, $owner->id]);
        // // equivalent to $user->roles()->sync([$admin->id, $owner->id]);

        // $user->syncRolesWithoutDetaching([$admin->id, $owner->id]);
        // // equivalent to $user->roles()->syncWithoutDetaching([$admin->id, $owner->id]);
    }
}
