## PHP File Upload Security Demo

This is a small educational web application that demonstrates secure authentication and both **vulnerable** and **secure** file upload patterns.

### Stack

- **Backend**: PHP (no framework)
- **Database**: MySQL
- **Frontend**: Tailwind CSS (via CDN) + vanilla JavaScript `fetch()`

### Features

- Login and registration with `password_hash()` and `password_verify()`
- Authenticated dashboard page
- **Vulnerable upload endpoint**:
  - Accepts any file type
  - Keeps the original filename
  - Stores directly under `/uploads`
- **Secure upload endpoint**:
  - Enforces extension allow-list: `jpg`, `jpeg`, `png`
  - Validates MIME type with `finfo_file()`
  - Limits file size to 2MB
  - Randomizes stored filenames (e.g., `65abc123.png`)
  - Updates the user's `profile_image` in the database

Each page includes a short **Security Note** block that explains what is safe / unsafe about the implementation.

### What this project is (attack type)

This project is mainly a demo of:

- **Unrestricted / insecure file upload** (primary)
- Which can lead to **arbitrary file upload** and **remote code execution (RCE)** if an attacker uploads a `.php` file that the web server executes.

### Prerequisites

- PHP 8+ with extensions: `pdo_mysql`, `fileinfo`
- MySQL/MariaDB credentials that can create a database/table (or at least access them)

### Setup (step by step)

1. **Configure database credentials**

   Edit `config.php` and set:

   ```php
   $db_host = 'localhost';
   $db_name = 'unrestricted_upload_db';
   $db_user = 'root';
   $db_pass = '';
   ```

   Notes:
   - `config.php` automatically creates the database and `users` table if missing.
   - Sessions are started from `config.php`.

2. **Start the PHP built-in server**

   From the project directory:

   ```bash
   php -S localhost:8000
   ```

3. **Open the app**

   Visit `http://localhost:8000`

4. **Register and login**

   - Register a new account
   - Login to reach the dashboard

### How to use (normal flow)

1. **Login**
2. **Go to dashboard**
3. **Try the two upload buttons**
   - **Upload (Vulnerable)** posts to `upload_vulnerable.php`
   - **Upload (Secure)** posts to `upload_secure.php`
4. **(Secure upload) Set profile image**
   - Upload a `.jpg/.jpeg/.png` (max 2MB)
   - The server saves it under `uploads/` with a randomized filename
   - The DB column `users.profile_image` is updated

### Endpoints / important files

- **Login / Register page**: `index.php` → `pages/index.php`
- **Dashboard**: `dashboard.php` → `pages/dashboard.php`
- **Vulnerable upload**: `upload_vulnerable.php`
- **Secure upload**: `upload_secure.php`
- **Uploads folder**: `uploads/` (created automatically if missing)

### Attack demo files (`attack_file/`) and when to update them

The `attack_file/` folder contains **example attacker payload scripts** (for training only). These are PHP files you can use to demonstrate what happens when a server allows uploading executable scripts.

Current files:

- `attack_file/get_users.php`: reads users from the database and displays them
- `attack_file/read_file.php`: reads arbitrary files under the project directory (path traversal-style file read)
- `attack_file/folder_structure.php`: prints a directory tree

#### When you should update files in `attack_file/`

Update `attack_file/*` when:

- You want to demonstrate a **different payload** (e.g., show DB dump vs. file read vs. directory listing)
- Your DB credentials or project path assumptions changed (these payloads may use hard-coded connection info / paths)
- You want the payload to work on another machine/environment (different DB host/user/pass)

#### How to use `attack_file/` (step by step attack simulation)

1. **Log in**
2. **Open dashboard**
3. **Use “Upload (Vulnerable)”**
4. **Upload one file from `attack_file/`**
   - Example: upload `attack_file/read_file.php`
5. **Access the uploaded file under `/uploads/`**
   - If the vulnerable endpoint stores it as-is, you can browse to something like:
     - `http://localhost:8000/uploads/read_file.php`
6. **Interact with the payload**
   - Example for `read_file.php`:
     - `http://localhost:8000/uploads/read_file.php?file=config.php`

Important:
- This works **only** because the vulnerable endpoint stores attacker-controlled files in a web-accessible directory and does not restrict executable types.
- This project is for **education only**. Do not deploy it publicly.

### Security Notes

The **vulnerable** endpoint intentionally skips all validations and keeps original filenames. It shows how easy it is to introduce remote code execution if uploaded files are executed by the web server.

The **secure** endpoint demonstrates basic hardening:

- Treat all uploads as untrusted data
- Validate extension AND MIME type
- Limit file size
- Store files with randomized names
- Store paths in the DB instead of user-controlled data

This project is for **training and demonstration** only and must not be deployed to production as-is.

