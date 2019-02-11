# homeTemps
Website to display temperature data

****************************************************************
DESCRIPTION OF FILES IN REPOSITORY
****************************************************************
Screen Shot 2019-02-06 at 3.08.23 PM
- Just a picture of the "24 Hour" page, showing the highchart graph in action.

index.php
- Main starting point of website
- Currently the buttons across the bottom are not hooked up

styles/reset.css
styles/style.css
- Style pages blatently copied from other sources

js/app.js
- Contains java script to update clock displayed on top of page

php/db_config.php
- Contains the connection details for database

current_history.php<br>
current_history_data.php<br>
garage_history.php<br>
garage_history_data.php<br>
inside_history.php<br>
inside_history_data.php<br>
outside_history_data.php<br>
outside_history.php<br>
- Page & data retrieval for highcharts graphs

maps.html<br>
weather.html
- Test programs to work with google maps & open weather api's
- Currently not used, just playing with them

****************************************************************
CONCERNS AND QUESTIONS
****************************************************************
- I'm not too worried about minor css issues, but open to improvements.

- Website security - having the connection details isolated to php/db_config.php is the only way I found to keep them out of all the other php files.  Is this correct?

You can put those in a file that you upload to your server/pi but that the website doesn't serve up.  So db_config.php is okay as long as users cannot go to http://yourwebsite/db_config.php and invoke it.  You can also use .ini files in PHP.


- This seems to me a very convaluted way to design a website.  All of the child pages ('name'_history.php) and their corresponding data-retireval page ('name'_history_data.php) share most of the same code.  Column names change between them, and some labels, among other things.  What would a better way to accomplish this be?

Raw PHP can be very confusing and convoluted.  I typically don't recommend it, but it can be very easy, free and there are a lot of plugins that people use to make it simplier to work with.  That being said there are a lot of features in PHP.  Checkout the changes I made to index.php and /php/data_manager.php.  You can use classes to help consolidate your logic. This will make your code more reusable.  

Given this example you could have a single view "html section" that allows the user to pick indoor or garage.  It's the same data and the same view but a different parameter.  So using a dropdown via (https://stackoverflow.com/questions/6670002/php-get-dropdown-value-and-text)  You could get the value and then call the method in data_manager to getTempForLocation($location) then bind them to the same table.  You may need some data structures to help with your UI also.  Variables that hold label names.  Beyond this we get into patterns like MVC and url routing.


 - Since this is just available in my home network (not exposed to the internet) - if I wanted to have a button on the page insert a row into the database - should ajax be used?  Should this have been ajax based vs. php?


You'll have minimal home security concers, for the most part.  Though I highly recommend you change your password in your config file to some random string that's like 40 to 60 characters long.  Use a password manager tool to do this, but you want to make it impossible to guess and hard for a computer to generate trying from 0 to ...  If you have 0 need for it to have internet access I'd recommend blocking the device IP in your router so it cannot be accessed at all in/out.  There are some pretty interesting attacks where users take control of rPis connected to the web and then use them to do various "bad" things.  The vunerability doesn't have to be in your code FWIW.  

Also if your repo is public on Github then don't check in your password files.  Anyone can see them O_O.  You can add them to a .gitignore file so git never tries to check them in.

AJAX is async javascript.  The core concept is reloading data without the user page reloading or more specifically without the browser refreshing in order to send a new request to the server.  That's how PHP works, the page refreshes and a new request is made from the server.  You can use AJAX to call PHP.  It's more complicated but ultiamtely the same result.

You seem to have a good handle on things.  I'd definately suggest trying to turn all the inside/outside/garage pages into a single page that can get data with some UI concept like a drop down or radio next.  So you'd have something like 

history.php
index.php

only with the user picking the options they want.  Then based on their selection you render the table.  Then you could try replacing the _data files with methods in a php class so you don't need a .php file for each data set.  Hopefully that answers some questions and doesn't raise to many new ones.  I know I recommended trying PHP but you can use any framework that runs on linux, but this looks good for a first pass.

