## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#setup)
* [Functionnalities](#functionnalities)
* [Other information](#other-information)

## General info
This project is a PHP Test for senior which get some random data from an online data generator API, store them into the database and show them in the homepage. Then, you can export these data into pdf file and you have a choice to send it via E-mail.
	
## Technologies
Project is created with:
* Symfony 5.2
* PHP 7.3.27
* Bootstrap 4.3.1 (also used bootswatch)
* JQuery 3.6.0
* Datatables 1.10.24
* Random-Data-Generator (random-data-api.com)
* mailtrap.io (email sandbox service)
* Dompdf 1.0.2 (for PDF exporting)
	
## Setup
To run this project, you must create the database first. You don't have to create script or import it manually. All you have to do is to 
start local apache server and SQL services, then run:

```
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate
```
And continue by typing "yes" after the confirmation

This will automatically create database "test" and table "student"

Then, run the symfony local server

```
$ php bin/console server:run
```
If unfortunately there will be an error saying that the server is missing or not found, just install it via composer:

```
$ composer require server --dev
```
When the server is ready(showing this information):

```
$ [OK] Server listening on http://127.0.0.1:8000
```

You can now open your browser and enter the specified URL (http://127.0.0.1:8000)

## Functionalities
First of all, when you come into the homepage, you will see a table with some or no data.
You can populate the database by clicking the "populate database" link in the navbar in the top of the page.
Then, it will load 50 random data from an online data generator API (http://random-data-api.com/).
It can takes a minute to load data depending on your internet connection so be patient and make sure you have a stable internet connection

There's a dynamic search box, some pagination and entries length with the datatable.

In the second option of the navbar, you can export stored data from the database into PDF format by clicking on the 'Export PDF', a pdf format document will be created showing the list of all student.

Finally, the last option which is "Send email" will prompt a modal with forms about sending email
These forms require:
* Sender email (From)
* Receiver email (To)
* Email subject
* Email content
* Email attachment

## Other information
To ensure that mail sending work correctly, a free Gmail account was created to sign in into mailtrap.io
So to check if mail sending is working properly, sign in into mailtrap.io with the these gmail account:
email: 'phptest2406@gmail.com'
password: 'phptest2021!'

Then check the inbox from http://mailtrap.io/inboxes