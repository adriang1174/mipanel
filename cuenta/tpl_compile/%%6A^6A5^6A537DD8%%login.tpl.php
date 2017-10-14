<?php /* Smarty version 2.6.11, created on 2017-10-14 14:35:09
         compiled from login.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'lang', 'login.tpl', 7, false),array('function', 'ipath', 'login.tpl', 64, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="iso-8859-1"<?php echo '?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title><?php echo smarty_function_lang(array('k' => 'TITLE'), $this);?>
</title>
		<meta http-equiv="pragma" content="no-cache"/>
		<meta name="mssmarttagspreventparsing" content="true"/>

		<style type="text/css">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "css.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</style>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "css_owner.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


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
						<table border="0" cellspacing="0" cellpadding="0" width="299" height="211" class="login_table" style="background-image: url( <?php echo smarty_function_ipath(array('name' => "login-background.gif",'owner' => '1','lang' => '1'), $this);?>
); background-repeat: no-repeat;">
							<tr>
								<td style="padding-left: 10px; padding-top: 90px;" class="login_font"><?php echo smarty_function_lang(array('k' => 'LOGIN'), $this);?>
</td>
								<td style="padding-left: 10px; padding-top: 90px;"><input name="username" id="login_username" type="text" size="30" style="width: 170px;" /></td>
							</tr>
							<tr>
								<td style="padding-left: 10px;" class="login_font"><?php echo smarty_function_lang(array('k' => 'PASSWORD'), $this);?>
</td>
								<td style="padding-left: 10px;"><input name="password" type="password" size="30" style="width: 170px;" /></td>
							</tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td align="left" style="padding-left: 10px;" class="login_font"><a href="javascript:void(rememberPassword( ));" class="login_font"><?php echo smarty_function_lang(array('k' => 'REMEMBER_PASSWORD'), $this);?>
</a></td>
                            </tr>
							<?php if ($_GET['error'] != ''): ?>
								<tr>
									<td colspan="2" style="padding-top: 25px; padding-left: 20px; padding-right: 20px;" class="login_error" align="center">
									<?php if ($_GET['error'] == 2): ?>
									<?php echo smarty_function_lang(array('k' => 'LOGIN_ERROR_2'), $this);?>

									<?php else: ?>
									<?php echo smarty_function_lang(array('k' => 'LOGIN_ERROR'), $this);?>

									<?php endif; ?>
									</td>
								</tr>
							<?php endif; ?>
							<tr>
								<td colspan="2" style="padding-left: 10px; padding-top: 25px; padding-bottom: 20px;" align="center">
									<input type="image" src="<?php echo smarty_function_ipath(array('name' => "bt-ingresar.gif",'owner' => '1','lang' => '1'), $this);?>
" border="0">
								</td>
							</tr>
						</table>
					</form>
				</td></tr>
			</tbody>
		</table>
	</body>
</html>