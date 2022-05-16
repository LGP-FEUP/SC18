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
            '/' => ["GET", "/", [HomeController::class, "home"]],
            'login' => ["GET", "/login", [AuthController::class, "login"]],
            'logout' => ["GET", "/logout", [AuthController::class, "logout"]],
            'auth' => ["POST", "/auth", [AuthController::class, "auth"]],
            'configuration' => ["GET", "/menu", [ConfigurationController::class, "home"]],
            'staffs' => ["GET", "/staffs", [StaffController::class, "displayAll"]],
            'staff.create.page' => ["GET", "/staff/create", [StaffController::class, "create"]],
            'staff.create' => ["POST", "/staff/new", [StaffController::class, "createPost"]],
            'staff.ability' => ["GET", "/staff/ability/{id}", [StaffController::class, "changeAbility"]],
            'staff.edit' => ["POST", "/staff/edit/{id}", [StaffController::class, "editPost"]],
            'staff' => ["GET", "/staff/{id}", [StaffController::class, "edit"]],
            'users' => ["GET", "/users", [UserController::class, "displayAll"]],
            'user.ability' => ["GET", "/user/ability/{id}", [UserController::class, "changeAbility"]],
            'user.edit' => ["POST", "/user/edit/{id}", [UserController::class, "editPost"]],
            'user' => ["GET", "/user/{id}", [UserController::class, "edit"]],
            'countries' => ["GET", "/countries", [CountryController::class, "displayAll"]],
            'country.create.page' => ["GET", "/country/create", [CountryController::class, "create"]],
            'country.create' => ["POST", "/country/new", [CountryController::class, "createPost"]],
            'country.delete' => ["GET", "/country/delete/{id}", [CountryController::class, "delete"]],
            'country.edit' => ["POST", "/country/edit/{id}", [CountryController::class, "editPost"]],
            'country' => ["GET", "/country/{id}", [CountryController::class, "edit"]],
            'cities' => ["GET", "/cities", [CityController::class, "displayAll"]],
            'city.create.page' => ["GET", "/city/create", [CityController::class, "create"]],
            'city.create' => ["POST", "/city/new", [CityController::class, "createPost"]],
            'city.delete' => ["GET", "/city/delete/{id}", [CityController::class, "delete"]],
            'city.edit' => ["POST", "/city/edit/{id}", [CityController::class, "editPost"]],
            'city' => ["GET", "/city/{id}", [CityController::class, "edit"]],
            'faculties' => ["GET", "/faculties", [FacultyController::class, "displayAll"]],
            'faculty.create.page' => ["GET", "/faculty/create", [FacultyController::class, "create"]],
            'faculty.create' => ["POST", "/faculty/new", [FacultyController::class, "createPost"]],
            'faculty.delete' => ["GET", "/faculty/delete/{id}", [FacultyController::class, "delete"]],
            'faculty.edit' => ["POST", "/faculty/edit/{id}", [FacultyController::class, "editPost"]],
            'faculty' => ["GET", "/faculty/{id}", [FacultyController::class, "edit"]],
            'step.edit' => ["POST", "/step/edit/{id}", [StepController::class, "editStep"]],
            'step.create' => ["POST", "/step/new", [StepController::class, "createStep"]],
            'tasks' => ["GET", "/tasks", [TaskController::class, "displayAll"]],
            'task.edit' => ["POST", "/task/edit/{id}", [TaskController::class, "editTask"]],
            'task.create' => ["POST", "/task/new", [TaskController::class, "createTask"]],
            'task.delete' => ["GET", "/task/delete/{id}", [TaskController::class, "delete"]],
            'task.create.page' => ["GET", "/task/create", [TaskController::class, "create"]],
            'task' => ["GET", "/task/{id}", [TaskController::class, "edit"]],
            'university_faqs' => ["GET", "/university_faqs", [UniversityFaqController::class, "displayAll"]],
            'university_faq.edit' => ["POST", "/university_faq/edit/{id}", [UniversityFaqController::class, "editFaq"]],
            'university_faq.delete' => ["GET", "/university_faq/delete/{id}", [UniversityFaqController::class, "delete"]],
            'university_faq.create' => ["POST", "/university_faq/new", [UniversityFaqController::class, "createFaq"]],
            'university_faq.create.page' => ["GET", "/university_faq/create", [UniversityFaqController::class, "create"]],
            'university_faq' => ["GET", "/university_faq/{id}", [UniversityFaqController::class, "edit"]],
        ];
    }
}