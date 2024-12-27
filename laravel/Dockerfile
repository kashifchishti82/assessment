FROM ubuntu:22.04

ENV DEBIAN_FRONTEND noninteractive
SHELL ["/bin/bash", "-c"]

RUN \
  rm -rf /var/lib/apt/lists/* && \
  apt-get update && apt-get install -y apache2 software-properties-common curl && apt-get update -y && add-apt-repository ppa:ondrej/php -y && \
  apt-get install -y php8.2 php8.2-{fpm,common,mysql,xml,xmlrpc,curl,gd,imagick,cli,dev,imap,mbstring,soap,zip,bcmath,intl,opcache,swoole,bcmath} && \
  curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php && HASH=`curl -sS https://composer.github.io/installer.sig` && \
  php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
  php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

COPY sites-available/ /etc/apache2/sites-available/
COPY conf/common.sh .
RUN chmod +x common.sh && perl -pi -e 's/\r\n/\n/g' common.sh 

WORKDIR /var/www/html
copy ./laravel/ .

EXPOSE 80

CMD /common.sh && apachectl -DFOREGROUND
