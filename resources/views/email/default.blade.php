<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600" rel="stylesheet" type="text/css">
    <!-- Web Font / @font-face : BEGIN -->

    <style>
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            font-family: 'Poppins', sans-serif !important;
            font-size: 14px;
            margin-bottom: 10px;
            line-height: 24px;
            color:#8094ae;
            font-weight: 400;
        }
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif !important;
        }
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        table table table {
            table-layout: auto;
        }
        a {
            text-decoration: none;
            color: #4ACE8B !important;
            word-break: break-all;
        }
        img {
            -ms-interpolation-mode:bicubic;
        }
        .email-body {
            width: 96%;
            margin: 0 auto;
            background: #ffffff00;
            padding: 10px !important;
        }
        .email-heading {
            font-size: 18px;
            color: #4ACE8B;
            font-weight: 600;
            margin: 0;
            line-height: 1.4;
        }
        .email-btn {
            background: #4ACE8B;
            border-radius: 4px;
            color: #ffffff !important;
            display: inline-block;
            font-size: 13px;
            font-weight: 600;
            line-height: 44px;
            text-align: center;
            text-decoration: none;
            text-transform: uppercase;
            padding: 0 30px;
        }
        .email-heading-s2 {
            font-size: 16px;
            color: #4ACE8B;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .link-block {
            display: block;
        }
        p {
            margin-top: 0;
            margin-bottom: 0;
            color: black;
        }
        .email-note {
            margin: 0;
            font-size: 13px;
            line-height: 22px;
            color: #4ACE8B;
        }

    </style>
</head>

<body width="100%" style="margin: 0;padding: 0 !important;mso-line-height-rule: exactly;background-color: #F8F9FA;" data-autofill-highlight="false">

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td style="padding: 40px 0;">

                    <table style="width:100%;max-width:620px;margin:0 auto;background-color: #ffffff;border: 2px solid gainsboro;">
                        <tbody class="email-body">
                            <tr style="border-bottom: 1px solid #dcdcdc85;">
                                <td style="    text-align: center;padding: 10px 0;">
                                    <a href="{{ url('/') }}">
                                        <img style="width: 120px;" src="{{ Vite::asset(\App\Library\Enum::LOGO_PATH) }}" alt="Logo">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 15px 30px">
                                    {!! $body_message !!}
                                </td>
                            </tr>
                            <tr style="border-top: 1px solid #dcdcdc85;">
                                <td style="text-align: center;padding: 7px 0;">
                                    <p style="font-size: 13px;">Copyright©Pa1l</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>
