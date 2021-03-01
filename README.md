# Family Theatre
 Simple web app made with plain php, built for your home family theatre.
 This app doesn't require a database, instead this app will scan directories in the given symlink and depends on json file for the data of the movie. This app support both single movie file in a directory and a multi serial video.
 There are 2 types of folder recognized by this app. type 1 is `movie` where there is only one video in a directory, and then type 2 is `serial` where there is multi video in a directory. This app also supports multiple subtitle, currently works with `.vtt` only, so when you have a `.srt` subtitle file you can convert it [here](https://subtitletools.com/convert-to-vtt-online) and then fill the data in the `index.json` file in each directory.

# Screenshots
## Desktop
![desktop](https://github.com/diolan12/family-theatre/raw/main/res/Screenshot%202021-03-01%20090941.jpg)

## Mobile
![mobile](https://github.com/diolan12/family-theatre/raw/main/res/Image%202021-03-01%20at%2009.11.33.jpeg)

# Requirements
- Web server software e.g. Nginx, Apache (xampp, wamp)
- PHP
- Browsers (e.g. Chrome, Firefox, Safari, Edge)
- Wifi network (optional)

# How to install (xampp - windows)
1. Make sure your web server app is already installed.
2. Clone this repository to your `htdocs` directory in your xampp folder.
3. Open Windows Explorer and point to your movies folder.
4. Click the uri bar on top, then copy the path.
5. Open terminal or cmd.exe as administrator in the app installation directory.
6. Type `php app link symlink={your path in clipboard}` (right click to paste), then hit enter.
    - e.g. `php app link symlink=D:\Videos\Dummy\Avengers - Endgame`.
    - this command will print `Symlink created` with green text color.
7. Done, you can unlink the application with `php app unlink`.

# How to add movies or serials
1. Make sure you already create a symlink to your video directory.
2. Type `php app index`, then hit enter to list all movie folders.
    - this command will print `[Movie Folder] (indexed / not indexed)(with poster / poster not exist)`.
        - this command will print `[Movie Folder] (indexed / not indexed)(with poster / poster not exist)`.
3. Type `php app index folder="{Movie Folder}" type={serial/movie}`, then hit enter.
    - e.g. `php app index folder="Avengers - Endgame" type=movie`.
    - replace Movie Folder with your desired folder name.
    - there are 2 types of known video type, first is `movie` or `serial`.
    - this will create a **index.json** file inside your Movie Folder.
4. Edit **`index.json`** with notepad, right click on it > select `Open with...` > select `notepad` (or use any of your favorite text editor).
5. Fill the video information (example included), then save it.
7. Done.

# How to add poster
1. Make sure you already create a symlink to your video directory.
2. Copy **`serial_index.json`** to your movie directory.
3. Google for the serial or movie poster art and download it with format of `.jpg` (optional but recommended),this will reduce load speed.
4. Move the downloaded poster art to your movie directory, rename it to `poster.jpg`.
5. Done.

# How to add subtitles
1. Make sure you already create a symlink to your video directory.
2. Convert your `.srt` subtitle to `.vtt` [here](https://subtitletools.com/convert-to-vtt-online).
3. Place your `.vtt` subtitle in the same directory next to your serial video.
4. If you have more than one subtitle, repeat **step number 2 and 3**.
5. Edit **`index.json`** with notepad, right click on it > select `Open with...` > select `notepad` (or use any of your favorite text editor).
6. Fill the subtitle information (example included) then save it.
7. Done.

# How to serve
## Serve with app cli
1. Prepare some popcorn and soda.
2. Run cmd/terminal as administrator.
3. Open your app installation folder e.g. `cd C:\xampp\htdocs\{your installation folder}`, hit enter.
4. Make sure your app settings in `Config.php` is well configured.
5. type `php app serve addr={your computer local ip, e.g. 192.168.1.2} port={your port}`, hit enter.
    - e.g `php app serve addr=192.168.1.2 port=8080`.
    - default address is localhost.
    - default port is 2121.
6. Open your browser and type `http://{your local ip}/` in url bar, hit enter.
7. Enjoy.

