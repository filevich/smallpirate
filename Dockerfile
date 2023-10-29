FROM ubuntu:22.04

RUN apt update && \
    apt install -y software-properties-common && \
    add-apt-repository --yes ppa:ondrej/php && \
    apt update && \
    # instalacion del ambiente
    DEBIAN_FRONTEND=noninteractive apt install -y iputils-ping iproute2 \
    openssl vim nano vsftpd nginx php5.6-fpm php5.6-mysql && \
    # creacion del usuario ftp
    useradd -p $(openssl passwd -1 ftper) ftper && \
    mkdir -p /home/ftper/html && \
    chmod -R 777 /home/ftper/html && \
    chown ftper: /home/ftper/html && \
    # symlinks
    mv /var/www/html /var/www/html.backup && \
    ln -s /home/ftper/html /var/www/html && \
    chown -R ftper:www-data /home/ftper/html/ && \
    chmod g+s /home/ftper/html/

COPY vsftpd.conf /etc/vsftpd.conf
COPY default /etc/nginx/sites-available/default
COPY --chown=ftper:www-data v2/. /home/ftper/html

CMD service vsftpd start && \
    service php5.6-fpm start && \
    service nginx restart && \
    tail -f /dev/null
