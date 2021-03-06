# Assignment-2

Assignment 2 in [Programmering for Web 2](https://www.ntnu.no/studier/emner/IMT3851#tab=omEmnet) (IMT3851).

## Brief description of the project
An application that allows its users to provide fun news originating from both real and fake events.

## Instructions

#### Database setup

Open connect.php file in the includes folder and modify $db_hostname, $db_username and 
$db_password. You can now launch the setup.php file, and the database structure 
will be created.

#### Read articles

When entering the index.php page, you will see a summary of the most recent news. 
You have the option to search for news items or sort them by date or rating. 
Click on the news item to see the article. You may rate the article from 1-5.

#### Create articles

To be able to create articles, you must register an account. 
Functionality for validation for the registration fields is provided. 
This is done on the client- and server side. When you pass the validation, 
you'll be sent to the login page. When entering the index.php page again, 
there are some new options. You see all the default categories created. 
You can also create, edit and delete your own article. 
You can update your profile information.

#### Gain admin access

Logg in as admin user with username "Smash" and password "12345". 
The admin user has all of the same options as the members, 
but has also access to the admin panel. In the admin panel, 
you may delete other articles, create new categories, remove categories, remove users, 
and view all articles that are created.
