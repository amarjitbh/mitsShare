<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content=" width = device - width , initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="format-detection" content="telephone=no" /> <!-- disable auto telephone linking in iOS -->
    <title><?php echo Config::get('constants.APP_NAME') ?></title>
</head>
<body style = "font-family: Arial, sans-serif; margin:0; padding:0; ">
<table border = "0"  cellpadding = "0" cellspacing = "0" width="600" align = "center" style = " border-collapse : collapse;    box-shadow: 1px 2px 20px 5px rgba(0,0,0,0.1); margin-bottom: 20px;margin-top: 20px; padding: 10px 10px 10px 10px; background-color: #ddd; " >
    <tr>
        <td align="center" bgcolor ="#ffffff" style = " padding: 0px 0px 0px 0px; ">
            <table border ="0" cellpadding ="0" cellspacing ="0" width="100%" style="background-color: #f9f9f9;">
                <tr align="center">
                    <td colspan="2" style="text-align: center;padding: 15px 10px 15px 10px; background-color: #e4e4e4; color: #f7f7f7; font-weight: bold">
                        <img src="{{URL::asset('img/logo.png')}}" alt="ShareAir" style="max-height: 60px; max-width: 130px;">
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 10px 10px 10px; width: 100%;" align="center">
                        <p style="font-size: 12px; padding: 15px 10px 15px 10px; color: #222; text-align: left;">
                            @yield('content')
                        </p>

                    </td>

                </tr>
                <tr>
                    <td height="1" colspan="2" bgcolor="#dddddd"></td>
                </tr>
            </table>


            <!--Footer section-->


            <!--Footer section-->
            <table border ="0" cellpadding ="0" cellspacing ="0" width="100%" align = "center" style = "color: #999999; background: #f1f1f1; border-collapse : collapse; font-size: 12px;">
                <tbody>
                <tr>
                    <td align="center">
                        <p>Powered By: ShareAir.io</p>
                    </td>
                </tr>
                </tbody>


            </table>
        </td>
    </tr>
</table>
</body>
</html>
