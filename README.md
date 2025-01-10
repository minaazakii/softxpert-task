
# Task Management System API

This Task is a RESTful API for a Task Management System, designed to provide robust and scalable task management capabilities while maintaining best practices.

`Used Spatie Permission to Provide Role-based access control based`

`Used Laravel Sanctum For User Authentication`




## Installation

After Cloning the project To Your device,
Firstly We need to Install Composer using the next command

```bash
  composer install
```

Then we need to copy the .env.example to .env using the following command

```bash
  cp .env.example .env
```

Now we have a .env file now we need to generate App key using the following command

```bash
  php artisan key:generate
```

Now everything is Ready you just need to connect to your database with your credentials in your .env then Run the following command to run migrations and and flag --seed to run seeders

```bash
  php artisan migrate --seed
```

Note: seeders will create 2 roles ['manager', 'user'] and create 2 users ['manager@mail.com','user@mail.com'] with Password: 'password'

If you want to create Dummy Task record in database

```bash
 php artisan db:seed --class=TaskSeeder
```
It will Generate 10 random Tasks with no users assigned to them with `pending` status with no Dependencies
