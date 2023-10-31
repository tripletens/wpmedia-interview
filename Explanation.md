# Explanation.md

## The Problem to be Solved in My Own Words

So the problem is that we need to get access to all the links connected to the home pages so as to improve the SEO by creating a sitemap where Google crawlers and other crawlers can be able to index the web pages appropriately. This is a way to improve the ranking of the web page on Google search. The admin is trying to get more insight into the number of pages and the links to the pages on the home page, generate a sitemap and also make use of it in other analytics where possible.

## A Technical Specification of Your Design, Explaining How It Works

### SETUP
To install and set up the project, follow these steps:

1. Clone the project from the GitHub repository.
   ```shell
   git clone https://github.com/tripletens/wpmedia-interview.git
   ```
   - Navigate to the project directory.
   ```shell
    cd wpmedia-interview
   ```
   - Install project dependencies using Composer.
   ```shell 
   composer install 
   ```
   - Create a copy of the .env.example file and name it .env. Update the configuration settings such as the database connection information in the .env file.
   - Generate a new application key.
   ```shell 
   php artisan key:generate
   ```
   - Add your database name and other credentials 
   - Run database migrations to set up the database schema.
   ```shell 
   php artisan migrate
   ```
   - Seed the database with initial data.
   ```shell 
   php artisan db:seed
   ```
   - compile your css / tailwind packages 
   ```shell 
    npm run dev
   ```
   - Start the Laravel development server.
   ```shell 
        php artisan serve
    ```
    > **<span style="color:red;">Important:</span> i added my test news credentials intentionally so you can use it for testing.**


### TECHNOLOGIES USED

- Laravel 10
- Tailwind CSS
- PHP 8.1
- Laravel Breeze
- Spatie Permission Library
- Goutte Crawling Library
- Guzzle

### PROCESS DESIGN

#### Dynamic page lists

We have the landing pages that hold a list of news details. I was trying to create a dynamic list of pages within the application, and since it's a small application, I decided to make use of https://newsapi.org news endpoint to generate such links with the help of Guzzle. These links hold all the “assumed page dynamic links in the application,” and hence the process for home page analysis starts.

#### Authentication

The application holds an authentication for only admins. I specifically added a role/permission feature for the application and assigned the admin role to all registered users. This is because the application’s dashboard is only to be used by the admin for analysis purposes. Spatie Permission Library was used for the role/permission feature.

#### Crawling Process

For the crawling, I used Goutte crawling library to fetch all the “a” HTML tags and the href links attached to each of them. In my Dashboard controller, I have some functions, namely:

- Index: This returns the dashboard blade.php view for the user.
- Analyse_links: This is like the engine of the crawling process because it holds all the processes of the crawling. The processes include:
  - Try catch exception is used to handle any errors that might occur when trying to run the function as a last resort. Errors such as 5**, 4** errors, etc.
  - I actually used the environment variable (“APP_URL”) to fetch the application’s URL.
  - I initially created a form with an input where the admin put the page URL that he/she wants to fetch/analyze the sitemap. Then later changed my mind and hid the input field and left the validation there. This is to keep that option open should it be considered in the nearest future as the application grows.
  - After the home page URL has been fetched from my .env file, I created random string characters as code to track a specific crawling process. i.e., each crawling process is identified with a code, and in the future, the user that crawled can be added in the case of multiple admins or a hierarchy of admins, such as super/sub-admin as the case may be.
  - Then I deleted the previous crawls. Kindly note that it's not advisable to directly delete permanently for analysis purposes. This made me use Laravel's soft delete feature to perform the deletion.
  - I have created a function delete_last_crawl that loops through the previously active crawl results and deletes them.
  - The system throws an error should there be an issue deleting the previously active crawl results.
  - I created an array that holds all the new links crawled and then inserts them into the database with the save_link function alongside the code generated.
  - The previous homepage.html file created after the last crawl is then deleted with the delete_home_page_file function.
  - The previous sitemap.html file created after the last crawl is also deleted with the delete_site_map_file function.
  - I generated views for the sitemap.html and homepage.html and saved them according to the crawl analysis results.
  - A success message is sent out to the admin’s dashboard view if everything is done correctly.
  - I added a feature that logs the error result. This is important as it gives the developers more insight into the background processes of the application.
- Results: This function actually fetches all the active results of the last crawl analysis to the admin view.
- Save_link: This takes in two parameters (code and URL) and then saves them as results into the results table in the database.
- Delete_last_crawl: This deletes all the previous URL result records of the site map.
- Delete_home_page_file: This checks if the homepage.html file exists in the storage and then deletes them. Storage here refers to the public folder as I specifically identified the disk to be used.
- Run_cron_job: This is the cron job that periodically (hourly) crawls the website and generates a new sitemap for the admin. Here is more details:
  - I created a cron job that makes a post request with the URL and code to the previously created “/analyze_link” route.
  - I logged messages for success or error.
  - I also used a try catch to get the exception errors, i.e., 5**, 4**.

## The Technical Decisions You Made and Why

I decided to use a try catch so as to catch all exceptions and prevent the users from seeing more technical issues while providing more insight into the background processes and errors. I also use roles and permission packages - Spatie so as to give room for a clearer authorization process. I used the Laravel soft delete feature to give more details on the previously deleted crawl results. I generated a code for each crawl process for identification purposes. This can improve the analytics process in the feature as each process is tied to a code.

## How Your Solution Achieves the Admin’s Desired Outcome per the User Story

My solution actually crawls the home page and generates a sitemap for the admin. It also provides a cron job feature to start a regular (hourly) check on changes in the sitemap generation. It also gives the most recent sitemap and deletes the previous records.

## How Do I Think About a Problem?

When I am faced with a problem, I first of all review the details of the problem and then break it down into bits. I am also aware of the resources available to solve the problem as this can be a major issue, as different technologies have their strengths and weaknesses. For example, SEO optimization in Wordpress is extremely efficient unlike in React, which is not efficient and more complex to implement. I am also aware of previous ways/techniques of solving the problem if it has been solved or a similar problem. Programming has standard techniques to solve problems, and I try as much as possible to use them to make it easier, faster, and better.

## What Came to My Mind When I Saw the Problem?

I saw a product which can be marketed for other admins to use in their individual applications to be able to generate comprehensive sitemaps to be used to index their websites on Google search. Although it was my first time actually coding something like this for this purpose, it gave me more insight into the background process of WordPress SEO plugins such as https://aioseo.com/ and even caching plugins like https://wp-rocket.me/ perform.
