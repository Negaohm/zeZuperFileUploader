eval $("C:\Program Files\Docker Toolbox\docker-machine.exe" env -shell=bash)
docker run -d \
-p 80:80 -p 443:443 -p 3306:3306 \
-v "$(pwd)" \
--restart=always \
--name=appname \
mtmacdonald/docker-laravel:1.4.0
