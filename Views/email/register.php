<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
    <script src="script.js"></script>
    <style type="text/css">
    </style>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- LOGO -->
    <tr>
        <td align="center" bgcolor="#1E1E2E">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td align="center" valign="top" style="padding: 36px 24px;">
                        <a href="https://hothothot.minarox.fr/" target="_blank" style="display: inline-block;">
                            <img src="https://hothothot.minarox.fr/public/assets/images/logo.png" alt="Logo">
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- LOGO -->
    <!-- MAIL -->
    <tr>
        <td align="center" bgcolor="#1E1E2E">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td align="left" bgcolor="#27293D" style="padding: 36px 24px 0; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; border-top: 3px solid #593EC2;border-top-left-radius: 8px;border-top-right-radius: 8px">
                        <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px; color: white"">
                        Bienvenue !</h1>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#1E1E2E">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td align="left" bgcolor="#27293D" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                        <p style="margin: 0;color: white">Nous sommes ravis que vous vous lanciez. Tout d'abord, vous devez confirmer votre compte. Appuyez simplement sur le bouton ci-dessous.</p>
                    </td>
                </tr>
                <tr>
                    <td align="left" bgcolor="#27293D">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" bgcolor="#27293D" style="padding: 12px;">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" bgcolor="#6f42c1" style="border-radius: 6px;">
                                                <a href="<?= $uri ??= null ?>?token_email=<?= $token ??= null ?>" target="_blank" style="display: inline-block; padding: 16px 36px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;">
                                                    Confirmer mon email
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" bgcolor="#27293D" style="padding: 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom-left-radius: 8px;border-bottom-right-radius: 8px">
                        <p style="margin: 0; color: white">Cordialement,<br> L?????quipe HotHotHot</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" bgcolor="#1E1E2E" style="padding: 24px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td align="center" bgcolor="#1E1E2E" style="padding: 12px 24px; font-family: 'Source Sans Pro', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px; color: #666;color: white">
                        <p style="margin: 0;">Vous avez re??u cet e-mail, car nous avons re??u une demande de confirmation pour votre compte. Si vous n'??tes pas ?? l'origine de cette demande, veuillez ignorer cet e-mail.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</td>
</tr>
</table>
</body>
</html>

<style>
    body{
        color: #1E1E2E;
    }
</style>