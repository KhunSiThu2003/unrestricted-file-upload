Remote Code Execution 

## Unrestricted File Upload Lab

This is a small educational web application that focuses on **vulnerable** and **secure** file upload patterns.  
Authentication, profile pages, and navigation have been removed so that the lab is simple and centered only on file upload behavior.

### Stack

- **Backend**: PHP (no framework)
- **Database**: MySQL (used only for basic setup via `config.php`, not required by the upload endpoints themselves)
- **Frontend**: Tailwind CSS (via CDN) + vanilla JavaScript `fetch()`

### Features

- Single dashboard page showing:
  - A **vulnerable upload** flow
  - A **secure upload** flow
- **Vulnerable upload endpoint** (`upload_vulnerable.php`):
  - Accepts (almost) any file type
  - Keeps the original filename
  - Stores directly under `/uploads`
- **Secure upload endpoint** (`upload_secure.php`):
  - Enforces extension allow-list: `jpg`, `jpeg`, `png`
  - Validates MIME type with `finfo_file()`
  - Limits file size to 2MB
  - Randomizes stored filenames (e.g., `65abc123.png`)
  - Returns a JSON response with the stored path

### What this project is (attack type)

This project is mainly a demo of:

- **Unrestricted / insecure file upload** (primary)
- Which can lead to **arbitrary file upload** and **remote code execution (RCE)** if an attacker uploads a `.php` file that the web server executes.

### Prerequisites

- PHP 8+ with extensions: `pdo_mysql`, `fileinfo`
- MySQL/MariaDB credentials that can create a database  
  (the included `config.php` will auto-create the demo database)

### Setup (step by step)

1. **Configure database credentials (optional for uploads, required if you keep `config.php` as-is)**

   Edit `config.php` and set:

   ```php
   $db_host = 'localhost';
   $db_name = 'unrestricted_upload_db';
   $db_user = 'root';
   $db_pass = '';
   ```

   Notes:
   - `config.php` automatically creates the database and `users` table if missing.
   - Sessions are started from `config.php`, but there is no longer any login / profile logic.

2. **Start the PHP built-in server**

   From the project directory:

   ```bash
   php -S localhost:8000
   ```

3. **Open the app**

   Visit `http://localhost:8000`

   - You will land directly on the **Unrestricted File Upload Lab** dashboard (`pages/dashboard.php`).

### How to use the lab

1. **From the dashboard**
   - Click **“Try Vulnerable Upload”** to open `pages/vulnerable_upload.php`
   - Click **“Try Secure Upload”** to open `pages/secure_upload.php`

2. **Vulnerable upload flow**
   - Use the form on `pages/vulnerable_upload.php`
   - Upload any file (e.g. `.php`, `.exe`, `.txt`, etc., up to the size limit)
   - The endpoint `upload_vulnerable.php` will:
     - Save the file under `uploads/` with the original filename
     - Return JSON with `storedAs` (relative path under `uploads/`)
   - You can then access the uploaded file directly in the browser, for example:

     ```text
     http://localhost:8000/uploads/your_file_name.php
     ```

3. **Secure upload flow**
   - Use the form on `pages/secure_upload.php`
   - Upload a `.jpg/.jpeg/.png` (max 2MB)
   - The endpoint `upload_secure.php` will:
     - Validate extension and MIME type
     - Enforce max size
     - Save the file under `uploads/` with a randomized filename
     - Return JSON with `storedAs` (relative path under `uploads/`)

### Endpoints / important files

- **Entry point**: `index.php` → `pages/dashboard.php`
- **Dashboard (visual demo)**: `pages/dashboard.php`
- **Vulnerable upload UI**: `pages/vulnerable_upload.php`
- **Secure upload UI**: `pages/secure_upload.php`
- **Vulnerable upload API**: `upload_vulnerable.php`
- **Secure upload API**: `upload_secure.php`
- **Uploads folder**: `uploads/` (created automatically if missing)
- **Shared layout**:
  - `components/header.php`
  - `components/footer.php`

### Security Notes

The **vulnerable** endpoint intentionally skips important validations and keeps original filenames.  
It demonstrates how easy it is to introduce remote code execution if uploaded files are executed by the web server.

The **secure** endpoint demonstrates basic hardening:

- Treat all uploads as untrusted data
- Validate extension AND MIME type
- Limit file size
- Store files with randomized names

This project is for **training and demonstration** only and must not be deployed to production as-is.

