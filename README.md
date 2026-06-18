# 📚 Course Material Management System

A comprehensive web-based Course Material Management System built with **Laravel 11**, **Blade Templates**, **Bootstrap 5**, and **MySQL**. This system allows lecturers and administrators to upload, manage, and share course materials while enabling students to easily browse, search, and download documents.

---

## 🚀 Features

- **📤 Upload Documents** - Upload course materials in PDF, DOC, DOCX, PPT, PPTX, and ZIP formats
- **👁️ View Documents** - Browse all uploaded documents in a clean, responsive card layout
- **🔍 Search Documents** - Search by title or course code
- **🏷️ Filter by Course** - Filter documents by course code using a dropdown
- **📥 Download Files** - One-click download of any document
- **🗑️ Delete Documents** - Remove documents with confirmation modal
- **📱 Responsive Design** - Fully responsive interface built with Bootstrap 5
- **📄 Pagination** - Paginated document listing (10 per page)
- **🎯 File Type Icons** - Visual file type indicators with Bootstrap Icons
- **📊 File Size Formatting** - Human-readable file sizes (KB/MB)
- **⚡ Drag & Drop Upload** - Intuitive drag-and-drop file upload interface
- **✅ Validation** - Server-side validation for file types and sizes

---

## 🛠️ Tech Stack

| Technology | Purpose |
|------------|---------|
| **Laravel 11** | Backend PHP Framework |
| **Blade Templates** | Frontend Templating Engine |
| **Bootstrap 5** | CSS Framework for Styling |
| **Bootstrap Icons** | Icon Library |
| **MySQL** | Database Management |
| **Laravel Storage** | File Management |

---

## 📋 Requirements

- PHP >= 8.2
- Composer
- MySQL >= 5.7 or MariaDB >= 10.3
- Node.js & NPM (for asset compilation, optional)
- Web Server (Apache/Nginx) or Laravel Artisan Serve

---

## 🔧 Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/yourusername/course-material-manager.git
cd course-material-manager
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Environment Configuration

```bash
cp .env.example .env
```

Update the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=course_materials
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Generate Application Key

```bash
php artisan key:generate
```

### Step 5: Create Database

Create a MySQL database named `course_materials`:

```sql
CREATE DATABASE course_materials CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 6: Run Migrations

```bash
php artisan migrate
```

### Step 7: Create Storage Link

```bash
php artisan storage:link
```

### Step 8: Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 📁 Project Structure

```
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── DocumentController.php
│   └── Models/
│       └── Document.php
├── config/
│   └── database.php
├── database/
│   └── migrations/
│       └── xxxx_xx_xx_xxxxxx_create_documents_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       └── documents/
│           ├── index.blade.php
│           └── create.blade.php
├── routes/
│   └── web.php
├── storage/
│   └── app/
│       └── public/
│           └── documents/
└── README.md
```

---

## 📖 Usage

### Uploading a Document

1. Click **"Upload"** in the navigation bar
2. Fill in the document title, course code, and optional description
3. Click the upload area or drag and drop a file
4. Click **"Upload Document"** to submit

### Browsing Documents

- The home page displays all uploaded documents in card format
- Each card shows: file icon, title, course code badge, file type, file size, and upload date
- Use the **Download** button to save files
- Use the **Delete** button (with confirmation) to remove documents

### Searching and Filtering

- Use the **search bar** to find documents by title or course code
- Use the **course code dropdown** to filter by specific courses
- Both search and filter can be used together

---

## 📸 Screenshots

> Screenshots will be added here. Add your own screenshots to a `screenshots` directory.

| Page | Description |
|------|-------------|
| Home Page | Document listing with search and filter |
| Upload Page | Document upload form with drag & drop |
| Delete Modal | Confirmation dialog before deletion |

---

## 🔄 API Routes

| Method | URI | Action | Route Name |
|--------|-----|--------|------------|
| GET | `/` | `index()` | `documents.index` |
| GET | `/upload` | `create()` | `documents.create` |
| POST | `/upload` | `store()` | `documents.store` |
| GET | `/documents/{id}/download` | `download()` | `documents.download` |
| DELETE | `/documents/{id}` | `destroy()` | `documents.destroy` |

---

## 🗄️ Database Schema

### `documents` Table

| Column | Type | Description |
|--------|------|-------------|
| `id` | BIGINT (PK) | Primary key |
| `title` | VARCHAR(255) | Document title |
| `course_code` | VARCHAR(50) | Course code |
| `description` | TEXT (nullable) | Optional description |
| `file_name` | VARCHAR(255) | Original file name |
| `file_path` | VARCHAR(255) | Storage path |
| `file_size` | INTEGER | File size in bytes |
| `file_type` | VARCHAR(50) | File extension |
| `created_at` | TIMESTAMP | Upload date |
| `updated_at` | TIMESTAMP | Last update |

---

## ✅ File Validation

- **Allowed Types:** PDF, DOC, DOCX, PPT, PPTX, ZIP
- **Maximum Size:** 10MB (10,240 KB)
- **Required Fields:** Title, Course Code, File

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is open-source and available under the [MIT License](LICENSE).

---

## 📦 GitHub Push Instructions

```bash
# Initialize Git repository
git init

# Add all files
git add .

# Create initial commit
git commit -m "Initial commit: Course Material Management System"

# Add remote repository
git remote add origin https://github.com/yourusername/course-material-manager.git

# Push to GitHub
git push -u origin main
```

---

## 👨‍💻 Author

**Course Material Manager** - Built with Laravel 11, Bootstrap 5, and MySQL.

For questions or support, please open an issue on the GitHub repository.