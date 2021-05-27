FROM php:fpm AS base_php_image
RUN apt-get update && apt-get install -y \
		vim \
		curl \
		wget \
		unzip \
		git \
		&& apt-get clean && rm -rf /var/lib/apt/lists/
RUN docker-php-ext-install sockets

WORKDIR /app
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY composer.json .
RUN composer install
COPY . /app

ENTRYPOINT ["php", "index.php"]

#RUN apt-get update && apt-get install -y libpq-dev \
#    && docker-php-ext-install pdo pdo_mysql

#FROM base_php_image AS development_php_image
#
#RUN pecl install xdebug
#
#RUN apt-get update && apt-get install -y \
#		vim \
#		curl \
#		wget \
#		unzip \
#		&& apt-get clean && rm -rf /var/lib/apt/lists/
#
#RUN wget -O composer-setup.php https://getcomposer.org/installer
#RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
#
#RUN curl -sS https://get.symfony.com/cli/installer | bash
#RUN mv ~/.symfony/bin/symfony /usr/local/bin/symfony
