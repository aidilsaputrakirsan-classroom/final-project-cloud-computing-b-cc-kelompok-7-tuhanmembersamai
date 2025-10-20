## Application Requirements
Aplikasi yang akan dibangun adalah sistem manajemen konten sederhana dengan fitur:
- User authentication dan authorization
- Manajemen artikel/posts dengan kategori
- Sistem komentar untuk setiap post


## Entity Relationship Design


### 1. Users Table
- Primary entity untuk authentication
- Menyimpan informasi dasar user
- Relationship: One-to-Many dengan Posts, History Respon


### 2. Categories Table  
- Kategorisasi utama untuk posts
- Relationship: One-to-Many dengan Posts


### 3. Posts Table
- Content utama aplikasi
- Memiliki status publication (draft, published, archived)
- Relationship: Many-to-One dengan Users, Categories
- Relationship: One-to-Many dengan History Respons
- Relationship: Many-to-Many dengan Tags


### 4. History Respon Table
- Sistem komentar untuk posts
- Support nested comments dengan parent_id
- Relationship: Many-to-One dengan Users, Posts


## Database Constraints
- Foreign key constraints untuk referential integrity
- Unique constraints untuk email
- Index untuk performance optimization
- Soft deletes untuk data preservation