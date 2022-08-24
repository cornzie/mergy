# Mergy API


## Requests

### POST Create user 

`mergy.test/api/users`

Creates a user profile

Bodyraw (json)
```
    {
    "id": "ahd123@zod15",
    "name": "Cornelius",
    "email": "email15@test.com",
    "password": "password",
    "job": "userjob",
    "cv": "https://url.test",
    "user_image": "https://url.test",
    "experiences": [
        {
        "job_title": "title",
        "location": "location",
        "start_date": "01/08/2022",
        "end_date": "01/08/2022"
        },
        {
        "job_title": "title",
        "location": "location",
        "start_date": "01/08/2022",
        "end_date": "01/08/2022"
        }
    ]
    }
```

### GET Get a user profile

`mergy.test/api/users/{id}`

Fetch one user profile details

#### Authorization
Bearer Token <token>

### PUT Update user details

`mergy.test/api/users/{id}`

Updates a user profile.

All fields can be updated independently, except the id field

### Authorization
Bearer Token <token>
Bodyraw (json)
```
    {
    "name": "Cornelius",
    "password": "password",
    "job": "userjob",
    "cv": "https://url.test",
    "user_image": "https://url.test",
    "experiences": [
        {
        "job_title": "title 3",
        "location": "location",
        "start_date": "01/12/2022",
        "end_date": "01/08/2022"
        },
        {
        "job_title": "title",
        "location": "location",
        "start_date": "01/08/2022",
        "end_date": "01/08/2022"
        }
    ]
    }
```

### DEL Delete user

`mergy.test/api/users/`

Delete a user profile.

#### Authorization
Bearer Token <token>

Bodyraw (json)

```
    {
    "id": "ahd123@zod15"
    }
```

### POST Get Bearer Token

`mergy.test/api/login`

Provide a registered email and correct password to get an auth_token

Bodyraw (json)

```
{
  "email": "email15@test.com",
  "password": "password"
}
```

### POST Destroy Auth Token

`mergy.test/api/logout`

Make things easier for your teammates with a complete request description.

#### Authorization
Bearer Token <token>

******************

## Setup Locally

- Clone the repository
`git clone https://github.com/cornzie/mergy.git`

- Install all the dependencies
`composer install`

- Set app key
`php artisan key:generate`

- Setup database (ensure the database exists)
`php artisan migrate`

- Depending on your local environment, start the server. If using Laravel Valet, skip!
`php artisan serve`

Fancy using Docker on MacOS?
- See [here](https://laravel.com/docs/9.x/installation#getting-started-on-macos)

******************

# Server Requirements
- See [Laravel's standard requirements](https://laravel.com/docs/9.x/deployment#server-requirements)
- ready to go NGINX conf can be found [here](https://laravel.com/docs/9.x/deployment#nginx)