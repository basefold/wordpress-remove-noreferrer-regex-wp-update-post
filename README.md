# WordPress remove noreferrer
Remove noreferrer from WordPress for all posts and save the changes to the database with ***[wp_update_post](https://developer.wordpress.org/reference/functions/wp_update_post/)***
# Usage
Add the function to your theme's `functions.php`
# Things to look out for
- It updates every post so make sure you have a copy of the latest backup
- It’ll run as the WordPress admin screen loads or [initializes](https://developer.wordpress.org/reference/hooks/admin_init/)
- It’s designed for single use
- Consider removing or commenting it out when you are done
- Batch your posts if you have a large number of them
