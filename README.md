# adyems — portfolio (PHP + MySQL)

A portfolio site with clean URLs (no `.php`) and an admin panel where every piece of text, project, skill, experience entry, link, and image can be edited.

## Run it locally (XAMPP)

1. Copy this folder into `C:\xampp\htdocs\` (for example `C:\xampp\htdocs\me`).
2. Start **Apache** and **MySQL** in the XAMPP Control Panel.
3. Check the database login in `includes/config.php`. The XAMPP default is user `root` with an empty password.
4. Open `http://localhost/me/install.php` once. It creates the `adyems_portfolio` database, all the tables, and the starter content.
5. **Delete `install.php`.**
6. Open the site at `http://localhost/me/` and the admin panel at `http://localhost/me/admin`.

**Default admin login:** username `admin`, password `admin123`. Change it right away under **Admin → Password**.

To run it without Apache, use PHP's built-in server:

```
C:\xampp\php\php.exe -S 127.0.0.1:8899 index.php
```

## URLs

| URL | Page |
|---|---|
| `/` | Home |
| `/project/{slug}` | Single project page |
| `/admin` | Dashboard |
| `/admin/content` | All site text, avatar upload, email, phone, WhatsApp, and social links |
| `/admin/projects` | Add, edit, or delete projects. Each project can have any number of optional links. |
| `/admin/skills` | Capability cards |
| `/admin/experience` | Work history |
| `/admin/messages` | Messages sent through the contact form |
| `/admin/password` | Change your password |

## Folder layout

```
index.php          front controller: every URL routes through here
.htaccess          URL rewriting (Apache needs mod_rewrite enabled)
install.php        one-time installer: delete it after you run it
includes/          config, database, helpers, auth (blocked from the web)
app/               controllers, views, admin (blocked from the web)
assets/            css, js, uploads/ (uploaded images go here)
```

## Deploying to shared hosting

1. Upload the folder contents to your web root.
2. Create a MySQL database in cPanel and put its details in `includes/config.php`.
3. Set `APP_DEBUG` to `false` in `includes/config.php`.
4. Visit `/install.php`, then delete the file.
5. Make sure `assets/uploads/` is writable so image uploads work.
