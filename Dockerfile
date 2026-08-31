FROM yiisoftware/yii2-php:8.2-apache

# Set working directory
WORKDIR /app

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application files
COPY . /app

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Initialize Yii2 Production environment
RUN php init --env=Production --overwrite=All

# Configure Apache document root to /app/frontend/web and enable AllowOverride All
RUN sed -i -e 's|/app/web|/app/frontend/web|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Set directory permissions
RUN chmod -R 777 /app/frontend/runtime /app/frontend/web/assets /app/backend/runtime /app/backend/web/assets || true

EXPOSE 80
CMD ["apache2-foreground"]
