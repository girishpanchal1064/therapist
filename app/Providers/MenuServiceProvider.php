<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.sections.menu.verticalMenu', function ($view) {
            $menuData = $this->getMenuData();
            $view->with('menuData', $menuData);
        });
    }

    /**
     * Get menu data based on user role
     */
    private function getMenuData()
    {
        $user = Auth::user();

        if (!$user) {
            return collect([(object)['menu' => []]]);
        }

        // Load menu configuration
        $menuConfig = json_decode(file_get_contents(resource_path('menu/backendMenu.json')), true);

        // Special handling for Therapist role: limit menu
        if ($user->hasRole('Therapist')) {
            $therapistMenu = [
                [
                    'url' => '/therapist/dashboard',
                    'name' => 'Dashboard',
                    'icon' => 'menu-icon tf-icons ri-home-smile-line',
                    'slug' => 'therapist.dashboard'
                ],
                [
                    'url' => '/therapist/profile',
                    'name' => 'My Profile',
                    'icon' => 'menu-icon tf-icons ri-user-line',
                    'slug' => 'therapist.profile.edit'
                ],
                [
                    'url' => '/therapist/sessions',
                    'name' => 'Online Sessions',
                    'icon' => 'menu-icon tf-icons ri-group-line',
                    'slug' => 'therapist.sessions.index'
                ],
                [
                    'name' => 'Availability',
                    'icon' => 'menu-icon tf-icons ri-calendar-check-line',
                    'slug' => 'therapist.availability',
                    'submenu' => [
                        [
                            'url' => '/therapist/availability/set',
                            'name' => 'Set Availability',
                            'slug' => 'therapist.availability.set'
                        ],
                        [
                            'url' => '/therapist/availability/single',
                            'name' => 'Single Availability',
                            'slug' => 'therapist.availability.single'
                        ],
                        [
                            'url' => '/therapist/availability/block',
                            'name' => 'Block Availability',
                            'slug' => 'therapist.availability.block'
                        ]
                    ]
                ]
            ];

            // Convert arrays to objects (including nested submenu items)
            foreach ($therapistMenu as &$item) {
                if (isset($item['submenu']) && is_array($item['submenu'])) {
                    $item['submenu'] = array_map(function ($sub) { return (object) $sub; }, $item['submenu']);
                }
                $item = (object) $item;
            }
            unset($item);

            return collect([(object)['menu' => $therapistMenu]]);
        }

        // Filter menu items based on user permissions
        $filteredMenu = $this->filterMenuByPermissions($menuConfig['menu'], $user);

        // Convert arrays to objects for the template
        $filteredMenu = array_map(function($item) {
            return (object) $item;
        }, $filteredMenu);

        return collect([(object)['menu' => $filteredMenu]]);
    }

    /**
     * Filter menu items based on user permissions
     */
    private function filterMenuByPermissions($menuItems, $user)
    {
        $filteredMenu = [];

        foreach ($menuItems as $item) {
            // Check if user has permission to view this menu item
            if ($this->canViewMenuItem($item, $user)) {
                $filteredItem = $item;

                // If item has submenu, filter submenu items too
                if (isset($item['submenu'])) {
                    $filteredSubmenu = [];
                    foreach ($item['submenu'] as $subItem) {
                        if ($this->canViewMenuItem($subItem, $user)) {
                            $filteredSubmenu[] = (object) $subItem;
                        }
                    }
                    $filteredItem['submenu'] = $filteredSubmenu;
                }

                $filteredMenu[] = $filteredItem;
            }
        }

        return $filteredMenu;
    }

    /**
     * Check if user can view a specific menu item
     */
    private function canViewMenuItem($item, $user)
    {
        // Super admin can see everything
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }

        // Define permission mapping for menu items
        $permissionMap = [
            'admin.dashboard' => ['view users', 'view therapists', 'view appointments'],
            'admin.profile' => ['view profile'],
            'admin.profile.index' => ['view profile'],
            'admin.profile.edit' => ['view profile'],
            'admin.users' => ['view users'],
            'admin.users.index' => ['view users'],
            'admin.users.create' => ['create users'],
            'admin.therapists' => ['view therapists'],
            'admin.therapists.index' => ['view therapists'],
            'admin.therapists.create' => ['create therapists'],
            'admin.therapists.pending' => ['approve therapists'],
            'admin.appointments' => ['view appointments'],
            'admin.appointments.index' => ['view appointments'],
            'admin.appointments.create' => ['create appointments'],
            'admin.appointments.today' => ['view appointments'],
            'admin.blog' => ['view blog posts'],
            'admin.blog.index' => ['view blog posts'],
            'admin.blog.create' => ['create blog posts'],
            'admin.blog.categories' => ['view blog posts'],
            'admin.assessments' => ['view assessments'],
            'admin.assessments.index' => ['view assessments'],
            'admin.assessments.create' => ['create assessments'],
            'admin.assessments.results' => ['view assessment results'],
            'admin.payments' => ['view payments'],
            'admin.payments.index' => ['view payments'],
            'admin.payments.pending' => ['process payments'],
            'admin.payments.reports' => ['view financial reports'],
            'admin.reviews' => ['view reviews'],
            'admin.reviews.index' => ['view reviews'],
            'admin.reviews.pending' => ['approve reviews'],
            'admin.settings' => ['view settings'],
            'admin.settings.general' => ['view settings'],
            'admin.settings.roles' => ['view settings'],
            'admin.settings.system' => ['view system logs'],
            'admin.roles' => ['view settings'],
            'admin.roles.index' => ['view settings'],
            'admin.roles.create' => ['view settings'],
            'admin.roles.show' => ['view settings'],
            'admin.roles.edit' => ['view settings'],
            'admin.permissions' => ['view settings'],
            'admin.permissions.index' => ['view settings'],
            'admin.permissions.create' => ['view settings'],
            'admin.permissions.show' => ['view settings'],
            'admin.permissions.edit' => ['view settings'],
            'admin.user-roles' => ['view settings'],
            'admin.user-roles.index' => ['view settings'],
            'admin.reports' => ['view financial reports'],
            'admin.reports.users' => ['view users'],
            'admin.reports.appointments' => ['view appointments'],
            'admin.reports.financial' => ['view financial reports'],
        ];

        $slug = $item['slug'] ?? '';

        // If no specific permission is defined, allow access
        if (!isset($permissionMap[$slug])) {
            return true;
        }

        // Check if user has any of the required permissions
        $requiredPermissions = $permissionMap[$slug];
        return $user->hasAnyPermission($requiredPermissions);
    }
}
