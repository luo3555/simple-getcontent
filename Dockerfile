FROM php:5.6.30-apache
ADD public_html.zip /var/www/html/
EXPOSE 80