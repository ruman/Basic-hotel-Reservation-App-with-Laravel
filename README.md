# 21615. Test Assignment for Laravel _ Frontend 

https://app.codeline.io/#/projects/1969/tasks/21615


Laravel Booking Application
==========================================

This application build with Laravel 5.8. Frontend booking build with ReactJS and have the following features:

- Back-end Management
- API integrated. With simple authentication token can make reservation. API authentication Protected by Laravel Passport.
- Backend Authentication Protect by Laravel Authentication
- CRUD functionalities for Hotels, Rooms, Room Types, Room Capacities.


# Installation

```bash
git clone [repourl]
cd repodir
npm install 
composer install
composer dump-autoload
```

Create .env file 
```bash
cp .env.example .env
```

Edit .env file with database information and then
```bash
php artisan config:cache
php artisan migrate
php artisan db:seed
# for build the frontend
npm run dev
#run the application
php artisan serve
# now you shoud see the booking from here:
http://localhost:8080
```

## Remaining Issues

This application is now fully-functional but still have some points which will need to update and they are:

- Create Backend Manager for Room Prices
- Create Backend Manager for Bookings
- Create Backend Manager for Customers


