# 🎯 CI Futurebits

A CodeIgniter 4 project – Quick start guide for local development.

---

## 🚀 Quick Start

```bash
# 1️⃣ Clone the repository
git clone https://github.com/AyushWebTechs/ci_futurebits.git
cd ci_futurebits

# 2️⃣ Install dependencies
composer install

# 3️⃣ Setup environment
cp env .env

# ✏️ Edit .env for baseURL and database
# app.baseURL = 'http://localhost:8080/'
# database.default.hostname = localhost
# database.default.database = your_database_name
# database.default.username = your_db_user
# database.default.password = your_db_password
# database.default.DBDriver = MySQLi

# 4️⃣ Create the database (matching .env)

# 5️⃣ Run migrations
php spark migrate

# 6️⃣ Start development server
php spark serve
