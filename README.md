# zipper
A PHP code for easy get the latest modified files from a directory, and then zip those files in the original directory tree.
Mainly purpose is to do some 'local version controll'.
If you develop a website simultaneously runing it live than it will make your job easier.

If you made some improvements on the development site, and you want to apply all the changes made that day, then you just go, write the time of start of your workday, write in where to look for changes, and the code will make a zip file containing all the changed/modified files from date that you put in earlier.
You just copy that zip file to live version of the site, and then unpack it, and all changes that was made in any directory, will be applied on tha live site.
