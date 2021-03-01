# Family Theatre
 Simple web app made with plain php, built for your home family theatre.
 This app doesn't require a database, instead this app will scan directories in the given symlink and depends on json file for the data of the movie. This app support both single movie file in a directory and a multi serial video.
 There are 2 types of folder recognized by this app. type 1 is `movie` where there is only one video in a directory, and then type 2 is `serial` where there is multi video in a directory. This app also supports multiple subtitle, currently works with `.vtt` only, so when you have a `.srt` subtitle file you can convert it [here](https://subtitletools.com/convert-to-vtt-online) and then fill the data in the `index.json` file in each directory.

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

# How to add movies
1. Make sure you already create a symlink to your video directory.
2. Copy movie_index.json to your movie directory.
3. Edit movie_index.json with notepad, right click on it > select `Open with...` > select `notepad` (or use any of your favorite text editor).
4. Fill the movie information (example included) then save it.
5. Google for the movie poster art and download it with format of `.jpg`. (optional but recommended) 

# How to add serials
1. Make sure you already create a symlink to your video directory.
2. Copy serial_index.json to your movie directory.
3. Edit movie_index.json with notepad, right click on it > select `Open with...` > select `notepad` (or use any of your favorite text editor).
4. Fill the serial information (example included) then save it.
5. Google for the serial poster art and download it with format of `.jpg`. (optional but recommended) 