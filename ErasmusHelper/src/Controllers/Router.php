<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Controllers\AbstractRouter;

class Router extends AbstractRouter
{

    protected static function getDomain(): string
    {
        return PUBLIC_DOMAIN;
    }

    protected static function getRelativeDir(): string
    {
        return RELATIVE_DIR_PUBLIC;
    }

    protected static function getControllerClass(): string
    {
        return HomeController::class;
    }

    protected static function getRoutes(): array
    {
        return [
            '/'                             => ["GET", "/", [HomeController::class, "home"]],
            'login'                         => ["GET", "/login", [AuthController::class, "login"]],
            'logout'                        => ["GET", "/logout", [AuthController::class, "logout"]],
            'auth'                          => ["POST", "/auth", [AuthController::class, "auth"]],
            'configuration'                 => ["GET", "/menu", [ConfigurationController::class, "home"]],
            'staffs'                        => ["GET", "/staffs", [StaffController::class, "displayAll"]],
            'staffs.search'                 => ["POST", "/staffs/search", [ModalController::class, "searchStaffs"]],
            'staff.create.page'             => ["GET", "/staff/create", [StaffController::class, "create"]],
            'staff.create.uni'              => ["POST", "/staff/new/uni", [StaffController::class, "createUniPost"]],
            'staff.create.city'             => ["POST", "/staff/new/city", [StaffController::class, "createCityPost"]],
            'staff.create.country'          => ["POST", "/staff/new/country", [StaffController::class, "createCountryPost"]],
            'staff.ability'                 => ["GET", "/staff/ability/{id}", [StaffController::class, "changeAbility"]],
            'staff.edit.uni'                => ["POST", "/staff/edit/uni/{id}", [StaffController::class, "editUniPost"]],
            'staff.edit.city'               => ["POST", "/staff/edit/city/{id}", [StaffController::class, "editCityPost"]],
            'staff.edit.country'            => ["POST", "/staff/edit/country/{id}", [StaffController::class, "editCountryPost"]],
            'staff'                         => ["GET", "/staff/{id}", [StaffController::class, "edit"]],
            'users'                         => ["GET", "/users", [UserController::class, "displayAll"]],
            'users.search'                  => ["POST", "/users/search", [ModalController::class, "searchUsers"]],
            'user.ability'                  => ["GET", "/user/ability/{id}", [UserController::class, "changeAbility"]],
            'user.edit'                     => ["POST", "/user/edit/{id}", [UserController::class, "editPost"]],
            'user'                          => ["GET", "/user/{id}", [UserController::class, "edit"]],
            'countries'                     => ["GET", "/countries", [CountryController::class, "displayAll"]],
            'country.create.page'           => ["GET", "/country/create", [CountryController::class, "create"]],
            'country.create'                => ["POST", "/country/new", [CountryController::class, "createPost"]],
            'country.delete'                => ["GET", "/country/delete/{id}", [CountryController::class, "delete"]],
            'country.edit'                  => ["POST", "/country/edit/{id}", [CountryController::class, "editPost"]],
            'country'                       => ["GET", "/country/{id}", [CountryController::class, "edit"]],
            'cities'                        => ["GET", "/cities", [CityController::class, "displayAll"]],
            'city.create.page'              => ["GET", "/city/create", [CityController::class, "create"]],
            'city.create'                   => ["POST", "/city/new", [CityController::class, "createPost"]],
            'city.delete'                   => ["GET", "/city/delete/{id}", [CityController::class, "delete"]],
            'city.edit'                     => ["POST", "/city/edit/{id}", [CityController::class, "editPost"]],
            'city'                          => ["GET", "/city/{id}", [CityController::class, "edit"]],
            'faculties'                     => ["GET", "/faculties", [FacultyController::class, "displayAll"]],
            'faculty.create.page'           => ["GET", "/faculty/create", [FacultyController::class, "create"]],
            'faculty.create'                => ["POST", "/faculty/new", [FacultyController::class, "createPost"]],
            'faculty.delete'                => ["GET", "/faculty/delete/{id}", [FacultyController::class, "delete"]],
            'faculty.edit'                  => ["POST", "/faculty/edit/{id}", [FacultyController::class, "editPost"]],
            'faculty'                       => ["GET", "/faculty/{id}", [FacultyController::class, "edit"]],
            'university_faqs'               => ["GET", "/university_faqs", [UniversityFaqController::class, "displayAll"]],
            'university_faq.create.page'    => ["GET", "/university_faq/create", [UniversityFaqController::class, "create"]],
            'university_faq.create'         => ["POST", "/university_faq/new", [UniversityFaqController::class, "createFaq"]],
            'university_faq.delete'         => ["GET", "/university_faq/delete/{id}", [UniversityFaqController::class, "delete"]],
            'university_faq.edit'           => ["POST", "/university_faq/edit/{id}", [UniversityFaqController::class, "editFaq"]],
            'university_faq'                => ["GET", "/university_faq/{id}", [UniversityFaqController::class, "edit"]],
            'bureaucracies'                 => ["GET", "/bureaucracies", [BureaucracyController::class, "displayAll"]],
            'bureaucracy.create.page'       => ["GET", "/bureaucracy/create", [BureaucracyController::class, "create"]],
            'bureaucracy.create'            => ["POST", "/bureaucracy/new", [BureaucracyController::class, "createBureaucracy"]],
            'bureaucracy'                   => ["GET", "/bureaucracy/{id}", [BureaucracyController::class, "edit"]]
        ];
    }
}