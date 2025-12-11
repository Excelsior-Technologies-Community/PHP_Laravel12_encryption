# PHP_Laravel12_encryption
---

## Step 1: Install Laravel 12

Run the following command to create a new Laravel 12 project:

```bash
composer create-project laravel/laravel PHP_Laravel12_encryption "12.*"
```

**Explanation:**  
- This command creates a fresh Laravel project in a folder named `PHP_Laravel12_encryption`.  
- The `"12.*"` ensures that Laravel 12 is installed.

---

## Step 2: Navigate to the Project Directory

```bash
cd PHP_Laravel12_encryption
```

**Explanation:**  
- Move into the project directory to run artisan commands and manage the project.

---

## Step 3: Generate the Application Key

```bash
php artisan key:generate
```

**Explanation:**  
- This generates a new encryption key (APP_KEY) for your Laravel application.  
- The key is automatically updated in your `.env` file.

---

## Step 4: Verify the `.env` File

Open the `.env` file and check the APP_KEY:

```
APP_KEY=base64:P9r5RXnghdhnhohddh2HDhBkPGnbLClYiRLx02QG0V6Tw=
```

**Explanation:**  
- This key is used by Laravel to encrypt and decrypt data, such as passwords, API tokens, and other sensitive information.

---

## Step 5: Run the Development Server

```bash
php artisan serve
```

<img width="1130" height="595" alt="image" src="https://github.com/user-attachments/assets/4d866a59-203a-4e94-a95f-34accc44659f" />
<img width="894" height="244" alt="image" src="https://github.com/user-attachments/assets/bed986b7-2fac-4c8a-ac4c-856898d647a7" />

