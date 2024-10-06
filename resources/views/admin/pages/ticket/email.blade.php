<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ticket Email</title>
</head>
<body>
    <div style="height: 100vh; background-color:#f6f8fc; @import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
        <div style="text-align:center; padding:50px 0px 20px 0px">
            <a href="#" title="logo" target="_blank">
                <img width="150" src="https://websolutionfirm.com/static/media/footerLogo.4cd7aa8d.png" title="logo" alt="logo">
            </a>
        </div>
        <div style="max-width:670px; background:#fff; margin-left:auto; margin-right:auto; border-radius:8px; text-align:center;box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
            <div style="padding: 20px;">
                <p style="text-align:center; font-weight:500; font-size:32px; font-family: 'Rubik', sans-serif"> {!! $data->email_message !!}
                     <br/>
                    <span style="display:inline-block; vertical-align:middle; border-bottom:1px solid #cecece; width:150px;"></span>
                </p>
                
                <div style="text-align:center; padding:0px 25px;">
                    <p style="color:#455056; font-size: 15px; line-height: 24px;">Ticket ID : {{ $data->ticket_id }}</p>
                    <p style="color:#455056; font-size: 15px; line-height: 24px;">Ticket subject : {{ $data->subject }}</p>
                    <p style="color:#455056; font-size: 15px; line-height: 24px;">Ticket message : {{ $data->message }}</p>
                </div>
                <div style="padding-bottom: 30px; text-align:center;">
                    <a href="{{ route('admin.ticket.show', $data->id) }}" style="background:#03cd5d;text-decoration:none !important; font-weight:600; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">
                        View Ticket
                    </a>
                </div>
            </div>
        </div>
        <div style="text-align:center; padding-top:20px;">
            <a href="https://websolutionfirm.com" style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>www.websolutionfirm.com</strong></a>
        </div>
    </div>
</body>
</html>

