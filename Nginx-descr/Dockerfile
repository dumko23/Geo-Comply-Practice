#
# NOTE: THIS DOCKERFILE IS GENERATED VIA "update.sh"
#
# PLEASE DO NOT EDIT IT DIRECTLY.
#
FROM alpine:3.14
# принимает за основу базовый имейдж альфин версии 3.14 / описательная информация
LABEL maintainer="NGINX Docker Maintainers <docker-maint@nginx.com>"

ENV NGINX_VERSION 1.21.4
ENV NJS_VERSION   0.7.0
ENV PKG_RELEASE   1
# определение переменных среды с информацией о сборке (nginx, njs, пакеты)
RUN set -x \
    # "сет" - передача аргументов в пределах сценария(скрипта) с выводом в терминал
# create nginx user/group first, to be consistent throughout docker variants / собственно создаем и добавляем системную группу nginx с gid 101
    && addgroup -g 101 -S nginx \
    && adduser -S -D -H -u 101 -h /var/cache/nginx -s /sbin/nologin -G nginx -g nginx nginx \
    # добавляем системного с отключенным установки пароля пользователя с uid 101 в указанную директорию для группы nginx
    && apkArch="$(cat /etc/apk/arch)" \
    # установка и создание снимка каталога архитектуры
    && nginxPackages=" \
        nginx=${NGINX_VERSION}-r${PKG_RELEASE} \
        nginx-module-xslt=${NGINX_VERSION}-r${PKG_RELEASE} \
        nginx-module-geoip=${NGINX_VERSION}-r${PKG_RELEASE} \
        nginx-module-image-filter=${NGINX_VERSION}-r${PKG_RELEASE} \
        nginx-module-njs=${NGINX_V/Users/dmytromahera/PhpstormProjects/nginx dockerfile/DockerfileERSION}.${NJS_VERSION}-r${PKG_RELEASE} \
    " \
    # задание зависимостей от версий для пакетов nginx \
    # Собственно nginx
    # Xslt - для модификации запросов xml
    # геоАйПи позволяет захватывать инфо из айпи клиента используя бд \
    # image filter - для работы с изображениями \
    # njs - ветвление js для расширения возможностей nginx

# install prerequisites for public key and pkg-oss checks
    && apk add --no-cache --virtual .checksum-deps \
    # зависимости для проверки по чек-суммам (целостность)
        openssl \
    # библиотека для шифрования соединений между устройствами сети
    && case "$apkArch" in \
        x86_64|aarch64) \
    # проверка снимка каталога архитектуры в соответствии со стандартными для 32 и 64 разрядности с использованием условия CASE
# arches officially built by upstream \
    # как я понимаю, если не получается сопоставить снимок с имеющейся архитектурой, то выполняется сборка архитектуры из офф источника для корректной работы контейнера
            set -x \
            && KEY_SHA512="e7fa8303923d9b95db37a77ad46c68fd4755ff935d0a534d26eba83de193c76166c68bfe7f65471bf8881004ef4aa6df3e34689c305662750c0172fca5d8552a *stdin" \
            && wget -O /tmp/nginx_signing.rsa.pub https://nginx.org/keys/nginx_signing.rsa.pub \
    # создание локального ключа и скачивание крипто-файла рса с офф сайта nginx
            && if [ "$(openssl rsa -pubin -in /tmp/nginx_signing.rsa.pub -text -noout | openssl sha512 -r)" = "$KEY_SHA512" ]; then \
                echo "key verification succeeded!"; \
                mv /tmp/nginx_signing.rsa.pub /etc/apk/keys/; \
            else \
                echo "key verification failed!"; \
                exit 1; \
            fi \
    # проверка подлинности ключа сравнением со скачанным рса
            && apk add -X "https://nginx.org/packages/mainline/alpine/v$(egrep -o '^[0-9]+\.[0-9]+' /etc/alpine-release)/main" --no-cache $nginxPackages \
            ;; \
    # построение архитектуры
        *) \
# we're on an architecture upstream doesn't officially build for
# let's build binaries from the published packaging sources
            set -x \
    # далее работа будет выполняться с временной папкой, назначенной анонимному пользователю, скачиваются зависимости архитектуры линукс и создается пакет билд-депс
            && tempDir="$(mktemp -d)" \
            && chown nobody:nobody $tempDir \
            && apk add --no-cache --virtual .build-deps \
                gcc \
                libc-dev \
                make \
                openssl-dev \
                pcre-dev \
                zlib-dev \
                linux-headers \
                libxslt-dev \
                gd-dev \
                geoip-dev \
                perl-dev \
                libedit-dev \
                bash \
                alpine-sdk \
                findutils \
    # выполнение от имени анонимного пользователя составной команды: копирование архитектуры из временной папки, скачивание архива с pkg-oss для создания динамических модулей, с проверкой чек-сумм для надежности
            && su nobody -s /bin/sh -c " \
                export HOME=${tempDir} \
                && cd ${tempDir} \
                && curl -f -O https://hg.nginx.org/pkg-oss/archive/${NGINX_VERSION}-${PKG_RELEASE}.tar.gz \
                && PKGOSSCHECKSUM=\"f917c27702aa89cda46878fc80d446839c592c43ce7f251b3f4ced60c7033d34496a92d283927225d458cbc4f2f89499e7fb16344923317cd7725ad722eaf93e *${NGINX_VERSION}-${PKG_RELEASE}.tar.gz\" \
                && if [ \"\$(openssl sha512 -r ${NGINX_VERSION}-${PKG_RELEASE}.tar.gz)\" = \"\$PKGOSSCHECKSUM\" ]; then \
                    echo \"pkg-oss tarball checksum verification succeeded!\"; \
                else \
                    echo \"pkg-oss tarball checksum verification failed!\"; \
                    exit 1; \
                fi \
                && tar xzvf ${NGINX_VERSION}-${PKG_RELEASE}.tar.gz \
                && cd pkg-oss-${NGINX_VERSION}-${PKG_RELEASE} \
                && cd alpine \
                && make all \
                && apk index -o ${tempDir}/packages/alpine/${apkArch}/APKINDEX.tar.gz ${tempDir}/packages/alpine/${apkArch}/*.apk \
                && abuild-sign -k ${tempDir}/.abuild/abuild-key.rsa ${tempDir}/packages/alpine/${apkArch}/APKINDEX.tar.gz \
                " \
    # ^ распаковка архивов, создание модулей и ключей рса \
    # копирование созданного ключа \
    # удаление пакета билд-депс \
            && cp ${tempDir}/.abuild/abuild-key.rsa.pub /etc/apk/keys/ \
            && apk del .build-deps \
            && apk add -X ${tempDir}/packages/alpine/ --no-cache $nginxPackages \
            ;; \
    esac \
    # конец условия CASE
# remove checksum deps / говорит само за себя, удаление зависимостей для чек-сумм
    && apk del .checksum-deps \
# if we have leftovers from building, let's purge them (including extra, unnecessary build deps) / также удаляем все остаточные файлы, условная очистка мусора
    && if [ -n "$tempDir" ]; then rm -rf "$tempDir"; fi \
    && if [ -n "/etc/apk/keys/abuild-key.rsa.pub" ]; then rm -f /etc/apk/keys/abuild-key.rsa.pub; fi \
    && if [ -n "/etc/apk/keys/nginx_signing.rsa.pub" ]; then rm -f /etc/apk/keys/nginx_signing.rsa.pub; fi \
# Bring in gettext so we can get `envsubst`, then throw
# the rest away. To do this, we need to install `gettext`
# then move `envsubst` out of the way so `gettext` can
# be deleted completely, then move `envsubst` back.
    && apk add --no-cache --virtual .gettext gettext \
    # скачиваем gettext (библиотека для интернационализации), берем из него энвсвбст (утилита для подмены переменных), закидываем его в темп папку, удаляем геттекст и возвращаем энвсабст
    && mv /usr/bin/envsubst /tmp/ \
    \
    # сканируем папки с помощью паттернов авк, сортировка с выводом первого совпадения, выполнение команд в командной строке
    && runDeps="$( \
        scanelf --needed --nobanner /tmp/envsubst \
            | awk '{ gsub(/,/, "\nso:", $2); print "so:" $2 }' \
            | sort -u \
            | xargs -r apk info --installed \
            | sort -u \
    )" \
    && apk add --no-cache $runDeps \
    && apk del .gettext \
    && mv /tmp/envsubst /usr/local/bin/ \
    # момент удаления геттекста и перемещение энвсабст в папку с исполняемыми файлами
# Bring in tzdata so users could set the timezones through the environment / говорит само за себя
# variables
    && apk add --no-cache tzdata \
# Bring in curl and ca-certificates to make registering on DNS SD easier / -//-, днс сд - утилита для описания процесса обнаружения устройств в сети
    && apk add --no-cache curl ca-certificates \
# forward request and error logs to docker log collector / создание ссылки на лог файлы в сборщике логов докера
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log \
# create a docker-entrypoint.d directory / создание папки для статичных скриптов энтрипоинт и непосредственное их копирование в неё
    && mkdir /docker-entrypoint.d

COPY docker-entrypoint.sh /
COPY 10-listen-on-ipv6-by-default.sh /docker-entrypoint.d
COPY 20-envsubst-on-templates.sh /docker-entrypoint.d
COPY 30-tune-worker-processes.sh /docker-entrypoint.d
ENTRYPOINT ["/docker-entrypoint.sh"]
# запуск скриптов энтрипоинт

EXPOSE 80
# открытие порта энтрипоинт

STOPSIGNAL SIGQUIT
# задание стопсигнала

CMD ["nginx", "-g", "daemon off;"]
# выполнение команд при запуске с динамическими аргументами
