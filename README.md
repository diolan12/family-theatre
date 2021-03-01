# Family Theatre
 Simple web app made with plain php, built for your home family theatre.
 This app doesn't require a database, instead this app will scan directories in the given symlink and depends on json file for the data of the movie. This app support both single movie file in a directory and a multi serial video.
 There are 2 types of folder recognized by this app. type 1 is `movie` where there is only one video in a directory, and then type 2 is `serial` where there is multi video in a directory. This app also supports multiple subtitle, currently works with `.vtt` only, so when you have a `.srt` subtitle file you can convert it [here](https://subtitletools.com/convert-to-vtt-online) and then fill the data in the `index.json` file in each directory.

# Screenshots
- Desktop
![desktop](https://github.com/diolan12/family-theatre/raw/main/res/Screenshot%202021-03-01%20090941.jpg)
- Mobile
![mobile](https://github.com/diolan12/family-theatre/raw/main/res/2021-03-01%20at%2009.11.33.jpeg)

# Requirements
- Web server software e.g. Nginx, Apache (xampp, wamp)
- PHP
- Browsers (e.g. Chrome, Firefox, Safari, Edge)
- Wifi network (optional)

# How to install (xampp - windows)
1. Make sure to your web server app is already installed.
2. Clone this repository to your `htdocs` directory in your xampp folder.
3. Create a symlink inside this app installation.
    - windows: run cmd as admin > create symlink junction `mklink /J C:\LinkToFolder C:\Users\Name\OriginalFolder`.
    - [how to create a symlink](https://www.howtogeek.com/howto/16226/complete-guide-to-symbolic-links-symlinks-on-windows-or-linux/).
4. Open app.php with text editor of your choice (vscode, notepad++, sublime, vim, etc).
5. Fill the app constants, then save it (documentation included).
6. Done.

# How to add movies and subtitles
1. Make sure you already create a symlink to your video directory.
2. Copy **`movie_index.json`** to your movie directory.
3. Google for the movie poster art and download it with format of `.jpg` (optional but recommended), this will reduce load speed.
4. Convert your `.srt` subtitle to `.vtt` [here](https://subtitletools.com/convert-to-vtt-online).
5. Place your `.vtt` subtitle in the same directory next to your movie video.
6. If you have more than one subtitle, repeat **step number 4 and 5**.
7. Edit **`movie_index.json`** with notepad, right click on it > select `Open with...` > select `notepad` (or use any of your favorite text editor).
8. Fill the movie information (example included) then save it.
9. Rename **`movie_index.json`** to **`index.json`**.
10. Done.

# How to add serials and subtitles
1. Make sure you already create a symlink to your video directory.
2. Copy **`serial_index.json`** to your movie directory.
3. Google for the serial poster art and download it with format of `.jpg` (optional but recommended),this will reduce load speed.
4. Convert your `.srt` subtitle to `.vtt` [here](https://subtitletools.com/convert-to-vtt-online).
5. Place your `.vtt` subtitle in the same directory next to your serial video.
6. If you have more than one subtitle, repeat **step number 4 and 5**.
7. Edit **`serial_index.json`** with notepad, right click on it > select `Open with...` > select `notepad` (or use any of your favorite text editor).
8. Fill the serial information (example included) then save it.
9. Rename **`serial_index.json`** to **`index.json`**.
10. Done.

# How to serve
There are two ways to serve this app. first is using xampp server, second is using cmd to serve with php built-in server
## Serve with xampp server
1. Prepare some popcorn and soda.
2. Run xampp (windows 10 require run as administrator).
3. Make sure your app settings in `app.php` is well configured.
4. Open your browser and type `http://localhost/{your installation folder}`, hit enter.
5. Enjoy.

## Serve with php built-in server
1. Prepare some popcorn and soda.
2. Run cmd/terminal as administrator.
3. Open your app installation folder e.g. `cd C:\xampp\htdocs\{your installation folder}`, hit enter.
4. Make sure your app settings in `app.php` is well configured.
5. type `php -S {your computer local ip, e.g. 192.168.1.2}:{your port}`, hit enter (example: `php -S 192.168.1.2:8080`).
6. Open your browser and type `http://{your local ip}/`, hit enter.
7. Enjoy.

