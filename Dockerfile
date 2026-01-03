FROM dunglas/frankenphp

# Install dependencies for the OS (needed for some php extensions)
# and install the PHP extensions in one go
RUN install-php-extensions \
    pdo_mysql \
    bcmath \
    intl \
    zip \
    opcache \
    redis \
    gd \
    pcntl

# (Optional) Set the PHP configuration for production
# specific to FrankenPHP/Laravel performance
ENV PHP_INI_SCAN_DIR=":$PHP_INI_DIR/conf.d"

# Copy your application code
COPY . /app

# Enable the FrankenPHP binary
ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
