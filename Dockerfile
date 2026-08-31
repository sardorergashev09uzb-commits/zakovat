FROM yiisoftware/yii2-php:8.2-apache

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

# Configure Apache document root to frontend/web
RUN sed -i -e 's|/app/web|/app/frontend/web|g' /etc/apache2/sites-available/000-default.conf

# Set permissions
RUN chmod -R 777 /app/frontend/runtime /app/frontend/web/assets /app/backend/runtime /app/backend/web/assets || true

EXPOSE 80
CMD ["apache2-foreground"]
