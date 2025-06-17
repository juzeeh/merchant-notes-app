Laravel Vue Merchant Notes Application
A simple full-stack application for managing merchant notes built with Laravel backend and Vue.js frontend.

Features

View merchants and their notes
Add, edit, and delete notes for merchants
Responsive Vue.js frontend with TailwindCSS
RESTful API with Laravel backend

Prerequisites

PHP 8.1+
Composer
Node.js & NPM

Quick Start

Clone the repository:

bash : 
git clone https://github.com/juzeeh/merchant-notes-app.git

cd merchant-notes-app

Install dependencies:

bash : 
composer install
npm install

Setup Laravel:

bash
cp .env.example .env
php artisan key:generate

Start the application:

Terminal 1 - Laravel backend:
bash
php artisan serve
Terminal 2 - Vue frontend:
bash
npm run dev

Open your browser:

Application: http://127.0.0.1:8000

Usage

Open the application in your browser
Select a merchant to view their notes
Add new notes using the form
Edit or delete existing notes inline
