<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><!--{lang k=TITLE}--></title>
		<meta http-equiv="pragma" content="no-cache"/>
		<meta name="mssmarttagspreventparsing" content="true"/>

		<style type="text/css">
			<!--{include file="css.tpl"}-->
		</style>

        <!--{include file="css_owner.tpl"}-->


        <script type="text/javascript">
        <!--

            var rmbPasswd_Instance = null;

            function MM_findObj(n, d) { //v4.01
                var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
                    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
                if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
                for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
                if(!x && d.getElementById) x=d.getElementById(n); return x;
            }

            function rememberPassword( )
            {
                try
                {
                    var login_username = MM_findObj( "login_username", document);
                    if ( login_username)
                    {
                        url = "rmbpasswd.ca?username=" + escape( login_username.value);
                        rmbPasswd_Instance = window.open( url, "rmbPasswd", "menubar=no,location=no,resizable=no,scrollbars=no,status=no,width=400,height=180");
                        if ( !rmbPasswd_Instance)
                            return false;
                        rmbPasswd_Instance.focus( );
                    }

                    return true;
                }
                catch(e)
                {
                    alert( "err:" + e.message);
                    return false;
                }
            }

        //-->
        </script>
        
	</head>

	<body>
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr><td align="center" style="padding-top: 55px;">
					<form action="auth.ca" method="POST" style="margin: 0px;">
						<table border="0" cellspacing="0" cellpadding="0" width="299" height="211" class="login_table" style="background-image: url( <!--{ipath name="login-background.gif" owner="1" lang="1"}-->); background-repeat: no-repeat;">
							<tr>
								<td style="padding-left: 10px; padding-top: 90px;" class="login_font"><!--{lang k=LOGIN}--></td>
								<td style="padding-left: 10px; padding-top: 90px;"><input name="username" id="login_username" type="text" size="30" style="width: 170px;" /></td>
							</tr>
							<tr>
								<td style="padding-left: 10px;" class="login_font"><!--{lang k=PASSWORD}--></td>
								<td style="padding-left: 10px;"><input name="password" type="password" size="30" style="width: 170px;" /></td>
							</tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td align="left" style="padding-left: 10px;" class="login_font"><a href="javascript:void(rememberPassword( ));" class="login_font"><!--{lang k=REMEMBER_PASSWORD}--></a></td>
                            </tr>
							<!--{if $smarty.get.error != ''}-->
								<tr>
									<td colspan="2" style="padding-top: 25px; padding-left: 20px; padding-right: 20px;" class="login_error" align="center">
									<!--{if $smarty.get.error == 2}-->
									<!--{lang k=LOGIN_ERROR_2}-->
									<!--{else}-->
									<!--{lang k=LOGIN_ERROR}-->
									<!--{/if}-->
									</td>
								</tr>
							<!--{/if}-->
							<tr>
								<td colspan="2" style="padding-left: 10px; padding-top: 25px; padding-bottom: 20px;" align="center">
									<input type="image" src="<!--{ipath name="bt-ingresar.gif" owner="1" lang="1"}-->" border="0">
								</td>
							</tr>
						</table>
					</form>
				</td></tr>
			</tbody>
		</table>
	</body>
</html>
