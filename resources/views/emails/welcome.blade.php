<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f7; font-family: Arial, Helvetica, sans-serif; color:#333333;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f7; padding: 30px 0;">
    <tr>
        <td align="center">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                {{-- Заголовок --}}
                <tr>
                    <td style="background-color:#4f46e5; padding:24px 32px;">
                        <h1 style="margin:0; color:#ffffff; font-size:22px;">
                            {{ $appName }}
                        </h1>
                    </td>
                </tr>

                {{-- Тело письма --}}
                <tr>
                    <td style="padding:32px;">
                        <h2 style="margin:0 0 16px; font-size:20px; color:#111827;">
                            Привет, {{ $userName }}! 👋
                        </h2>

                        <p style="margin:0 0 16px; font-size:15px; line-height:1.6; color:#374151;">
                            Спасибо за регистрацию в <strong>{{ $appName }}</strong>.
                            Мы рады видеть вас среди наших пользователей!
                        </p>

                        <p style="margin:0 0 24px; font-size:15px; line-height:1.6; color:#374151;">
                            Чтобы начать работу, войдите в свой аккаунт, используя email
                            и пароль, которые вы указали при регистрации.
                        </p>

                        {{-- Кнопка --}}
                        <table role="presentation" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="border-radius:6px; background-color:#4f46e5;">
                                    <a href="{{ $loginUrl }}"
                                       style="display:inline-block; padding:12px 28px; font-size:15px; color:#ffffff; text-decoration:none; font-weight:bold;">
                                        Войти в аккаунт
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:24px 0 0; font-size:13px; line-height:1.6; color:#6b7280;">
                            Если кнопка не работает, скопируйте ссылку в браузер:<br>
                            <a href="{{ $loginUrl }}" style="color:#4f46e5; word-break:break-all;">{{ $loginUrl }}</a>
                        </p>
                    </td>
                </tr>

                {{-- Подвал --}}
                <tr>
                    <td style="background-color:#f9fafb; padding:20px 32px; border-top:1px solid #e5e7eb;">
                        <p style="margin:0; font-size:12px; color:#9ca3af; line-height:1.5;">
                            Это автоматическое письмо, пожалуйста, не отвечайте на него.<br>
                            &copy; {{ date('Y') }} {{ $appName }}. Все права защищены.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
