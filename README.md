## installation
change .env.example to .env
docker-compose up -d

RUN 
.\bin\build.sh or .\bin\win-build.sh

## first run
run in command line 
docker-compose exec scheduler php artisan schedule:test 
select 0 and enter

## example

http://localhost:8070/api/data/2022-07-02

http://localhost:8070/api/number/49

