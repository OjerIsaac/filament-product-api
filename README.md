
# Filament Product API  

## Setup & Installation  

### **Clone the Repository**  
```bash
git clone git@github.com:OjerIsaac/filament-product-api.git
cd filament-product-api
```

### **Install Dependencies**  
```bash
composer install
npm install
```

### **Setup Environment**  
Copy the `.env.example` file and update environment variables:  
```bash
cp .env.example .env
php artisan key:generate
```

### **Setup Database**  
Edit `.env` with your database details, then run migrations & seeders:  
```bash
php artisan migrate --seed
```

### **Start the Application**  
```bash
php artisan serve
```

---

### **PHP Test**  
You can run test by running the command  
```bash
php artisan test --filter ProductTest
```
---

## **Filament Dashboard Login**  

- **URL**: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)  
- **Email**: `user.admin@filamentproduct.com`  
- **Password**: `123456`  

(You can change these in the database after/when seeding.)

---

## 📖 **API Documentation**  

This project uses **Scribe** for API documentation.  

- **Access the docs at**: [http://127.0.0.1:8000/docs](http://127.0.0.1:8000/docs)  
- **Regenerate API docs** (if needed):  
  ```bash
  php artisan scribe:generate
  ```

---