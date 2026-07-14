# Installation Guide

1. Install XAMPP or Apache + PHP 8 and MySQL.
2. Clone the repo into your web root (e.g., htdocs/shadowmarket).
3. Import the SQL: mysql -u root -p < sql/schema.sql
4. Update database config in app/config/config.php with your DB user/password.
5. Ensure public/ is the web root (or use .htaccess above to route requests to public/index.php).
6. Set writable permissions on public/uploads or storage directories.
7. Visit http://localhost/ to see the site. Demo admin: admin@example.com / AdminPass123

This project is a prototype. For production, configure HTTPS, real SMTP, and Stripe/PayPal keys.
