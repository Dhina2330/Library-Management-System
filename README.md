# 📚 Library Management System

A simple and efficient **web-based Library Management System** built using **PHP, MySQL, HTML5, and CSS3**. The application helps manage books, library members, and book issue/return transactions through a centralized database.

## 🚀 Features

### 📊 Dashboard

* Displays total book copies
* Shows currently available books
* Displays total registered members
* Shows the number of currently issued books
* Provides quick actions for adding books, members, and issuing books

### 📖 Book Management

* Add new books
* View all books
* Edit book details
* Delete books
* Track total quantity and available copies
* Prevents issuing books when no copies are available
* Validates book quantity during updates

### 👥 Member Management

* Add new library members
* View registered members
* Edit member details
* Delete members
* Stores member name, email, and phone number
* Includes server-side email validation

### 🔄 Issue & Return Management

* Issue books to registered members
* Automatically sets a **14-day due date**
* Tracks issue date, due date, and return date
* Updates book availability automatically
* Marks books as **Issued** or **Returned**
* Restores available book count when a book is returned

### 🔒 Data Validation & Security

* Server-side form validation
* MySQLi prepared statements
* Parameter binding to help protect against SQL injection
* Prevents books from being issued when no copies are available
* Maintains accurate book availability during issue and return operations

---

## 🛠️ Technology Stack

| Technology              | Usage                                         |
| ----------------------- | --------------------------------------------- |
| **HTML5**               | Structure and frontend                        |
| **CSS3**                | Styling and responsive interface              |
| **PHP**                 | Server-side application logic                 |
| **MySQL / MariaDB**     | Database management                           |
| **MySQLi**              | Database connectivity and prepared statements |
| **Apache**              | Web server                                    |
| **XAMPP / WAMP / LAMP** | Local development environment                 |

---

## 📁 Project Structure

```text
library-management-system/
│
├── config.php
├── header.php
├── footer.php
├── index.php
│
├── books.php
├── add_book.php
├── edit_book.php
├── delete_book.php
│
├── members.php
├── add_member.php
├── edit_member.php
├── delete_member.php
│
├── transactions.php
├── issue_book.php
├── return_book.php
│
├── database.sql
│
└── css/
    └── style.css
```

---

## 🗄️ Database Structure

The project uses a database named:

```text
library_db
```

### Main Tables

#### 📚 `books`

Stores book information:

* `book_id`
* `title`
* `author`
* `isbn`
* `quantity`
* `available`
* `created_at`

#### 👥 `members`

Stores library member information:

* `member_id`
* `name`
* `email`
* `phone`
* `created_at`

#### 🔄 `transactions`

Stores book issue and return records:

* `transaction_id`
* `book_id`
* `member_id`
* `issue_date`
* `due_date`
* `return_date`
* `status`

---

## ⚙️ Installation and Setup

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/library-management-system.git
```

### 2. Move the Project to Your Web Server Directory

For **XAMPP**, move the project folder to:

```text
C:\xampp\htdocs\
```

Example:

```text
C:\xampp\htdocs\library-management-system\
```

### 3. Start XAMPP

Start the following services:

* Apache
* MySQL

### 4. Create the Database

Open **phpMyAdmin** and create a database:

```sql
CREATE DATABASE library_db;
```

### 5. Import the Database

Import the provided:

```text
database.sql
```

file into the `library_db` database.

### 6. Configure Database Connection

Update your database details in `config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'library_db');
```

### 7. Run the Application

Open your browser and visit:

```text
http://localhost/library-management-system/
```

---

## 📸 Application Modules

### 🏠 Dashboard

Provides an overview of:

* Total books
* Available copies
* Registered members
* Currently issued books

### 📚 Books

Manage the complete book catalogue with:

* Add
* View
* Edit
* Delete

### 👥 Members

Manage library member records and contact information.

### 🔄 Issue / Return

Issue books to members and mark transactions as returned while automatically updating book availability.

---

## 🧪 Testing

The application was manually tested across its core functionalities, including:

* Adding books
* Validating empty fields
* Adding members
* Email validation
* Issuing available books
* Preventing issue when copies are unavailable
* Returning books
* Updating book quantities
* Deleting books and members

### 🎯 Test Result

# 💯 100% PASS RATE

**8 / 8 functional test cases passed successfully.**

---

## 🔮 Future Enhancements

* 🔐 Admin and librarian login system
* 👤 Role-based access control
* ⏰ Automatic overdue book detection
* 💰 Fine calculation
* 🔍 Search and filter functionality
* 📧 Email or SMS due-date reminders
* 📌 Book reservation and waitlist system
* 📄 Pagination for large book and member records
* 📱 Improved mobile responsiveness

---

## 👨‍💻 Author

**Dhinakar R**

Computer Science and Engineering (Cyber Security) Student

---

## 📄 License

This project is created for **educational and learning purposes**.

---

### ⭐ If you like this project

Give this repository a **star ⭐** on GitHub!
