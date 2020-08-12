<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions

        // attendees
        Permission::create(['name' => 'list attendee']);
        Permission::create(['name' => 'edit attendee']);
        Permission::create(['name' => 'delete attendee']);
        Permission::create(['name' => 'add attendee']);
        // book
        Permission::create(['name' => 'list booking']);
        Permission::create(['name' => 'edit booking']);
        Permission::create(['name' => 'delete booking']);
        Permission::create(['name' => 'add booking']);
        Permission::create(['name' => 'export booking']);
        Permission::create(['name' => 'print booking']);
        // department
        Permission::create(['name' => 'list department']);
        Permission::create(['name' => 'edit department']);
        Permission::create(['name' => 'delete department']);
        Permission::create(['name' => 'add department']);
        // event
        Permission::create(['name' => 'list event']);
        Permission::create(['name' => 'edit event']);
        Permission::create(['name' => 'delete event']);
        Permission::create(['name' => 'add event']);
        Permission::create(['name' => 'view event']);
        Permission::create(['name' => 'publish event']);
        // event review
        Permission::create(['name' => 'list event review']);
        Permission::create(['name' => 'edit event review']);
        Permission::create(['name' => 'delete event review']);
        Permission::create(['name' => 'add event review']);
        Permission::create(['name' => 'submit event review']);
        // permission
        Permission::create(['name' => 'list permission']);
        Permission::create(['name' => 'edit permission']);
        Permission::create(['name' => 'delete permission']);
        Permission::create(['name' => 'add permission']);
        // poster
        Permission::create(['name' => 'list poster']);
        Permission::create(['name' => 'edit poster']);
        Permission::create(['name' => 'delete poster']);
        Permission::create(['name' => 'add poster']);
        Permission::create(['name' => 'view poster']);
        // role
        Permission::create(['name' => 'list role']);
        Permission::create(['name' => 'edit role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'add role']);
        // settings
        Permission::create(['name' => 'list settings']);
        Permission::create(['name' => 'edit settings']);
        Permission::create(['name' => 'delete settings']);
        Permission::create(['name' => 'add settings']);
        // speaker
        Permission::create(['name' => 'list speaker']);
        Permission::create(['name' => 'edit speaker']);
        Permission::create(['name' => 'delete speaker']);
        Permission::create(['name' => 'add speaker']);
        // subscriber
        Permission::create(['name' => 'list subscriber']);
        Permission::create(['name' => 'edit subscriber']);
        Permission::create(['name' => 'delete subscriber']);
        Permission::create(['name' => 'add subscriber']);
        // template
        Permission::create(['name' => 'list template']);
        Permission::create(['name' => 'edit template']);
        Permission::create(['name' => 'delete template']);
        Permission::create(['name' => 'add template']);
        // ticket
        Permission::create(['name' => 'list ticket']);
        Permission::create(['name' => 'edit ticket']);
        Permission::create(['name' => 'delete ticket']);
        Permission::create(['name' => 'add ticket']);
        // user
        Permission::create(['name' => 'list user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'add user']);
        // venue
        Permission::create(['name' => 'list venue']);
        Permission::create(['name' => 'edit venue']);
        Permission::create(['name' => 'delete venue']);
        Permission::create(['name' => 'add venue']);
        // misc
        Permission::create(['name' => 'edit profile']);

        // create roles and assign created permissions

        // this can be done as separate statements

        // subscriber, basic user, no permission except to edit own profile
        $role = Role::create(['name' => 'Subscriber'])
            ->givePermissionTo(['edit profile']);
        // reviewer
        $role = Role::create(['name' => 'Reviewer'])
            ->givePermissionTo(['list event review','edit event review','view event', 'view poster', 'edit profile']);
        // contributor
        $role = Role::create(['name' => 'Contributor'])
            ->givePermissionTo([
                'list poster','edit poster','list event','edit event',
                'list speaker','edit speaker','list venue','edit venue',
                'list booking','list attendee','delete booking','export booking',
                'print booking','list attendee','delete booking','export booking',
                'list subscriber','delete subscriber', 'export booking', 'edit profile'
        ]);
        // author
        $role = Role::create(['name' => 'Author'])
            ->givePermissionTo([
                'list poster','edit poster', 'delete poster', 'add poster',
                'list event','edit event', 'add event', 'delete event', 'publish event', 'submit event review', 
                'list ticket','edit ticket', 'add ticket', 'delete ticket',
                'list speaker','edit speaker', 'add speaker', 'delete speaker',
                'list venue','edit venue', 'add venue', 'delete venue',
                'list booking','list attendee','edit booking','delete booking','export booking',
                'print booking','list attendee','edit attendee', 'delete booking','export booking',
                'list subscriber','delete subscriber', 'export booking', 'edit profile'
            ]);
        // administrator
        $role = Role::create(['name' => 'Administrator'])
            ->givePermissionTo([
                'list poster','edit poster', 'delete poster', 'add poster',
                'list event','edit event', 'add event', 'delete event', 'publish event', 'submit event review', 
                'list ticket','edit ticket', 'add ticket', 'delete ticket',
                'list speaker','edit speaker', 'add speaker', 'delete speaker',
                'list venue','edit venue', 'add venue', 'delete venue',
                'list booking','list attendee','edit booking','delete booking','export booking',
                'print booking','list attendee','edit attendee', 'delete booking','export booking',
                'list subscriber','delete subscriber', 'export booking', 'edit profile',
                'add user', 'edit user', 'list user', 'delete user',
                'list template', 'add template', 'edit template', 'delete template'
            ]);
        // super-administrator
        /*$role = Role::create(['name' => 'super-administrator'])
            ->givePermissionTo(Permission::all());*/
        // all permissions are allowed, the check is done via AuthServiceProvider using Gate::before
        $role = Role::create(['name' => 'Super Administrator']);
    }
}
