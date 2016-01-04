#Absentist

An attendance monitoring app that I've built to help me in monitoring the attendance of my students.

###Features

- create/update/list classes
- add students
- updating attendance (excused or absent)
- drop class card
- claim class card
- list days absent

###How to Use

Clone the project:

```
git clone https://github.com/anchetaWern/absentist.git
```

Install the dependencies with [Composer](https://getcomposer.org/):

```
composer update 
```

Create the database using something like phpmyadmin or heidisql, configure the database on `app/config/database.php`, then run the migration to create the tables:

```
php artisan migrate
```

If you need information on how to use the project, check out my blog post: [Introduction to Absentist](http://wern-ancheta.com/blog/2015/09/27/introduction-to-absentist/).

##License

The MIT License (MIT) Copyright (c)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.