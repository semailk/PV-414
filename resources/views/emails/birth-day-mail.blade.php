<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>С Днём Рождения!</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #ff6b9d, #ffa751);
            padding: 40px 20px;
            text-align: center;
            color: #fff;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .emoji {
            font-size: 50px;
            display: block;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px 35px;
            color: #333;
            line-height: 1.6;
            font-size: 16px;
        }
        .content p {
            margin: 0 0 15px;
        }
        .button {
            display: inline-block;
            background: #ff6b9d;
            color: #fff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: bold;
            margin-top: 15px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #999;
            background: #fafafa;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <span class="emoji">🎉🎂🎈</span>
        <h1>С Днём Рождения, {{ $user->name }}!</h1>
    </div>

    <div class="content">
        <p>Дорогой(ая) <strong>{{ $user->name }}</strong>,</p>

        <p>
            От всей души поздравляем Вас с Днём Рождения! 🎊
            Желаем крепкого здоровья, счастья, удачи и исполнения самых заветных желаний.
        </p>

        <p>
            Пусть каждый день приносит радость, а все начинания увенчиваются успехом!
        </p>


    </div>

    <div class="footer">
        © {{ date('Y') }} {{ config('app.name') }}. Все права защищены.
    </div>
</div>
</body>
</html>
