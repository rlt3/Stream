Stream Framework
================

### Why and What is Stream

Stream is an MVC framework built with PHP. I wanted to have a nice framework to deploy simple websites and applications. 

It serves mainly as a side project for myself because I always wanted to make a framework, just to see what all went into one.

### What's cool about Stream

It's named for what I would like to call the 'Stream Model'. The model is simple in theory: a user makes a request. This request is sent 'up'. At any point, as the request moves 'up', the server can stop execution and send a response downstream to the user. So, if the request was bad, there would not be a lot of time spent on that request as the server can send the error downstream almost immediately.

For requests that need to make use of a model and GET parameters, they would go all the way 'up' before coming down the Stream. So, only the things that require to most amount of work use the most amount of resources. This is the theory and this is what I'm working towards.

### How do I use it

To get started, you need to have a single point of entry. For example, have all traffic go to ``app/Controller.php``. From there, just include ``Stream.php``. I have that file here in ``lib/Stream/Stream.php``.

To create actual pages, Views are defined like this:

    class PAGE
    {
       public function REQUEST_METHOD(MODEL $model, $variable)
       {
          // do some stuff
          // require a template
       }
    }

Where ``PAGE`` would be the url you would want and REQUEST_METHOD would be the accepted request method for that page, e.g. GET or POST. If you need a model, you need to use object-type hinting in the arguments part of the function, and these models need to come before anything else. Variables that do not have object type hinting will be treated as if you are expecting a GET parameter, e.g. ``example.com/article/1``.

If the argument is not optional, and the user does not request a page with a GET parameter  -- ``example.com/article`` -- then the page will throw a 400 error: bad syntax. To make a GET parameter optional, simply do as you would do a normal function: ``public function get($id=1)``.

The classes can be named anything except ``Index``, because that is reserved for ``/`` requests. 

An index page might look something like this:

    class Index
    {
       public function get()
       {
          echo "Hello World!";
       }
    }

A blog page might look something like this:

    class Blog
    {
       public function get(Articles $articles)
       {
          $articles->getRecent(3);
          require("blog.php");
       }
    }
