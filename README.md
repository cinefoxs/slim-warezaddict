# Slim-WarezAddict

Movie database, search engine, website, or something like that! Powered by Slim PHP Framework.

#### !!!!! WARNING !!!!!

##### DO NOT use this on a live, public, production server!

I use this on my local home network. It was not meant to be accessed by anyone, other than myself. So... very little (if any) security measures are incorperated! It was no concern and not needed.

Simply Put...

**If you use this on a live/public server and you get h4x0r3d by 1337 script kiddies, dont blame me! You have been warned!**

-----

## Requirements

- PHP v7.0 or higher
- MySQL/MariaDB Database Server
- Nginx (recommend) or Apache Web Server
- [Composer](https://getcomposer.org/)

Use your awesome Google-fo skillz to install everything above on your (NOT public/production) server/VPS. Google has thousands of step-by-step HOWTO guides for every linux distro.

-----

## Install

**Install PHP Dependencies**

```bash
$ cd /path/to/slim-warezaddict/
$ composer install
```

**Web Server**

You need to point your web server's `Root` directory to `/path/to/slim-warezaddict/public`

Again, fire up yo Google-fo skillz and see how to do it using whatever web server you use.

**Create/Edit .env File**

Copy `.env.example` file to `.env`. Open the new .env file and put in your personal info. Save and close.

**Change/Fix File Permissions**

Change permissions of all files to the user:group your web server runs as. If you dont know... yes... Google-Foo Skillz Bruh!

```bash
$ sudo chown -R www-data:www-data /path/to/slim-warezaddict/
$ sudo chmod -R 775 /path/to/slim-warezaddict/
```

**Now, start or restart your web server!**

Open your favorite web browser and visit `http://localhost` or whatever your URL/IP/PORT is!

-----

## Change Default Admin Account Info/Password

To generate a new admin password

1) Create `pass.php` file with...

```php
<?php

// Your Password
$myPass = 'p@55w0rd1!';

// Hash our Password...
$hash = password_hash($myPass, PASSWORD_DEFAULT);

// Show Results
echo $hash . "\n";

```

Obviously, change `p@55w0rd1!` to whatever password you want to use!

Type `php pass.php` and you will see your new password hash! Copy it. Now, you need to replace the current/default hash with your hash.

2) Download a SQLite Database Browser/GUI. Examples: SQLiteBrowser, Adminer (single PHP file), and many more available.

Open `/path/to/slim-warezaddict/database/slim-warezaddict.db` database in your favorite SQLite database editor...

Go to the users table, edit the admin account (first one, with id of 0) and replace the old hash with your new hash. Save and close the DB.

3) Now, you are the admin and you can login to the admin dashboard using your own password, e-mail address etc!

The Admin Dashboard URL: `http://your-site.com/admin`

-----

## Facts

**HUGE thanks to the real, talented devs/coders that did all the work and made it open source for anyone and everyone to see! Please support these people! Donate some spare/leftover change to them. You may not think some change or a dollar or two is worth it, but it is! These people get paid nothing for this. They spend their own personal time, working for free, and give is all away to anyone in the world... for nothing!**

- I'm just a (below average) copy-n-paste hack-job wanna-be
- 99.9% of this code is NOT mine
- I take 0 credit

If I used your code and did not give you the credit, please don't hesitate to let me know! I appologize in advance and will fix/change/delete/add or whatever needs to be done!
