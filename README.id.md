# Family Theatre
 Web app sederhana dari php, ditulis untuk teater keluarga anda.
 Aplikasi ini tidak membutuhkan *database*, aplikasi ini akan men-scan direktori-direktori pada symlink dan dan bergantung pada berkas json untuk menyimpan data video. Aplikasi ini mendukung baik satu berkas video maupun banyak berkas dalam satu direktori.
 Ada 2 jenis direktori yang dikenal oleh aplikasi ini, yang pertama adalah `movie` dimana hanya ada satu video dalam sebuah direktori, dan yang kedua adalah `serial` dimana ada banyak video dalam satu direktori. Aplikasi ini juga mendukung lebih dari satu subtitle, saat ini hanya bisa menggunakan `.vtt` saja, jadi ketika anda mempunyai berkas subtitle `.srt` anda bisa mengkonversinya [disini](https://subtitletools.com/convert-to-vtt-online) dan kemudian mengisi data di berkas `index.json` di setiap direktori.

 *Baca dalam bahasa lain: [English](https://github.com/diolan12/family-theatre), [Indonesia](https://github.com/diolan12/family-theatre/blob/main/README.id.md)*

# Tangkapan layar
## Desktop
![desktop](https://github.com/diolan12/family-theatre/raw/main/res/Screenshot%202021-03-01%20090941.jpg)

## Mobile
![mobile](https://github.com/diolan12/family-theatre/raw/main/res/Image%202021-03-01%20at%2009.11.33.jpeg)

# Requirements
- Web server seperti Nginx, Apache (xampp, wamp)
- PHP
- Peramban (e.g. Chrome, Firefox, Safari, Edge)
- Jaringan wi-fi (opsional)

# Cara memasang (xampp - windows)
1. Make sure your web server app is already installed.
2. Clone this repository to your `htdocs` directory in your xampp folder.
3. Open Windows Explorer and point to your movies folder.
4. Click the uri bar on top, then copy the path.
5. Open terminal or cmd.exe as administrator in the app installation directory.
6. Type `php app link symlink={your path in clipboard}` (right click to paste), then hit enter.
    - e.g. `php app link symlink=D:\Videos\Movies`.
    - this command will print `Symlink created` with green text color.
7. Done, you can unlink the application with `php app unlink`.

# Cara menambahkan film atau serial
1. Make sure you already create a symlink to your video directory.
2. Type `php app index`, then hit enter to list all movie folders.
    - this command will print `[Movie Folder] (indexed / not indexed)(with poster / poster not exist)`.
    - this command will print `[Movie Folder] (indexed / not indexed)(with poster / poster not exist)`.
3. Type `php app index folder="{Movie Folder}" type={serial/movie}`, then hit enter.
    - e.g. `php app index folder="Avengers - Endgame" type=movie`.
    - replace **Movie Folder** with your desired folder name.
    - there are 2 types of known video type, first is `movie`, second is `serial`.
    - this will create an **index.json** file inside your **Movie Folder**.
4. Edit **`index.json`** with notepad, right click on it > select `Open with...` > select `notepad` (or use any of your favorite text editor).
5. Fill the video information (example included), then save it.
7. Done.

# Cara menambahkan poster
1. Make sure you already create a symlink to your video directory.
2. Google for the serial or movie poster art and download it with format of `.jpg` (optional but recommended),this will reduce load speed.
3. Move the downloaded poster art to your movie directory, rename it to `poster.jpg`.
4. Done.

# Cara menambahkan subtitle
1. Make sure you already create a symlink to your video directory.
2. Convert your `.srt` subtitle to `.vtt` [here](https://subtitletools.com/convert-to-vtt-online).
3. Place your `.vtt` subtitle in the same directory next to your serial video.
4. If you have more than one subtitle, repeat **step number 2 and 3**.
5. Edit **`index.json`** with notepad, right click on it > select `Open with...` > select `notepad` (or use any of your favorite text editor).
6. Fill the subtitle information (example included) then save it.
7. Done.

# Cara menjalankan aplikasi
## Jalankan dengan antarmuka baris-perintah dari aplikasi
1. Prepare some popcorn and soda.
2. Run cmd/terminal as administrator.
3. Open your app installation folder e.g. `cd C:\xampp\htdocs\{your installation folder}`, hit enter.
4. Make sure your app settings in `Config.php` is well configured.
5. type `php app serve addr={your computer local ip, e.g. 192.168.1.2} port={your port}`, hit enter.
    - e.g `php app serve addr=192.168.1.2 port=8080`.
    - default address is **localhost**.
    - default port is **2121**.
6. Open your browser and type `http://{your local ip}:{your port}/` in url bar, hit enter.
7. Enjoy.

# Antarmuka Baris-Perintah
Untuk menjalankan antarmuka baris-perintah bawaan, ketik `php app`.
Penggunaan: `php app {command} {arguments}`
## Daftar perintah-perintah:
- `help`                  : Display this help screen.
- `link {args}`           : Link application to video directory.
- `unlink`                : Unlink application from video directory.
- `version`               : Display application version.
- `status`                : Display application current status.
- `serve {args}`          : Serving the application.
- `index`                 : Showing list of indexed directories.
- `index {args}`          : Indexing a given directory name in argument, then showing list of indexed directories.
## Daftar argumen-argumen:
- `symlink={path}`        : Use with link command to link the application with video directory.
                          e.g. (php app link symlink=D:\Videos)
- `folder={dir name}`     : Use with index command to index a video directory.
- `type={video type}`     : Use with index command to index a video directory type.
                          e.g. (php app index folder="The Mandalorian - Season 2" type=serial)
- `addr={address}`        : Use with serve command to specify the server address (default: localhost).
                          e.g. (php app serve addr=192.168.1.2)
- `port={port}`           : Use with serve command to specify the server port (default: 2121).
                          e.g. (php app serve port=8080)

## Tips tambahan:
To serve this application just run this command:
    `php app serve addr={your.ip} port={your_port}`
Make sure you already link the video directory first, otherwise it will return error.
Replace the **your.ip** with your machine IP address and **your_port** with your desired unused port,
You can use port 80 when apache/nginx is not running.
You can not access this application from other devices when your default address
is localhost, use your machine IP address instead of localhost.