How to run this project (start with first command in project root directory)

1. cd docker

2. Adjust .env file DOCUMENT_ROOT var to your needs

3. docker-compose up -d

4. docker exec -it developertest-symfony-php8 composer install

5. docker exec -it developertest-symfony-php8 php bin/console doctrine:migrations:migrate

6. docker exec -it developertest-symfony-php8 php bin/console doctrine:fixtures:load -n


Your Tasks:

1. If we create or update a customer we want to check whether the given email is valid. Otherwise we throw an exception.
2. Implement functionality to get customers by their customer number or their email address
3. Implement functionality to get Orders and OrderItems serialized within the customer data
4. Use the symfony event system to write a log to a newly created logfile named "order_log" every time a new order is created in the system