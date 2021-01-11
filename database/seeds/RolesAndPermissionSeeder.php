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

        Permission::create(['name' => 'list attendee', 'guard_name' => 'api']);
        Permission::create(['name' => 'edit attendee', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete attendee', 'guard_name' => 'api']);
        Permission::create(['name' => 'add attendee','guard_name' => 'api']);
        // book
        Permission::create(['name' => 'list booking']);
        Permission::create(['name' => 'edit booking']);
        Permission::create(['name' => 'delete booking']);
        Permission::create(['name' => 'add booking']);
        Permission::create(['name' => 'export booking']);
        Permission::create(['name' => 'print booking']);

        Permission::create(['name' => 'list booking','guard_name' => 'api']);
        Permission::create(['name' => 'edit booking','guard_name' => 'api']);
        Permission::create(['name' => 'delete booking','guard_name' => 'api']);
        Permission::create(['name' => 'add booking','guard_name' => 'api']);
        Permission::create(['name' => 'export booking','guard_name' => 'api']);
        Permission::create(['name' => 'print booking','guard_name' => 'api']);
        // department
        Permission::create(['name' => 'list department']);
        Permission::create(['name' => 'edit department']);
        Permission::create(['name' => 'delete department']);
        Permission::create(['name' => 'add department']);

        Permission::create(['name' => 'list department','guard_name' => 'api']);
        Permission::create(['name' => 'edit department','guard_name' => 'api']);
        Permission::create(['name' => 'delete department','guard_name' => 'api']);
        Permission::create(['name' => 'add department','guard_name' => 'api']);
        // event
        Permission::create(['name' => 'list event']);
        Permission::create(['name' => 'edit event']);
        Permission::create(['name' => 'delete event']);
        Permission::create(['name' => 'add event']);
        Permission::create(['name' => 'view event']);
        Permission::create(['name' => 'publish event']);

        Permission::create(['name' => 'list event','guard_name' => 'api']);
        Permission::create(['name' => 'edit event','guard_name' => 'api']);
        Permission::create(['name' => 'delete event','guard_name' => 'api']);
        Permission::create(['name' => 'add event','guard_name' => 'api']);
        Permission::create(['name' => 'view event','guard_name' => 'api']);
        Permission::create(['name' => 'publish event','guard_name' => 'api']);
        // event review
        Permission::create(['name' => 'list event review']);
        Permission::create(['name' => 'edit event review']);
        Permission::create(['name' => 'delete event review']);
        Permission::create(['name' => 'add event review']);
        Permission::create(['name' => 'submit event review']);

        Permission::create(['name' => 'list event review','guard_name' => 'api']);
        Permission::create(['name' => 'edit event review','guard_name' => 'api']);
        Permission::create(['name' => 'delete event review','guard_name' => 'api']);
        Permission::create(['name' => 'add event review','guard_name' => 'api']);
        Permission::create(['name' => 'submit event review','guard_name' => 'api']);
        // permission
        Permission::create(['name' => 'list permission']);
        Permission::create(['name' => 'edit permission']);
        Permission::create(['name' => 'delete permission']);
        Permission::create(['name' => 'add permission']);

        Permission::create(['name' => 'list permission','guard_name' => 'api']);
        Permission::create(['name' => 'edit permission','guard_name' => 'api']);
        Permission::create(['name' => 'delete permission','guard_name' => 'api']);
        Permission::create(['name' => 'add permission','guard_name' => 'api']);
        // poster
        Permission::create(['name' => 'list poster']);
        Permission::create(['name' => 'edit poster']);
        Permission::create(['name' => 'delete poster']);
        Permission::create(['name' => 'add poster']);
        Permission::create(['name' => 'view poster']);

        Permission::create(['name' => 'list poster','guard_name' => 'api']);
        Permission::create(['name' => 'edit poster','guard_name' => 'api']);
        Permission::create(['name' => 'delete poster','guard_name' => 'api']);
        Permission::create(['name' => 'add poster','guard_name' => 'api']);
        Permission::create(['name' => 'view poster','guard_name' => 'api']);
        // role
        Permission::create(['name' => 'list role']);
        Permission::create(['name' => 'edit role']);
        Permission::create(['name' => 'delete role']);
        Permission::create(['name' => 'add role']);

        Permission::create(['name' => 'list role','guard_name' => 'api']);
        Permission::create(['name' => 'edit role','guard_name' => 'api']);
        Permission::create(['name' => 'delete role','guard_name' => 'api']);
        Permission::create(['name' => 'add role','guard_name' => 'api']);
        // settings
        Permission::create(['name' => 'list settings']);
        Permission::create(['name' => 'edit settings']);
        Permission::create(['name' => 'delete settings']);
        Permission::create(['name' => 'add settings']);

        Permission::create(['name' => 'list settings','guard_name' => 'api']);
        Permission::create(['name' => 'edit settings','guard_name' => 'api']);
        Permission::create(['name' => 'delete settings','guard_name' => 'api']);
        Permission::create(['name' => 'add settings','guard_name' => 'api']);
        // speaker
        Permission::create(['name' => 'list speaker']);
        Permission::create(['name' => 'edit speaker']);
        Permission::create(['name' => 'delete speaker']);
        Permission::create(['name' => 'add speaker']);

        Permission::create(['name' => 'list speaker','guard_name' => 'api']);
        Permission::create(['name' => 'edit speaker','guard_name' => 'api']);
        Permission::create(['name' => 'delete speaker','guard_name' => 'api']);
        Permission::create(['name' => 'add speaker','guard_name' => 'api']);
        // subscriber
        Permission::create(['name' => 'list subscriber']);
        Permission::create(['name' => 'edit subscriber']);
        Permission::create(['name' => 'delete subscriber']);
        Permission::create(['name' => 'add subscriber']);

        Permission::create(['name' => 'list subscriber','guard_name' => 'api']);
        Permission::create(['name' => 'edit subscriber','guard_name' => 'api']);
        Permission::create(['name' => 'delete subscriber','guard_name' => 'api']);
        Permission::create(['name' => 'add subscriber','guard_name' => 'api']);
        // template
        Permission::create(['name' => 'list template']);
        Permission::create(['name' => 'edit template']);
        Permission::create(['name' => 'delete template']);
        Permission::create(['name' => 'add template']);

        Permission::create(['name' => 'list template','guard_name' => 'api']);
        Permission::create(['name' => 'edit template','guard_name' => 'api']);
        Permission::create(['name' => 'delete template','guard_name' => 'api']);
        Permission::create(['name' => 'add template','guard_name' => 'api']);
        // ticket
        Permission::create(['name' => 'list ticket']);
        Permission::create(['name' => 'edit ticket']);
        Permission::create(['name' => 'delete ticket']);
        Permission::create(['name' => 'add ticket']);

        Permission::create(['name' => 'list ticket','guard_name' => 'api']);
        Permission::create(['name' => 'edit ticket','guard_name' => 'api']);
        Permission::create(['name' => 'delete ticket','guard_name' => 'api']);
        Permission::create(['name' => 'add ticket','guard_name' => 'api']);
        // user
        Permission::create(['name' => 'list user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'add user']);

        Permission::create(['name' => 'list user','guard_name' => 'api']);
        Permission::create(['name' => 'edit user','guard_name' => 'api']);
        Permission::create(['name' => 'delete user','guard_name' => 'api']);
        Permission::create(['name' => 'add user','guard_name' => 'api']);
        // venue
        Permission::create(['name' => 'list venue']);
        Permission::create(['name' => 'edit venue']);
        Permission::create(['name' => 'delete venue']);
        Permission::create(['name' => 'add venue']);

        Permission::create(['name' => 'list venue','guard_name' => 'api']);
        Permission::create(['name' => 'edit venue','guard_name' => 'api']);
        Permission::create(['name' => 'delete venue','guard_name' => 'api']);
        Permission::create(['name' => 'add venue','guard_name' => 'api']);
        // misc
        Permission::create(['name' => 'edit profile']);

        Permission::create(['name' => 'edit profile','guard_name' => 'api']);

        // create roles and assign created permissions

        // this can be done as separate statements

        // subscriber, basic user, no permission except to edit own profile
        $role = Role::create(['name' => 'Subscriber'])
            ->givePermissionTo(['edit profile']);

        $role = Role::create(['name' => 'Subscriber', 'guard_name' => 'api'])
            ->givePermissionTo(['edit profile']);

        // reviewer
        $role = Role::create(['name' => 'Reviewer'])
            ->givePermissionTo(['list event review','edit event review','view event', 'view poster', 'edit profile']);

        $role = Role::create(['name' => 'Reviewer','guard_name' => 'api'])
            ->givePermissionTo(['list event review','edit event review','view event', 'view poster', 'edit profile']);
        // contributor
        $role = Role::create(['name' => 'Contributor'])
            ->givePermissionTo([
                'list poster','edit poster','list event','edit event',
                'list speaker','edit speaker','list venue','edit venue',
                'list booking','list attendee','delete booking','export booking',
                'print booking','list attendee','delete booking','export booking',
                'list subscriber','delete subscriber', 'export booking', 'edit profile', 'list template'
        ]);

        $role = Role::create(['name' => 'Contributor','guard_name' => 'api'])
            ->givePermissionTo([
                'list poster','edit poster','list event','edit event',
                'list speaker','edit speaker','list venue','edit venue',
                'list booking','list attendee','delete booking','export booking',
                'print booking','list attendee','delete booking','export booking',
                'list subscriber','delete subscriber', 'export booking', 'edit profile', 'list template'
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
                'list subscriber','delete subscriber', 'export booking', 'edit profile', 'list template'
            ]);
        $role = Role::create(['name' => 'Author','guard_name' => 'api'])
            ->givePermissionTo([
                'list poster','edit poster', 'delete poster', 'add poster',
                'list event','edit event', 'add event', 'delete event', 'publish event', 'submit event review', 
                'list ticket','edit ticket', 'add ticket', 'delete ticket',
                'list speaker','edit speaker', 'add speaker', 'delete speaker',
                'list venue','edit venue', 'add venue', 'delete venue',
                'list booking','list attendee','edit booking','delete booking','export booking',
                'print booking','list attendee','edit attendee', 'delete booking','export booking',
                'list subscriber','delete subscriber', 'export booking', 'edit profile', 'list template'
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
        $role = Role::create(['name' => 'Administrator','guard_name' => 'api'])
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
        $role = Role::create(['name' => 'Super Administrator','guard_name' => 'api']);

        $role = Role::create(['name' => 'Application'])
            ->givePermissionTo(['list event']);
        $role = Role::create(['name' => 'Application','guard_name' => 'api'])
            ->givePermissionTo(['list event']);

    }
}
