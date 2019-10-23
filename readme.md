# CampBoard [![Build Status](https://travis-ci.org/hamza094/campboard.svg?branch=master)](https://travis-ci.org/hamza094/campboard)
Online Board Platform for Adding Different Projects

# Installation
## Step 1.
To run this project, you must have PHP 7 installed as a prerequisite.

Begin by cloning this repository to your machine, and installing all Composer dependencies.

- git clone https://github.com/hamza094/campboard.git
- cd socialforum && composer install
- php artisan key:generate
- mv .env.example .env

## Step 2.
Next, create a new database and reference its name and username/password within the project's .env file. In the example below, we've named the database, "campboard"

- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=campboard
- DB_USERNAME=root
- DB_PASSWORD=

## Step 3.
- Register with your gravatar account Add new projects and its tasks.
- Invite existing users to your project. 

For live view visit site https://campboard.herokuapp.com/
