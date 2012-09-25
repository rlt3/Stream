Stream Framework
================

### Why and what is Stream

Stream is an MVC PHP framework and a small side-project of mine. I've always wanted to make my own framework just to see what all there is, and there seems to be a lot. 

It's hardly worth using at this point (let alone look at), but I enjoy fiddling around with it.

### What's cool about Stream

I didn't want to break the GET parameters inside PHP already, but wanted a way to pass a different kind of parameter. I've seen on a lot of APIs where some of the URLs might look like this:

``example.com/api?method=getFruit&cost=5.99&store=Aldi``

Well, I thought that it would be cool to combine the above into a more readable format like:

``example.com/api/getfruit/?cost=5.99&store=Aldi``

Stream works by calling instantiating a class and calling a method named by the request. So, for the home page, Stream would instantiate an Index object and call the ``get()`` method from it. If you posted to the index page, ``post()`` would be called.

For the above, there would be an Api class, which might have a method of getFruit.

A blog might have a url like: ``blog.com/article/1``

### Why do you basically have two ways of getting GET parameters

Because I thought they were more neat in terms of human readable code. Plus, at the end of the day, it is more flexible. I personally like for urls to be pretty and look like ``website.com/user/comments/57`` and those are all nice. But for things like APIs it makes sense to have a string of parameters at the end.

And, above all that, I think it makes for nice encapsulation.

Another reason was that I was originally using developer made regexes to return views. So, to get to the index or login page, the request would have had to pass a regex filter: ``^/$`` and ``^/login$`` respectively. Doing this meant you couldn't pass GET params the normal way and I didn't like that.

If you happen on this page and it is pain-stakingly obvious that I don't know what I'm doing at all with something, please shoot me a message, or make a really embarrassing pull-request. I won't mind.
