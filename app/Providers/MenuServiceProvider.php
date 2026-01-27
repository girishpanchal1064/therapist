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
        $menuFilePath = resource_path('menu/backendMenu.json');
        
        if (!file_exists($menuFilePath)) {
            return collect([(object)['menu' => []]]);
        }
        
        $menuJson = file_get_contents($menuFilePath);
        $menuConfig = json_decode($menuJson, true);
        
        // Check if JSON decode was successful
        if ($menuConfig === null || json_last_error() !== JSON_ERROR_NONE || !isset($menuConfig['menu'])) {
            return collect([(object)['menu' => []]]);
        }

        // Special handling for Client role: custom menu
        if ($user->hasRole('Client')) {
            $clientMenu = [
                [
                    'url' => '/client/dashboard',
                    'name' => 'Dashboard',
                    'icon' => 'menu-icon tf-icons ri-home-smile-line',
                    'slug' => 'client.dashboard'
                ],
                [
                    'url' => '/client/appointments',
                    'name' => 'Appointments',
                    'icon' => 'menu-icon tf-icons ri-calendar-check-line',
                    'slug' => 'client.appointments.index'
                ],
                [
                    'url' => '/client/sessions',
                    'name' => 'My Sessions',
                    'icon' => 'menu-icon tf-icons ri-video-line',
                    'slug' => 'client.sessions.index'
                ],
                [
                    'url' => '/client/wallet',
                    'name' => 'Wallet',
                    'icon' => 'menu-icon tf-icons ri-wallet-3-line',
                    'slug' => 'client.wallet.index'
                ],
                [
                    'url' => '/assessments',
                    'name' => 'Assessments',
                    'icon' => 'menu-icon tf-icons ri-file-list-3-line',
                    'slug' => 'assessments.index'
                ],
                [
                    'url' => '/client/reviews',
                    'name' => 'Reviews',
                    'icon' => 'menu-icon tf-icons ri-star-line',
                    'slug' => 'client.reviews.index'
                ],
                [
                    'url' => '/client/profile',
                    'name' => 'My Profile',
                    'icon' => 'menu-icon tf-icons ri-user-line',
                    'slug' => 'client.profile.index'
                ],
                [
                    'url' => '/client/rewards',
                    'name' => 'Rewards',
                    'icon' => 'menu-icon tf-icons ri-gift-line',
                    'slug' => 'client.rewards.index'
                ],
                [
                    'url' => '/',
                    'name' => 'Visit Website',
                    'icon' => 'menu-icon tf-icons ri-global-line',
                    'slug' => 'home',
                    'target' => '_blank'
                ],
                [
                    'url' => '#',
                    'name' => 'Logout',
                    'icon' => 'menu-icon tf-icons ri-logout-box-r-line',
                    'slug' => 'logout',
                    'onclick' => 'event.preventDefault(); document.getElementById("logout-form").submit();'
                ]
            ];

            // Convert arrays to objects
            if (!is_array($clientMenu)) {
                $clientMenu = [];
            }
            
            if (!empty($clientMenu)) {
                foreach ($clientMenu as $key => $item) {
                    if (!isset($item) || !is_array($item)) {
                        continue;
                    }
                    
                    $itemArray = $item;
                    
                    if (isset($itemArray['submenu']) && is_array($itemArray['submenu']) && !empty($itemArray['submenu'])) {
                        $itemArray['submenu'] = array_map(function ($sub) { 
                            return is_array($sub) ? (object) $sub : $sub; 
                        }, $itemArray['submenu']);
                    }
                    
                    $clientMenu[$key] = (object) $itemArray;
                }
            }

            return collect([(object)['menu' => $clientMenu ?? []]]);
        }

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
                    'name' => 'Profile',
                    'icon' => 'menu-icon tf-icons ri-user-line',
                    'slug' => 'therapist.profile.index'
                ],
                [
                    'url' => '/therapist/sessions',
                    'name' => 'Online Sessions',
                    'icon' => 'menu-icon tf-icons ri-group-line',
                    'slug' => 'therapist.sessions.index'
                ],
                [
                    'url' => '/therapist/reviews',
                    'name' => 'Reviews',
                    'icon' => 'menu-icon tf-icons ri-star-line',
                    'slug' => 'therapist.reviews.index'
                ],
                [
                    'url' => '/therapist/account-summary',
                    'name' => 'Account Summary',
                    'icon' => 'menu-icon tf-icons ri-file-list-3-line',
                    'slug' => 'therapist.account-summary.index'
                ],
                [
                    'url' => '/therapist/session-notes',
                    'name' => 'Session Notes',
                    'icon' => 'menu-icon tf-icons ri-file-text-line',
                    'slug' => 'therapist.session-notes.index'
                ],
                [
                    'url' => '/therapist/agreements',
                    'name' => 'Agreements',
                    'icon' => 'menu-icon tf-icons ri-file-paper-2-line',
                    'slug' => 'therapist.agreements.index'
                ],
                [
                    'url' => '/therapist/rewards',
                    'name' => 'Rewards',
                    'icon' => 'menu-icon tf-icons ri-gift-line',
                    'slug' => 'therapist.rewards.index'
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
                ],
                [
                    'url' => '/',
                    'name' => 'Visit Website',
                    'icon' => 'menu-icon tf-icons ri-global-line',
                    'slug' => 'home',
                    'target' => '_blank'
                ],
                [
                    'url' => '#',
                    'name' => 'Logout',
                    'icon' => 'menu-icon tf-icons ri-logout-box-r-line',
                    'slug' => 'logout',
                    'onclick' => 'event.preventDefault(); document.getElementById("logout-form").submit();'
                ]
            ];

            // Convert arrays to objects (including nested submenu items)
            if (!is_array($therapistMenu)) {
                $therapistMenu = [];
            }
            
            if (!empty($therapistMenu)) {
                foreach ($therapistMenu as $key => $item) {
                    if (!isset($item) || !is_array($item)) {
                        continue;
                    }
                    
                    $itemArray = $item;
                    
                    if (isset($itemArray['submenu']) && is_array($itemArray['submenu']) && !empty($itemArray['submenu'])) {
                        $itemArray['submenu'] = array_map(function ($sub) { 
                            return is_array($sub) ? (object) $sub : $sub; 
                        }, $itemArray['submenu']);
                    }
                    
                    $therapistMenu[$key] = (object) $itemArray;
                }
            }

            return collect([(object)['menu' => $therapistMenu ?? []]]);
        }

        // Filter menu items based on user permissions
        if (!isset($menuConfig['menu']) || !is_array($menuConfig['menu'])) {
            return collect([(object)['menu' => []]]);
        }
        
        $filteredMenu = $this->filterMenuByPermissions($menuConfig['menu'], $user);

        // Add Visit Website and Logout menu items at the end for admin users
        $filteredMenu[] = [
            'url' => '/',
            'name' => 'Visit Website',
            'icon' => 'menu-icon tf-icons ri-global-line',
            'slug' => 'home',
            'target' => '_blank'
        ];
        $filteredMenu[] = [
            'url' => '#',
            'name' => 'Logout',
            'icon' => 'menu-icon tf-icons ri-logout-box-r-line',
            'slug' => 'admin.logout',
            'onclick' => 'event.preventDefault(); document.getElementById("logout-form").submit();'
        ];

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

        if (!is_array($menuItems) || empty($menuItems)) {
            return $filteredMenu;
        }

        foreach ($menuItems as $item) {
            if (!isset($item) || (!is_array($item) && !is_object($item))) {
                continue;
            }
            
            // Convert to array if it's an object for easier checking
            $itemArray = is_array($item) ? $item : (array) $item;
            
            // Skip Users menu (commented out for now)
            if (isset($itemArray['slug']) && $itemArray['slug'] === 'admin.users') {
                continue;
            }
            
            // Skip menu headers with "Account" or "USER MANAGEMENT" text
            if (isset($itemArray['menuHeader'])) {
                $headerText = strtolower(trim($itemArray['menuHeader']));
                if ($headerText === 'account' || $headerText === 'user management') {
                    continue;
                }
            }
            
            // Check if user has permission to view this menu item
            if ($this->canViewMenuItem($item, $user)) {
                $filteredItem = $itemArray;

                // If item has submenu, filter submenu items too
                if (isset($itemArray['submenu']) && is_array($itemArray['submenu'])) {
                    $filteredSubmenu = [];
                    foreach ($itemArray['submenu'] as $subItem) {
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
            'admin.areas-of-expertise.index' => ['super admin only'],
            'admin.specializations.index' => ['super admin only'],
            'admin.sessions.index' => ['super admin only'],
            'admin.therapist-availability.index' => ['super admin only'],
            'admin.account-summary.index' => ['super admin only'],
        ];

        // Handle both array and object formats
        if (is_array($item)) {
            $slug = $item['slug'] ?? '';
        } else {
            $slug = $item->slug ?? '';
        }

        // If no specific permission is defined, allow access
        if (empty($slug) || !isset($permissionMap[$slug])) {
            return true;
        }

        // Check if user has any of the required permissions
        $requiredPermissions = $permissionMap[$slug];
        return $user->hasAnyPermission($requiredPermissions);
    }
}
