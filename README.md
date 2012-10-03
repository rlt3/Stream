Stream Framework
================

### Why and What is Stream

Stream is an MVC framework built with PHP. I wanted to have a nice framework to deploy simple websites and applications. 

It serves mainly as a side project for myself because I always wanted to make a framework, just to see what all went into one.

### What's cool about Stream

It's named for what I would like to call the 'Stream Model'. The model is simple in theory: a user makes a request. This request is sent 'up'. At any point the server can stop execution and send a response downstream to the user. So, if the request was bad, there would not be a lot of time spent on that request as the server can send the error downstream almost immediately.

For requests that need to make use of a model and GET parameters, they would go all the way 'up' before coming down the Stream. So, only the things that require to most amount of work use the most amount of resources. This the theory, at least, and this is what I'm working towards.

### URL Mapping

Stream also makes pretty urls. For a url like ``/article/1`` all a developer would need to do is ``class Article`` with a ``public function get($id)`` as a method of ``Article``.

But I didn't want to break the super globals PHP uses for GET already because of things like APIs. A lot of times you see something like this:

``example.com/api?method=getFruit&cost=5.99&store=Aldi``

Well, I thought that it would be cool to combine the above into a more readable format like:

``example.com/api/getfruit/?cost=5.99&store=Aldi``

The difference between the two is not a very big one, but a significant one, I would like to think.

Of course, there is nothing stopping you from doing the following:

``example.com/api/categoryTotal/Produce/Aldi
