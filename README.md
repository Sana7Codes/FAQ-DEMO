# 📌 FAQ Community Platform

A **web-based community platform** that allows users to contribute and search **Frequently Asked Questions (FAQs)** based on a comparative study article.

---

## 🌟 Features

- ✅ View FAQs dynamically loaded from an API.  
- 🔍 Search FAQs using a search bar.  
- ✏️ Contribute FAQs (Users can submit new questions & answers).  
- ⚡ Instant Updates (FAQs appear immediately without refresh).  
- 🖥️ Minimalist UI with a **card-based layout**.  
- 🔒 Secure Authentication with **hashed passwords**.  

---

## 🛠 Installation & Setup

### **1️⃣ Clone the Repository**
```bash
git clone https://github.com/Sana7Codes/FAQ-DEMO.git
cd FAQ-DEMO
```

### **2️⃣ Set Up the Backend (`server-article`)**
Navigate to the backend directory:
```bash
cd server-article
```

Configure the Database:  
Import the SQL dump file into MySQL:
```bash
mysql -u root -p < database/migrate.sql
```

Start the Local Server (Using XAMPP):  
- Place `server-article` inside `htdocs` and start **Apache + MySQL**.

### **3️⃣ Set Up the Frontend (`client-article`)**
Navigate to the frontend directory:
```bash
cd client-article
```
Open `home.html` in your browser.

---

## 📂 Folder Structure

```bash
FAQ-DEMO/
│── client-article/      # Frontend (HTML, CSS, JS)
│   ├── pages/           # Contains all .html pages
│   ├── styles/          # Contains stylesheets
│   ├── Js/              # Contains script.js
│
│── server-article/      # Backend (PHP API)
│   ├── api/v1/          # API endpoints
│   ├── database/        # Migrations & Seed files
│   ├── models/          # Database models
│   ├── connection/      # Database connection
│   ├── config.php       # Configuration file
│
└── README.md            # Project documentation
```

---

# 📡 API Documentation

## 🔹 Authentication API

### **Register a User**
**Endpoint:**  
`POST /api/v1/signup.php`

#### Request Body (JSON)
```json
{
  "username": "JohnDoe",
  "email": "john@example.com",
  "password": "securepassword"
}
```
#### Response (Success)
```json
{
  "message": "User registered successfully"
}
```
#### Response (Error)
```json
{
  "error": "Username already exists"
}
```

---

### **🔹 Login User**
**Endpoint:**  
`POST /api/v1/login.php`

#### Request Body (JSON)
```json
{
  "username": "JohnDoe",
  "password": "securepassword"
}
```
#### Response
```json
{
  "token": "generated_auth_token"
}
```

---

## 🔹 FAQ API

### **Get All FAQs**
**Endpoint:**  
`GET /api/v1/faq.php`

#### Response
```json
[
  {
    "id": 1,
    "question": "What is data science?",
    "answer": "Data science is the study of data to extract meaningful insights."
  }
]
```

---

### **Add a New FAQ**
**Endpoint:**  
`POST /api/v1/faq.php`

#### Request Body (JSON)
```json
{
  "question": "What is AI?",
  "answer": "AI stands for Artificial Intelligence."
}
```
#### Response
```json
{
  "message": "FAQ added successfully"
}
```

---

### **Search FAQs**
**Endpoint:**  
`GET /api/v1/faq.php?search=<query>`

#### Example:
```bash
GET /api/v1/faq.php?search=data
```
#### Response:
```json
[
  {
    "id": 1,
    "question": "What is data science?",
    "answer": "Data science is the study of data to extract meaningful insights."
  }
]
```

---

# 🚀 Deployment Guide (AWS)

### **1️⃣ Connect to Your AWS EC2 Instance**
```bash
ssh -i /path/to/project1-key.pem ubuntu@your-aws-dns
```

### **2️⃣ Install Required Packages**
```bash
sudo apt update
sudo apt install apache2 mysql-server php php-mysql libapache2-mod-php php-curl php-cli git
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### **3️⃣ Clone the Project**
```bash
cd /var/www/html
sudo git clone https://github.com/Sana7Codes/FAQ-DEMO.git
```

### **4️⃣ Configure Apache**
Open Apache config file:
```bash
sudo nano /etc/apache2/sites-enabled/000-default.conf
```
Set the DocumentRoot:
```apache
DocumentRoot /var/www/html/FAQ-DEMO/client-article
```
Restart Apache:
```bash
sudo systemctl restart apache2
```

### **5️⃣ Setup MySQL Database**
```bash
mysql -u root -p
CREATE DATABASE faq_demo;
EXIT;
mysql -u root -p faq_demo < /var/www/html/FAQ-DEMO/server-article/database/migrate.sql
```

### **6️⃣ Test the Deployed App**
Open `http://your-aws-dns/pages/home.html` in your browser.

---



