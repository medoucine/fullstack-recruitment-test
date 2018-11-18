FROM php:7.2-apache-stretch

## APT-GET Installs
RUN rm /etc/localtime \
&& ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime \
&& apt-get update -q \
&& apt-get install -q -y --no-install-recommends \
        wget \
        curl \
        apt-transport-https \
        ca-certificates \
        automake \
        git \
        ssh-client \
        gnupg \
        # for composer (optionnal)
        unzip \
        # PHP INTL
        libicu-dev \
        # tar uncompress
        xz-utils

## Install NodeJS + Yarn
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - \
&& curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
&& echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
&& apt-get update -q \
&& apt-get install -q -y --no-install-recommends nodejs build-essential yarn \
## Install composer
&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## PHP extensions configure
RUN docker-php-ext-install intl \
## APACHE modules
&& a2enmod rewrite expires

## Clean APT - to use with docker build --squash
RUN apt-get remove --purge -y \
&& apt-get clean -y \
&& rm -rf /var/lib/apt/lists/*

## Add image configuration and scripts
COPY root/ /
RUN chmod 755 /apache.sh
WORKDIR /var/www/medoucine
CMD ["/apache.sh"]
HEALTHCHECK --interval=5s --start-period=10s --retries=10 CMD curl --fail --connect-timeout 1 --max-time 10 http://127.0.0.1/ || exit 1
