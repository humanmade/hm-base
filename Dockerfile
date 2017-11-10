FROM alpine:3.5

USER nobody

COPY . /usr/src/app
COPY wp-config-production-sample.php /usr/src/app/wp-config-production.php
VOLUME ["/usr/src/app"]
