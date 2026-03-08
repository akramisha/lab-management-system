# Lab Management System

A web-based Lab Management System designed to streamline communication and workflow between patients, doctors, and laboratory administrators.
The system allows patients to book lab tests online, enables admins to manage appointments, and allows doctors to upload medical reports securely.

This project demonstrates a role-based healthcare workflow system built with modern web technologies.

# Features
## Patient

- Register and log in securely
- View available laboratory tests with details and pricing
- Book appointments for desired tests
- View appointment status
- Access uploaded test reports and results

## Admin

- Manage patient records
- Add and manage available lab tests
- View incoming appointment requests
- Assign doctors and appointment dates
- Maintain records of tests and reports
- Monitor system activity

## Doctor

- View assigned patient tests
- Upload test reports
- Manage patient test results

# System Workflow

- A patient registers and logs into the system.
- The patient browses available lab tests with pricing and details.
- The patient books an appointment for a selected test.
- The request is sent to the admin dashboard.
- The admin reviews the request and assigns a doctor and an appointment date.
- On the scheduled day, the patient provides a sample for the test.
- Once the test results are ready, the doctor uploads the report.
- Both the patient and admin can view the results through the system.

# Technologies Used

- Laravel – Backend framework
- PHP – Server-side programming
- MySQL – Database management
- HTML / CSS / JavaScript – Frontend interface
- Blade Templates – Laravel templating engine

## Project Objectives

- Automate manual lab management processes
- Improve coordination between patients, doctors, and administrators
- Maintain organised digital records of tests and reports
- Provide patients with easy access to their medical results

# Installation Guide

Clone the repository
`git clone https://github.com/yourusername/lab-management-system.git`

Navigate to the project folder
`cd lab-management-system`

Install dependencies
`composer install`

Configure the environment file
`cp .env.example .env`

Generate application key
`php artisan key:generate`

Configure the database in .env

- DB_DATABASE=lab_management
- DB_USERNAME=root
- DB_PASSWORD=

Run migrations
`php artisan migrate`

Start the server
`php artisan serve`

Open in browser:
`http://127.0.0.1:8000`
