# htaccess

RewriteEngine On
RewriteRule product/lists/(.+)/(\d+) index.php?url=$1&id=$2
