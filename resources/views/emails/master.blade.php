<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body bgcolor="#f6f8f1" style="margin: 0; padding: 0; min-width: 100%!important;">
        <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table align="center" cellpadding="0" cellspacing="5" border="0" style="width: 100%; max-width: 600px; margin-top:20px;">
                        <tr>
                            <td>
                                <img src="{{ URL::to('img/logo.png') }}" alt="Business Directory" style="width:140px;"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table bgcolor="#fff" align="center" cellpadding="0" style="width: 100%; max-width: 600px; margin-top:20px;border:1px solid #eee; padding:26px; font-size:15px;">
                        <tr>
                            <td>
                                <!-- Content -->
                                @yield('content')
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table align="center" cellpadding="0" cellspacing="5" border="0" style="width: 100%; max-width: 600px; margin-top:20px; margin-bottom:40px;">
                        <tr>
                            <td style="text-align:center;">
                                Business Directory - <a href="{{ URL::to('') }}">{{ URL::to('') }}</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>