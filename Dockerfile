FROM yiisoftware/yii2-php:8.2-apache

# Set working directory
WORKDIR /app

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application files
COPY . /app

# Configure Apache virtual host (Frontend at / and Backend Admin at /admin)
COPY apache-zakovat.conf /etc/apache2/sites-available/000-default.conf

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Initialize Yii2 Production environment
RUN php init --env=Production --overwrite=All

# Set directory permissions for assets and runtime
RUN chmod -R 777 /app/frontend/runtime /app/frontend/web/assets /app/backend/runtime /app/backend/web/assets || true

EXPOSE 80
CMD ["apache2-foreground"]
