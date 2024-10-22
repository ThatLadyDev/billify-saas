# Billify SaaS

## Overview

**Billify SaaS** is a multi-tenant billing microservice designed to handle subscription management, invoicing, and payment processing for a Software as a Service (SaaS) application. This microservice integrates with the **AuthoSaaS** microservice to retrieve tenant information and ensure proper billing workflows.

## Features

- **Subscription Management**: Create and manage subscriptions for tenants.
- **Invoicing**: Generate invoices based on subscriptions.
- **Payment Processing**: Process payments linked to invoices.

## Getting Started

Prerequisites
- PHP 8.x
- Laravel 9.x
- Composer
- Database (MySQL, PostgreSQL, etc.)

### Installation

1. **Clone the repository:**

   ```
   git clone https://github.com/your-username/billify-saas.git
   cd billify-saas
   ```
2. **Install dependencies:**

   ```
   composer install
   ```
3. **Set up your environment:**

   ```
   cp .env.example .env
   ```
4. **Generate the application key:**

   ```
   php artisan key:generate
   ```

## Architecture

This microservice follows a microservices architecture, allowing for scalability and modularity. The main components are:

- **AuthoSaaS**: Handles user authentication and authorization.
- **Billify SaaS**: Manages billing workflows, including subscriptions, invoices, and payments.

### Workflow

The billing process consists of three main steps, each handled by a separate endpoint:

1. **Create Subscription**: 
   - Endpoint: `POST /api/subscriptions`
   - Description: Creates a new subscription for a tenant.
   
2. **Create Invoice**: 
   - Endpoint: `POST /api/invoices`
   - Description: Generates an invoice for the newly created subscription.

3. **Process Payment**: 
   - Endpoint: `POST /api/payments`
   - Description: Processes the payment for the generated invoice.

### Technical Workflow

The workflow for billing involves the following steps:

1. **Create Subscription**
   - The frontend collects necessary data (like `tenant_id` and `plan_id`) and sends a request to the `/api/subscriptions` endpoint.
   - Upon successful creation, the backend returns the subscription details.

2. **Create Invoice**
   - Using the `subscription_id`, the frontend calls the `/api/invoices` endpoint to create an invoice linked to the subscription.
   - The backend returns the invoice details.

3. **Process Payment**
   - The frontend calls the `/api/payments` endpoint using the `invoice_id` to process the payment.
   - The backend updates the invoice status to "paid" upon successful processing.

## API Endpoints

### 1. Create Subscription

- **Method**: `POST`
- **Endpoint**: `/api/subscriptions`
- **Request Body**:
  ```json
  {
      "tenant_id": "string",
      "plan_id": "string"
  }
- **Response**: 
  ```json
  {
      "subscription_id": "string",
      "status": "active"
  }

### 2. Create Invoice

- **Method**: `POST`
- **Endpoint**: `/api/invoices`
- **Request Body**:
  ```json
  {
      "subscription_id": "string"
  }
- **Response**: 
  ```json
  {
      "invoice_id": "string",
      "amount": "number",
      "status": "pending"
  }

### 3. Process Payment

- **Method**: `POST`
- **Endpoint**: `/api/payments`
- **Request Body**:
  ```json
  {
      "invoice_id": "string",
      "payment_method": "string"
  }
- **Response**: 
  ```json
  {
      "payment_id": "string",
      "status": "successful"
  }
