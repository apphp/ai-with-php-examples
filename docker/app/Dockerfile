FROM php:8.2-fpm

# ------------------------------
# Install system dependencies
# ------------------------------
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    libxml2-dev \
    libcurl4-openssl-dev \
    libpng-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install zip pdo_mysql bcmath xml mbstring curl gd pcntl

# ------------------------------
# Install dependencies for Tensor
# ------------------------------
RUN apt-get update && \
    apt-get install -y \
    libopenblas-dev \
    libblas-dev \
    liblapack-dev \
    liblapacke-dev \
    libatlas-base-dev \
    gfortran \
    gcc \
    g++ \
    make \
    autoconf && \
    ln -s /usr/include/x86_64-linux-gnu/cblas.h /usr/include/cblas.h

# Set BLAS environment variables
ENV OPENBLAS_NUM_THREADS=1
ENV GOTO_NUM_THREADS=1
ENV OMP_NUM_THREADS=1

# Install the Tensor extension
RUN pecl install tensor && \
    docker-php-ext-enable tensor

# ------------------------------
# Install xDebug
# ------------------------------
# Remove this xDebug to enable JIT compiler
RUN pecl install xdebug && docker-php-ext-enable xdebug


# ------------------------------
# Create xdebug log file (if needed)
# ------------------------------
#RUN touch /var/log/xdebug.log
#RUN chown phishing:phishing /var/log/xdebug.log
#RUN chmod 775 /var/log/xdebug.log

# ------------------------------
# CONFIG files
# ------------------------------
COPY docker/app/conf.d/xdebug.ini /etc/php/8.2/mods-available/xdebug.ini
COPY docker/app/conf.d/opcache.ini /etc/php/8.2/mods-available/opcache.ini

# ------------------------------
# Install Composer
# ------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Configure PHP
RUN echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/docker-php-ram-limit.ini
RUN echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/docker-php-max-execution-time.ini

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
