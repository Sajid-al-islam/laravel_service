# Welcome to Laravel User Management Apllication

##  Table of contents
* [Introduction](#introduction)
* [Features](#features)
* [Technologies](#technologies)
* [Setup](#setup)

##  Introduction
The "Laravel User anagement Apllication" is a web application where users can create their accounts, and manage other users, and their addresses

##  Features:
 
 ### User:
 - User can register and login.

 - user management
	 - manage users
		 - create
		 - edit
		 - update
		 - soft delete
         - restore deleted items
         - force delete
	 - manage user adress
		 - create
		 - update
		 - delete
     
   ### Application Features:
     - Service Arcitechture.
     - Unit test
     - Event listener
      
## Technologies
* PHP Laravel
* mySQL
* HTML
* Java Script
* Bootstrap

## Setup

####  Installation
**requirements**

 1. PHP:  ^8.1
 2. Laravel : ^10.10

First clone this repository, install the dependencies, and setup your .env file.

**run the commands**

clone project
```
git clone https://github.com/Sajid-al-islam/laravel_service.git
```

swith directory to project
```
cd laravel_service
```

install dependencies
```
composer install
```

copy .env.example and paste as .env
```
cp .env.example .env
or copy .env.example .env
```

generate app key
```
php artisan key:generate
```

open in vs code editor
```
code .
```

open .env file and change db name. 
**database setup**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=
```

**Creating Symlink to Storage**
```
php artisan storage:link
```

migrate database, and seed
```
php artisan migrate:fresh --seed 
```

after migration reseed, previous data will be remove
```	
php artisan db:seed
```

Finally time to launch project, run
```
php artisan serve
```
the project will open at http://127.0.0.1:8000

or
```
php artisan serve --port=8001 | any supported port number
```

**database seed will generate**

 -  login information and Five extra users.

####  login credentials

**user:** 
email: admin@gmail.com 
pass: @12345678

####  For testing, run
```
php artisan test
```



