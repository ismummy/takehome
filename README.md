##Pangaea Take-home assignment Solution

####To run
- Clone the repo
- Run composer install
- Make a copy of .env from .env.copy
- Do Run database migration
- Start the server php artisan serve
 
 
 ####Solution Approach
 
  - Subscription
    - I created a route /subscribe/{topic} that takes valid url as the post body
    - Valid the request body to contain valid url
    - Save the topic and the url in local database (sqlite)
    - Return success response to user
 
     ```json
    **REQUEST BODY**
    http://localhost:8000/subscribe/helloworld
    
    {
      "url": "https://jsonplaceholder.typicode.com/todos/2"
    }
    ```

     ```json
    **Response BODY**
    http://localhost:8000/subscribe/helloworld
    
    {
        "url": "https://jsonplaceholder.typicode.com/todos/2",
        "topic": "helloworld"
    }
    ```
    
  - Publishing
      - I created a route /publish/{topic} that takes any key value post body
      - Fetch all subscriber from database by topic
      - Publish new topic event
      - In the even listener, post the topic and data to the subscriber's url
   
       ```json
      **REQUEST BODY**
      http://localhost:8000/publish/helloworld
      
      {
        "username": "ismummy",
        "Title": "How to become a pro.",
        "Body": "Something nice here too."
      }
      ```


