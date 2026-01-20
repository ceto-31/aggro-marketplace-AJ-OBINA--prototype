# SPUP Agro Marketplace

A web-based rice trading platform designed for St. Paul University Philippines (SPUP) to connect rice farmers with buyers in Tuguegarao City, Cagayan. The system promotes price transparency and fair market access while supporting users with low digital literacy.

## Project Overview

This marketplace platform serves three distinct user roles:
- **SPUP Administrators** - Manage users, validate sellers, and monitor system activities
- **Sellers (Rice Farmers)** - Create and manage rice listings, fulfill orders
- **Buyers** - Browse available rice, place orders, and provide feedback

The system emphasizes simplicity and transparency, making it accessible to farmers and buyers who may have limited experience with digital platforms.

## Technology Stack

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Blade templates with custom CSS
- **Architecture**: MVC (Model-View-Controller)
- **Authentication**: Laravel's built-in authentication system

## System Requirements

- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer
- WAMP/XAMPP/Laravel Valet (for local development)

## Installation Guide

### 1. Clone the Repository

```bash
git clone https://github.com/ceto-31/aggro-marketplace-AJ-OBINA--prototype.git
cd aggro-marketplace-AJ-OBINA--prototype
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

Configure your database connection in `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agro_marketplace
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Seed Initial Data

```bash
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=TestDataSeeder
```

This creates the admin account and sample test data (2 sellers with rice listings, 2 buyers).

### 7. Create Storage Link

```bash
php artisan storage:link
```

### 8. Start Development Server

```bash
php artisan serve
```

Visit http://127.0.0.1:8000 in your browser.

## Default Login Credentials

### Administrator
- Email: `admin@spup.edu.ph`
- Password: `admin123`

### Test Sellers
- Email: `juan@seller.com` / Password: `password`
- Email: `maria@seller.com` / Password: `password`

### Test Buyers
- Email: `pedro@buyer.com` / Password: `password`
- Email: `anna@buyer.com` / Password: `password`

## Key Features

### Administrator Module

Administrators have full system oversight with the ability to:

- Create and manage user accounts internally
- Validate seller registrations before they can list products
- Activate or deactivate user accounts as needed
- View all rice listings and transaction history
- Generate reports on seller activity, buyer activity, and rice pricing trends
- Monitor system logs for security and audit purposes

**Important**: Administrator accounts cannot self-register. They must be created by existing administrators through the admin panel.

### Seller Module

Rice farmers who register as sellers go through an approval process:

- Registration requires admin approval before access is granted
- Create rice listings with variety name, price per kilo, quantity, and location
- Rice types are entered freely to match local varieties (e.g., "C-18", "Dinorado")
- Update inventory levels as stock changes
- Manage orders through a multi-step workflow
- Maintain profile with barangay and municipality information

**Order Management Flow for Sellers**:
1. View incoming orders (pending status)
2. Confirm or cancel the order
3. Mark as preparing (optional)
4. Mark as delivered when order is fulfilled
5. Mark as completed when transaction is done

### Buyer Module

Buyers can register directly and start browsing immediately:

- Browse all available rice listings from verified sellers
- Filter by rice type, barangay, or municipality
- Sort sellers by lowest price for price comparison
- View seller details including location and available stock
- Place orders with delivery address and contact information
- Track order status through each stage
- Submit star ratings and comments after order completion

**Order Status for Buyers**:
- Pending Approval - Waiting for seller to confirm
- Confirmed - Seller has accepted the order
- Preparing - Order is being prepared for delivery
- Delivered - Order has been delivered
- Completed - Transaction finished, feedback can be submitted
- Cancelled - Seller could not fulfill the order

## Registration Rules

This is an important distinction in the system:

- **Sellers and Buyers**: Can self-register through the registration page
- **Administrators**: Cannot self-register. Must be created by existing admins

Seller registrations are placed in "pending" status and require administrator approval before they can create listings. This validation step ensures only legitimate rice farmers can sell on the platform.

Buyer registrations are immediately approved, allowing them to browse and purchase right away.

## Design Guidelines

The user interface follows a specific color scheme to maintain SPUP branding:

- **50% Green** - Primary actions, headers, navigation, buttons
- **30% White** - Backgrounds, cards, spacing
- **20% Black** - Text content, borders, contrast elements

The design intentionally avoids:
- Excessive bold text formatting
- Complex navigation patterns
- Technical jargon in user-facing content
- Dense information displays

This approach makes the system more accessible to users with varying levels of digital literacy.

## Database Structure

### Core Tables

**users** - Stores all user accounts with role (admin/seller/buyer) and status
**seller_buyer_profiles** - Extended profile information including location and ratings
**rice_listings** - Product listings created by sellers
**orders** - Purchase transactions between buyers and sellers
**feedback** - Ratings and comments from buyers to sellers
**system_logs** - Activity logs for audit and monitoring

### Relationships

- A User can have one Profile
- A Seller (User) has many Rice Listings
- A Buyer (User) has many Orders
- A Seller (User) receives many Orders
- An Order belongs to one Rice Listing
- An Order can have one Feedback entry

## Development Process

This project was built incrementally following Laravel best practices:

1. **Database Design** - Created migrations with proper field types and relationships
2. **Models** - Built Eloquent models with relationships and helper methods
3. **Authentication** - Implemented login/registration with role-based access control
4. **Middleware** - Created role middleware to protect routes by user type
5. **Controllers** - Developed controllers for each module following MVC structure
6. **Views** - Designed Blade templates with consistent styling and user experience
7. **Testing** - Seeded test data to validate functionality
8. **Version Control** - Committed progress at logical milestones

Each component was built with separation of concerns in mind. Business logic stays in models, request handling in controllers, and presentation in views.

## Future Enhancements

While the current system is functional, potential improvements could include:

- SMS notifications for order status updates
- Image uploads for rice listings (currently optional)
- Advanced search with price range filtering
- Seller performance analytics dashboard
- Buyer order history export
- Mobile-responsive design optimization

## Support and Maintenance

For issues or questions about this system:

- Check the system logs in the admin panel
- Review Laravel documentation for framework-specific questions
- Ensure database migrations are up to date
- Verify file permissions for storage and cache directories

## License

This project was developed as a prototype for St. Paul University Philippines.

## Contributors

Developed by: AJ Obina (ceto-31)
Email: anicetoakaajobina@gmail.com
Institution: St. Paul University Philippines

---

This system demonstrates a practical application of Laravel's MVC architecture for solving real-world problems in local agriculture markets. The focus on simplicity and transparency makes it suitable for communities where digital literacy may be limited but the need for fair market access is critical.
