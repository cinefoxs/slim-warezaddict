# AlphaReign Website - WarezAddict Edition - aka Slim-WarezAddict

This is a modified version (half-ass hack job) of AlphaReign's website. Please read the warning below before using this!
- The original AlphaReign website repo for production servers is [HERE](https://github.com/AlphaReign/www-php)
- More Info: https://github.com/AlphaReign/AlphaReign

-----

### WARNING: MUST READ!

This is my hack job version of the AlphaReign website. I am **NOT** a dev/coder. This version probably doesn't follow best practices and may not be secure! **I highly recommend NOT using this on a live, public, production server.** Use the original code created by an actual talented dev that does this for a living and knows what they are doing! I'm just a (below average) copy-n-paste wanna-be...

**If you put this on a live/public server and it get h4x0r3d by 1337 script kiddies, dont blame me (or anyone)! You have been warned!**

-----

## Changes/Features

TODO!

-----

## Install

**Requirements**
- PHP v7.0 or higher
- MySQL/MariaDB Database Server
- Nginx (highly recommend) or Apache Web Server
- [Composer](https://getcomposer.org/)

**Required PHP Packages**
- PHP7.x-FPM
- PHP7.x-MySQL / PHP7.x-SQLite / PHP7.x-MySQLi / MariaDB-Client 
- PHP7.x-cURL
- PHP7.x-MBString

Use your awesome Google-fo skillz to install everything above on your (NOT public/production) server/VPS. Google has thousands of step-by-step HOWTO guides for every linux distro.

**Next, Install PHP Dependencies**

```bash
$ cd /path/to/slim-warezaddict/
$ composer install
```

**Web Server**

You need to point your web server's `Root` directory to `/path/to/slim-warezaddict/public`

Again, fire up yo Google-fo skillz and see how to do it using whatever web server you use.

**IMPORTANT:** Take note of your web server's URL (IP and port, or localhost) AND the user:group your web server runs as. You will need this info below!

**Create/Edit .env File**

Copy `.env.example` file to `.env`. Open the new .env file and put in your personal TMDB API key. Save and close.

**Change/Fix File Permissions**

Change permissions of all files to the user:group your web server runs as...

```bash
$ sudo chown -R www-data:www-data /path/to/slim-warezaddict/
$ sudo chmod -R 775 /path/to/slim-warezaddict/
```

Now, (re)start your web server!

**Check It Out, Bruuuh**

Open your favorite web browser and visit `http://localhost` or whatever your URL/IP/PORT is!

-----

## Other

