# WordPress Dockerfile: Create container from official WordPress image, basic customizations.

# docker build -t amnesty (or wordpress)

FROM wordpress:latest

# APT Update/Upgrade, then install packages we need
RUN apt update && \
    apt upgrade -y && \
    apt install -y vim wget php5-pgsql
		# mariadb-client

# Replace php.ini
# COPY php.ini /us/local/etc/php

# Install WP-CLI
# RUN wet https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar & \
# 	php wp-cli.phar --info && \
# 	chmod +x wp-cli. phar && \
# 	mv wp-cli.phar /usr/local/bin/wp && \

# 	# Remove old php.ini files (wihtout creating new image)
# 	rm /usr/local/etc/php/php.ini-development && \ 
# 	rm /usr/local/etc/php/php.ini-production