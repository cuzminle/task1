<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<h1 align="center">Задание 1</h1>

<p>Авторизацию пользователей реализовал через Sanctum. 
    После регистрации или авторизации пользователя возвращается токен, который подставляетвя в headers в postman. 
    После чего пользователю предоставляется доуступ к его данным. <br>
    Вся логика работы вынесена в отдельный сервис(app\Services\User\Service.php) <br>
    Так же добавил отедльную таблицу Salaries где хранятся отработанные часы и связял ее с пользователями связью один к одному.
</p>
