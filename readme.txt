# the challenge was broken down into steps as explained below

#step1: was creating a folder and adding the given json file

# step 2: creating the database schema :
 -I created it manually in my local workbench then I got the schema code using the command "Forward Engineer"
as shown as the schema.sql file.
 -based on the json file , my understanding for optmized saving was to use three tables Employees ,
  Events and Participations
# step 3 : Connecting the DB and check the connection = file db_connection.php
#step 4: 
-saving the data on the three tables by checking for each table if the record exist or no before inserting
-adjust the time zone based on the version condition
#step 5: the index.php file which splited into steps below:
- preparing the sql query to display the table by joining the three tables,
 as we have to see employee name and event/event date and participation_fee
-map the result data and creating a table line for each record 
-creating the filter form based on employee name, event name and database
- determine the total fees in the buttom of the table 
#step 5: adding some basic style

Conslusion : due to the limited time I did not separate the code into more files, 
 as my plan was to create separate files for queries , separate CSS file ... etc 
 I can say separate of concern did not respected as I used to do 