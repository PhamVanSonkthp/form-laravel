<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;

class PermissionGateAndPolicyAccess{

    public function setGateAndPolicyAccess(){
        $this->defineGateUser();
        $this->defineGateChat();
        $this->defineGateEmployee();
        $this->defineGateRole();
        $this->defineGatePermission();
        $this->defineGateNotification();
        $this->defineGateLogo();
        $this->defineGateHistoryData();
        $this->defineGateSlider();
        $this->defineGateNews();
        $this->defineGateProduct();
        $this->defineGateCategory();
        $this->defineGateDashboard();
        $this->defineGateEmail();
        $this->defineGateSetting();
    }

    public function defineGateSetting(){
        Gate::define('setting-list','App\Policies\SettingPolicy@view');
        Gate::define('setting-add','App\Policies\SettingPolicy@create');
        Gate::define('setting-edit','App\Policies\SettingPolicy@update');
        Gate::define('setting-delete','App\Policies\SettingPolicy@delete');
    }

    public function defineGateEmail(){
        Gate::define('email-list','App\Policies\EmailPolicy@view');
        Gate::define('email-add','App\Policies\EmailPolicy@create');
        Gate::define('email-edit','App\Policies\EmailPolicy@update');
        Gate::define('email-delete','App\Policies\EmailPolicy@delete');
    }

    public function defineGateDashboard(){
        Gate::define('dashboard-list','App\Policies\DashboardPolicy@view');
        Gate::define('dashboard-add','App\Policies\DashboardPolicy@create');
        Gate::define('dashboard-edit','App\Policies\DashboardPolicy@update');
        Gate::define('dashboard-delete','App\Policies\DashboardPolicy@delete');
    }

    public function defineGateCategory(){
        Gate::define('category-list','App\Policies\CategoryPolicy@view');
        Gate::define('category-add','App\Policies\CategoryPolicy@create');
        Gate::define('category-edit','App\Policies\CategoryPolicy@update');
        Gate::define('category-delete','App\Policies\CategoryPolicy@delete');
    }

    public function defineGateProduct(){
        Gate::define('product-list','App\Policies\ProductPolicy@view');
        Gate::define('product-add','App\Policies\ProductPolicy@create');
        Gate::define('product-edit','App\Policies\ProductPolicy@update');
        Gate::define('product-delete','App\Policies\ProductPolicy@delete');
    }

    public function defineGateNews(){
        Gate::define('news-list','App\Policies\NewsPolicy@view');
        Gate::define('news-add','App\Policies\NewsPolicy@create');
        Gate::define('news-edit','App\Policies\NewsPolicy@update');
        Gate::define('news-delete','App\Policies\NewsPolicy@delete');
    }

    public function defineGateSlider(){
        Gate::define('slider-list','App\Policies\SliderPolicy@view');
        Gate::define('slider-add','App\Policies\SliderPolicy@create');
        Gate::define('slider-edit','App\Policies\SliderPolicy@update');
        Gate::define('slider-delete','App\Policies\SliderPolicy@delete');
    }

    public function defineGateUser(){
        Gate::define('user-list','App\Policies\UserPolicy@view');
        Gate::define('user-add','App\Policies\UserPolicy@create');
        Gate::define('user-edit','App\Policies\UserPolicy@update');
        Gate::define('user-delete','App\Policies\UserPolicy@delete');
    }

    public function defineGateChat(){
        Gate::define('chat-list','App\Policies\ChatPolicy@view');
        Gate::define('chat-add','App\Policies\ChatPolicy@create');
        Gate::define('chat-edit','App\Policies\ChatPolicy@update');
        Gate::define('chat-delete','App\Policies\ChatPolicy@delete');
    }

    public function defineGateEmployee(){
        Gate::define('employee-list','App\Policies\EmployeePolicy@view');
        Gate::define('employee-add','App\Policies\EmployeePolicy@create');
        Gate::define('employee-edit','App\Policies\EmployeePolicy@update');
        Gate::define('employee-delete','App\Policies\EmployeePolicy@delete');
    }

    public function defineGateRole(){
        Gate::define('role-list','App\Policies\RolePolicy@view');
        Gate::define('role-add','App\Policies\RolePolicy@create');
        Gate::define('role-edit','App\Policies\RolePolicy@update');
        Gate::define('role-delete','App\Policies\RolePolicy@delete');
    }

    public function defineGatePermission(){
        Gate::define('permission-list','App\Policies\PermissionPolicy@view');
        Gate::define('permission-add','App\Policies\PermissionPolicy@create');
        Gate::define('permission-edit','App\Policies\PermissionPolicy@update');
        Gate::define('permission-delete','App\Policies\PermissionPolicy@delete');
    }

    public function defineGateNotification(){
        Gate::define('notification-list','App\Policies\NotificationPolicy@view');
        Gate::define('notification-add','App\Policies\NotificationPolicy@create');
        Gate::define('notification-edit','App\Policies\NotificationPolicy@update');
        Gate::define('notification-delete','App\Policies\NotificationPolicy@delete');
    }

    public function defineGateLogo(){
        Gate::define('logo-list','App\Policies\LogoPolicy@view');
        Gate::define('logo-add','App\Policies\LogoPolicy@create');
        Gate::define('logo-edit','App\Policies\LogoPolicy@update');
        Gate::define('logo-delete','App\Policies\LogoPolicy@delete');
    }

    public function defineGateHistoryData(){
        Gate::define('history-data-list','App\Policies\HistoryDataPolicy@view');
        Gate::define('history-data-add','App\Policies\HistoryDataPolicy@create');
        Gate::define('history-data-edit','App\Policies\HistoryDataPolicy@update');
        Gate::define('history-data-delete','App\Policies\HistoryDataPolicy@delete');
    }

}
