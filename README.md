# Laravel Schedule Info

## Description 

A command to output your current laravel schedule in a human readable format.

## Installation 

```composer require lxlang/laravel-schedule-info```

## Usage

Run `./artisan schedule:info`

```
+------------+-------------------------+----------------------+-------------------+
| expression | command                 | when                 | next_due          |
+------------+-------------------------+----------------------+-------------------+
| 0 0 * * *  | inspire                 | Every day at 12:00am | 9 hours from now  |
+------------+-------------------------+----------------------+-------------------+
```