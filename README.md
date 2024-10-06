# Starter-Kit


#### A SK(Starter-Kit) system is a set of devices, by which you can get Initial Management of any project by that.


---


## Requirements

- PHP ^8.0.2
- Laravel ^9.19
- Node js ^18.16.0
- Yajra Datatables ^9.0
- SweetAlert2 ^11.6.16


## Installation


1. Clone the repository

    ```sh
    https://github.com/SarowarHB/Starter-Kit.git
    ```

2. Switch to the repo folder

    ```sh
    cd Starter-Kit
    ```

3. Install all the dependencies using composer & npm

    ```sh
    composer install

    npm install
    ```

4. Copy the example env file and make the required configuration changes in the .env file

    ```sh
    cp .env.example .env
    ```

5. Generate a new application key

    ```sh
    php artisan key:generate
    ```

6. Run the database migrations (**Set the database connection in .env before migrating**)

    ```sh
    php artisan migrate
    ```

7. Start the local development server

    ```sh
    php artisan serve
    
    npm run dev
    ```

You can now access the server at http://localhost:8000

**TLDR command list**

```sh
git clone https://github.com/SarowarHB/Starter-Kit.git

cd POS

composer install
npm install

cp .env.example .env

php artisan key:generate
```
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

```sh
php artisan migrate
php artisan serve
npm run dev
```

## Database seeding

**Populate the database with seed data with relationships which includes users, roles, permissions, configs, email templates, notifications and role of honor. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Open the All Seeder and set the property values as per your requirement & Run the database seeder and you're done.

```sh
php artisan migrate:fresh --seed --seeder=SystemData

php artisan db:seed --class=DemoData
```

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
    
## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

## Testing POS App

Run the laravel development server

    php artisan serve
    npm run dev

The frontend can now be accessed at

    http://localhost:8000/

And the backend can now be accessed at

    http://admin.localhost:8000/

Admin Login Access

    email: admin@example.com
    password: 123456

## How we can use Date & Time format?

- Example: 
    ```
    d-m-Y           // 25-05-2023
    d/m/Y           // 25/05/2023
    d-m-Y g:i A     // 25-05-2023 02:15 PM
    d-m-Y h:i:s     // 25-05-2023 14:15:55
    ```

- update your composer first
    ```sh
    composer update
    ```
- Add this attribute in to your Models
    ```php
    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }
    ```
- when show date & time called those method from controller or blade
    ```php
    // When print only date called this method
    $date = now()->format('d-m-Y');
    getFormattedDate($date) // pass a date parameter into this getFormattedDate() method & It will print only date.
    // Output : 25-10-2023
    ```
    ```php
    // when print only time called this method
    $time = now()->format('g:i A');
    getFormattedTime($time) // pass a time parameter into this getFormattedTime() method & It will print only time
    // Output : 03:25 PM
    ```
    ```php
    // When Print date & time both called this method
    $date_time = now()->format('d-m-Y g:i A')
    getFormattedDateTime($date_time) // pass a date_time parameter into this getFormattedDateTime() method & It will print date&time both
    // Output : 25-10-2023 03:25 PM
    ```
- when take input date & time called those class

    At first include this `@include('admin.assets.datetimepicker')` into end of your blade file && follow below instructions.
    ```php
    // single date picker
    <input type="text" name="date" class="datepicker" value="">
    ```
    ```php
    // single date picker with minimum date
    <input type="text" name="date" class="datepicker-min-today" value="">
    ```
    ```php
    // single date picker with maximum date
    <input type="text" name="date" class="datepicker-max-today" value="">
    ```
    ```php
    // single time picker
    <input type="text" name="time" class="timepicker" value="">
    ```
    ```php
    // date time picker
    <input type="text" name="datetime" class="datetimepicker" value="">
    ```
    ```php
    // date time picker with minimum date today
    <input type="text" name="datetime" class="datetimepicker-min-today" value="">
    ```
    ```php
    // date time picker with minimum date & time now
    <input type="text" name="datetime" class="datetimepicker-min-now" value="">
    ```
    ```php
    // date time picker with maximum date today
    <input type="text" name="datetime" class="datetimepicker-max-today" value="">
    ```
    ```php
    // date time picker with maximum date & time now
    <input type="text" name="datetime" class="datetimepicker-max-now" value="">
    ```
- when take input daterange & datetimerange called those id
    ```php
    // date range picker only date format
    <input type="text" name="daterange" id="daterangepicker" value="">
    ```
    ```php
    //date range picker date & time format
    <input type="text" name="datetimerange" id="datetimerangepicker" value="">
    ```
## How we can use Amount/Currency format?
- when show amount/price called those method from controller or blade
    ```php
    $amount = 100;
    getFormattedAmount($amount) // pass a amount parameter into this getFormattedAmount() method. If currency settings is not present, it will print default format.
    // Output : $100.00
    ``` 
