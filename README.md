Github Activity Nag
===================
The Github Activity Nag is a PHP script that, when set to run at a regular time
(say, 6:00pm every evening) will tell you if a user has had any public activity
today. From there, it will be able to post a *friendly* message informing said
user of his / her mistake.

Why
---
I need to be more active on Github. This project serves two important purposes
with regards to that goal:

1. It reminds me when I have been inactive
2. It counts as activity

Installation
------------
Assuming you have a global Composer install:
```bash
composer install
php app.php
```
I recommend installing it as a Cron job.

Goals
-----
1. HipChat support
2. Pushover support
3. A generic "notification" interface
4. Detailed cronjob / launchctl instructions

[License][mit]
--------------
The MIT License (MIT)<br>
Copyright © 2013 Ciaran Downey &lt;code@ciarand.me&gt;

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the “Software”), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

[mit]: http://mit.ciarand.me/
