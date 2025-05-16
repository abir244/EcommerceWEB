# FemVentures Ecommerce Platform

This is a simple ecommerce web application focused on empowering women entrepreneurs. Built with PHP, MySQL, HTML, CSS, and JavaScript, it allows users to explore products, register as sellers, and manage products.

## Features

- Public landing page with navigation
- Seller registration and dashboard (`seller_dashboard.php`)
- Product management (add, update, delete products)
- Marketplace page to browse products
- User authentication (login/signup pages)
- Responsive design

## Folder Structure

```
EcommerceWEB/
├── addproduct.php
├── seller_dashboard.php
├── publicpage.html
├── marketplace.html
├── about.html
├── signup.html
├── loginpage.html
├── style.css
├── images/
│   └── (product and seller images)
└── ...
```

## Getting Started

1. **Install XAMPP** and start Apache and MySQL.
2. **Clone or copy** this project to `htdocs` (e.g., `d:\xammp\htdocs\EcommerceWEB`).
3. **Create the database** in phpMyAdmin:
    - Database name: `ecommerce`
    - Run these SQL queries:

    ```sql
    CREATE TABLE products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        description TEXT NOT NULL
    );

    CREATE TABLE sellers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        shop VARCHAR(255) NOT NULL
    );
    ```

4. **Access the site** in your browser:
    ```
    http://localhost/EcommerceWEB/publicpage.html
    ```

## Usage

- **Join as a Seller:** Click "Join as a Seller" to register and manage your products.
- **Explore Marketplace:** Browse products on the marketplace page.
- **Admin/Product Management:** Use `addproduct.php` to add or manage products (for admin/demo).

## Customization

- Add your own images to the `images/` folder and update the `src` attributes in HTML.
- Edit `style.css` for custom styles.

## License

This project is for educational/demo purposes.

---
