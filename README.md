
# Welcome To CRUD Operations Api repository
## Table of Contents

-   [Introduction](#introduction)
-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Running Migrations](#running-migrations)
-   [Running Server](#running-server)
-   [About The Packages](#about-the-packages-in-the-project)
## Introduction

A robust API skeleton built on Laravel, serving as the foundation for scalable and maintainable API-driven applications.

## Requirements
<p align="center"> <a href="https://www.php.net/"> <img src="https://www.php.net/images/logos/new-php-logo.svg" height="60"> </a> <a href="https://www.mysql.com/"> <img src="https://www.mysql.com/common/logos/logo-mysql-170x115.png" height="60"> </a> <a href="https://getcomposer.org/">
<img src="https://getcomposer.org/img/logo-composer-transparent.png" height="60"> </a> 
<a href="https://laravel.com/"> <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" height="60"> </a> 
</p>

-   **PHP**: ^8.2
-   **MySQL**: ^5.7 or ^8.0
-   **Composer**: ^2.0

## Installation

### Step 1: Clone the repository

`git clone https://github.com/mostafasamirs/crud-operations-api-repository.git`  
`cd crud-operations-api-repository`

### Step 2: Install dependencies

`composer install`

## Configuration

### Step 1: Set up environment file

`cp .env.example .env`

### Step 2: Generate application key

`php artisan key:generate`

## Running Migrations

To set up your database, run:     
`php artisan migrate:fresh --seed`

## Running Server

To start the development server, run: `php artisan serve`.    
Visit [http://127.0.0.1:8000](http://127.0.0.1:8000) in your browser to view the application.

## About the Packages in the project
**astrotomic/laravel-translatable**: This is a Laravel package for translatable models. With this package, you write less code, as the translations are automatically fetched and saved.

**laravel/framework**: The core Laravel framework. It provides the foundation and structure for your Laravel application, including routing, controllers, views, and other essential components.

**laravel/sanctum**: A lightweight authentication system for SPAs (Single Page Applications), mobile applications, and API-based applications. It provides a simple way to generate API tokens.

**laravel/tinker**: A REPL (Read-Eval-Print Loop) for Laravel, allowing you to interact with your Laravel application from the command line and test code snippets.

**mcamara/laravel-localization**: A package that helps with localization in Laravel applications. It provides routes with prefixes for each language and helps with language switching.

**spatie/laravel-activitylog**: This package provides easy-to-use functions to log the activities of users of your application. It can help you record who did what, when, and to which model.

**spatie/laravel-html**: A package that helps you build HTML in Laravel. It provides an elegant way to create forms, links, and other HTML elements.

**spatie/laravel-medialibrary**: This package provides an easy way to add file uploads and media management to your Laravel models. It handles conversions, multiple file collections, and more.

**spatie/laravel-permission**: A package for managing user permissions and roles in your Laravel application. It provides a simple way to control what users can do in your application.

**yajra/laravel-datatables**: A package that makes it easy to create server-side processing DataTables in Laravel applications. It's useful for displaying large amounts of data in tables with features like pagination, searching, and sorting.
