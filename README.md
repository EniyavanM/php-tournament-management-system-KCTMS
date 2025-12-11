# 📘 KCTMS – Inter KCT Tournament Management System
A web-based system built for managing the **Inter-KCT Sports Tournament**, supporting **player registration, team creation, scheduling, and match status tracking**.

## 📌 Features
### 👤 Player Module
- Player signup with secure password hashing  
- Login with session-based authentication  
- Session timeout & back-button security  
- Forgot Password (optional)

### 📝 Registration System
- Players register for tournaments  
- Admin reviews applications  
- Accepted players can create teams  

### 👫 Team Management
- Create team  
- View team details  
- Restriction: One team per sport  

### 🏆 Tournaments Module
- List of tournaments  
- Tournament images  
- Register button with validation  

### 📅 Match Scheduling
- Admin schedules matches  
- Players see match notifications  

### 🔐 Security Features
- Session authentication  
- No browser caching for login pages  
- Hashed passwords  
- SQL injection protection via prepared statements  

## 🏗️ Tech Stack
- **Frontend:** HTML, CSS, Bootstrap Icons  
- **Backend:** PHP 8  
- **Database:** MySQL (XAMPP)  
- **Server:** Apache  

## 📁 Project Structure
See the folder layout in the documentation.

## 🗄 Database Overview
Includes:
- `player`
- `tournament`
- `teams`
- `mreg_status`
- `scheduled_matches`

## 🔧 Installation
1. Clone repo  
2. Move to XAMPP htdocs  
3. Import DB  
4. Configure `conn_db.php`  
5. Run via `http://localhost/KCTMS`

## 🚀 Future Enhancements
- Admin dashboard  
- Email notifications  
- API support  

## 👨‍💻 Author
**Eniyavan M.**

