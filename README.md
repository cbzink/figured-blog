# Figured Blog

Figured Blog is a coding excerise I wrote for [Figured](https://figured.com/). The requirements were to develop a simple blog application where users can read posts and administrators can log in to create, update, and delete posts. Figured requested the challenge be completed using Laravel 5.8, MongoDB, and Vue.js.

You can see a brief 3 minute demo of the blog in action here: [https://www.youtube.com/watch?v=0PFpsHSyOqQ](https://www.youtube.com/watch?v=0PFpsHSyOqQ).

## Table of Contents

- [Introduction](#figured-blog)
- [My Thoughts](#my-thoughts)
- [Things I Would Add](#things-i-would-add)
- [Getting Started](#getting-started)
    - [Prerequisites](#prerequisites)
    - [Installing](#installing)
- [Testing](#testing)

## My thoughts

- It was acceptable to use MySQL for storing users however the added complexity of managing two databases didn't seem worth it for such a simple application so I adapted users (authors) to use MongoDB.
- In considering ways that MongoDB might be beneficial for a blog I started down the path of tags. Free-form data like tags are much easier to deal with in MongoDB where you can store them right in the document rather than some convoluted many-to-many relationship situation. Unfortunately I didn't have enough time to fully explore that idea (more on that in [things I would add](#things-i-would-add).)
- Some of the Vue.js is more hacky than I would like it to be, especially the route guard checking if an author is logged in, but it works well enough.
- I'm really pleased with the experience from the author's side. Rather than having a completely seperate "admin portal", an author can jump right into updating (or deleting) a post from anywhere on the site, and the compose page feels very natural.

## Things I would add

Some things I would have liked to accomplished but didn't have the time for. I may try to tackle some of these over the weekend.

- Pagination was one of the sillier things I missed. I have used [vue-infinite-loading](https://github.com//PeachScript/vue-infinite-loading) in the past and it would be really well suited to this project.
- I would also like to pretty up permalinks using slugs at some point in the future.
- As I mentioned above, I wanted to explore the tags concept a bit more including being able to browse posts by tag.
- I would like to add real-time search (Algolia) as well. Algolia and document-oriented databases like MongoDB are a match made in heaven.
- All of the obvious blog stuff of course. Liking/upvoting, comments, etc.

## Getting started

These instructions will get a copy of the project up and running on your local machine for development.

### Prerequisites

You will need PHP 7.2, MongoDB (as well as the PHP MongoDB driver), and Composer. You'll also need a web server; I use [Valet](https://laravel.com/docs/5.8/valet) on macOS.

### Installing

Clone the repository to a folder on your workstation.

```
git clone git@githubcom:cbzink/figured-blog.git
```

Install Composer dependencies

```
composer install
```

Configure the application URL, MongoDB credentials, etc. in `.env`

```
APP_NAME="Figured Blog"
APP_URL=http://figured-blog.test

DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=figured-blog
DB_USERNAME=
DB_PASSWORD=
```

Install Passport

```
php artisan passport:install
```

Create a new Author

```
php artisan author:create
```

You're off to the races! Note that if you'll be using Figured Blog from a host other than http://figured-blog.test/ you will need to add the appropriate URL in `resources/js/config.js` and run `npm run dev` (or `prod`) first.

## Testing

### Running the tests

You can run the unit tests using PHPUnit.

```
./vendor/bin/phpunit
```