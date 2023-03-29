# Restaurant-Seating-System
With the use of PHP and MySQL, this program acts as a seating system for a restaurant that can be used to reserve and close reservations, edit table availability, and assign servers to tables

**_Want to see the website live? Here's the link_**: website link 

## Difficulties encountered and their solutions below 

### Project Difficulties: 

1) Connecting to the MySQL database in a secure and non-redundant way

2) Finding out which action the user wants to execute, as the same page allows for closing and reserving times, changing table availability, and assigning servers to tables

3) Catching incorrect data and reporting errors back to the user

4) Displaying the website live

### Solutions:

1) Creating a separate file containing the information needed to connect to the database

2) Using PHP POST request to determine which textbox is filled out and carrying on from there

3) The database can only be modified assuming the proper details were supplied. If this is not the case, an error message will be displayed

4) Hosting the website via an AWS EC2 instance

