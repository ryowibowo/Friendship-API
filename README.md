
<!-- ABOUT THE PROJECT -->
## About The Project
Friendship Managemen, build with Lumen 8, that implements main functionalities such as: 
    - List Friend Request
    - List Friends
    - add friends
    - Accept / Reject
    - Mutual Friends (not yet)
    - block users


- Search
### Built With

- Lumen 8
- PHP 7.4

<!-- GETTING STARTED -->
###  Getting Started


1. Clone the repo
   ```sh
   git clone https://github.com/ryowibowo/Friendship-API.git
   ```
2. Install composer dependencies
```
composer install
```
3. Create a copy of your .env file
```
cp .env.example .env
```
4.Set up your database credentials in the .env file.
```
DB_CONNECTION=mysql
DB_HOST=yourHost
DB_PORT=3306
DB_DATABASE=yourDatabaseName
DB_USERNAME=yourUsername
DB_PASSWORD=yourPassword
```
5. Generate an app encryption key
```
php artisan key:generate
```
6. Create an empty database. Make sure that the name in the .env file corresponds with the created database.
7.Migrate the database
```
php artisan migrate
```

7. You can as well seed the database. When seeding you can see some errors due to the relationships between tables
```
php artisan db:seed
```

8. Run the server. You can use artisan like this:
```
php -S localhost:8000 -t public
```

### How To run API 
Import file "Logique API.postman_collection.json" Collection on Postman
