# The Blogavel
## A Laravel Blog using MongoDB & MySQL Hybrid connections
```
* With Login and Registration Module
* CRUD features for Blog posts by admin
* Comments section for posts
* Admin profile page for admin and simple stat reporting
```
## Built with
* [Laravel 5.5]
* [PHP 7.2]
* [MongoDB]
* [MySQL]

# Work Highlights

* Setup of dev environment
```
Using Laravel Valet - Pretty neat tool, I should say :)
```

* Based on a blog tutorial made for Laravel 5.2 - I think? (With lots of deprecated, Facades, etc)
```
http://www.findalltogether.com/tutorial/simple-blog-application-in-laravel-5-part-1-setup-database/
I had to be resourceful about the task. Following the tutorial did not come free from pain though:
I had to Figure out a lot of stuff and realize which parts are deprecated
e.g  classes and methods related to routing, directory structures, Auth Facades, Requests
```
* Implementation of MongoDB and MySQL Hybrid Relations
```
Did a crash course on MongoDB and researched best way to implement this.
Ended up using [laravel-mongodb] https://github.com/jenssegers/laravel-mongodb/tree/v3.3.1

Good choice I think since it supported MongoDB and MySQL Hybrid Relations out of the box
and it acts as an adapter for the core Laravel ORM and query builder implementations
```

* Implemented Embedded models for MongoDB based models
```
Refactored Post and Comment model relationship so that comments are embedded into posts
for a more nosql style of data structure.
```
