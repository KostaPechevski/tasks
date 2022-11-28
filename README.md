Clone the repository
git clone https://github.com/KostaPechevski/tasks.git

Switch to the repo folder
cd tasks

Install all the dependencies using composer
composer install

Copy the example env file 
cp .env.example .env

Generate a new application key
php artisan key:generate

In the .env file make these change
DB_DATABASE=tasks

Install dependencies defined in a package.json
npm install

Run migrations
php artisan migrate

Run seeder
php artisan db:seed --class=UserSeeder 

Start the server
npm run dev
php artisan serve


Login credentials
admin:
username: a@abc.org
pass: Secret!

user:
username: b@abc.org
pass: Secret!

Click on Create Task to create task
Click on Tasks List to view all tasks
You can modify the expiration_date by clicking the date in the Tasks List table. The date is saved by pressing Enter
or by clicking outside the date input.
Visit this api endpoint  /api/users/{username} you get a JSON encoded list of tasks assigned to the requested username
