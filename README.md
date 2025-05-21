# Social Ads Digital - Laravel Website

Professional digital marketing agency website built with Laravel.

🔗 **Live Site**: [https://www.socialadsdigital.com/](https://www.socialadsdigital.com/)

## Features

- Client management system
- Portfolio showcase
- Contact request handling
- Blog/insights section
- About Us and Services pages

## Architecture

### Layers
- **Controllers**: Handle HTTP requests
- **Services**: Business logic (`ClientService`)
- **Repositories**: Database access (`ClientRepository`)
- **Models**: Data structure (`Client`)

### Patterns
- Service-Repository pattern
- Dependency Injection
- Interface-based development

## Requirements

- PHP 8.1+
- MySQL 8.0+
- Composer 2.0+
- Node.js 16+

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/social-ads-digital.git
   cd social-ads-digital