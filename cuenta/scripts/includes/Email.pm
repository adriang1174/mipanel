package CA::Email;

=head1 NAME

CA::Email - envios de email desde la aplicacion

=head1 SYNOPSYS

Se encarga de realizar cualquier envio de e-mail desde la aplicacion.
Para ello utiliza el modulo Mail::Sender, que permite hacer envios de
texto plano, de HTML y de attachs.

Toma de config la variable SMTP_server para determinar que SMTP utilizar.

=head1 DESCRIPTION

Metodos disponibles:

=over 4

=item *

envioGenerico(DATA)

Realiza un envio de un email simple.  Esta funcion es generica y es 
utilizada por las demas.

=item *

envioGenericoAttach(DATA)

Realiza un envio de un e-mail con attach.  Es utilizada por las demas
funciones.


=item *

enviarCuponPago(TO, COOKIE, FACTURA, IMPORTE)

Envia el cupon de pago de un factura.  Como envia HTML, para no generarlo
nuevamente se hace un request a la aplicacion mediante LWP::UserAgent y 
se envia por e-mail el HTML obtenido.

=item *

enviarFactura(TO, COOKIE, FACTURA)

Envia una factura.  Idem cupon de pago, realiza un request HTTP para obtener
el HTML y luego envia por e-mail el resultado.

=item *

enviarCC(CLIENTE, TO, FECHA_INICIO, FECHA_FIN)

Envia la cuenta corriente de un cliente en formato CSV.

=item *

enviarAlertaTrafico(CLIENTE, MINUTOS, IMPORTE, MONEDA, FECHA_LIMITE, TEMPLATE)

Envia por e-mail un alerta de trafico, utilizando el template pasado por
parametros y realizando los reemplazos necesarios.

=item *

enviarInformeTrafico(CLIENTE, TO, INFORME)

Envia por e-mail un informe de trafico en formato CSV.

=item *

enviarConsumosNoFacturados(CLIENTE, DATA, FECHA_LIMITE, TEMPLATE)

Envia el informe de consumos no facturados por e-mail.

=item *

enviarTarifas(CLIENTE, TO, CUENTA [, PREFIJO])

Envia a la direccion TO las tarifas vigentes para la cuenta especificada.
Si se especifica tambien prefijo, manda unicamente las tarifas del prefijo
determinado.

=back
=cut

use strict;
use Mail::Sender;
use LWP::UserAgent;
# use LWP::Protocol::https::Socket;
use HTTP::Request;
use HTTP::Headers;
use CA::GeneradorCSV;
use HTTP::Response;
use HTTP::Cookies;
use CA::EnvioEmail;

my ($SMTP_SERVER, $FROM, $APPLICATION_URL);

# HEaders del informe semanal
my @HEADERS_INFORME_SEMANAL = ('Clasificador', 'Tipo de servicio', 'Cuenta', 'Fecha', 'Hora', 'Origen', 'Destino', 'Descripcion del destino', 'Duracion (minutos)', 'Moneda', 'Importe'); 
my $SUBJECT_INFORME_SEMANAL = 'Cuent@lternativa: informe de tráfico';

sub init() {
	use CA::Config;
	$SMTP_SERVER = CA::Config->getValue('SMTP_Server');
	$FROM = CA::Config->getValue('Mail_From');
	$APPLICATION_URL = CA::Config->getValue('App_URL');
}

BEGIN {
        if (not $ENV{'MOD_PERL'}) {
                init();
        } else {
                use Apache;
                Apache->push_handlers( PerlChildInitHandler => sub { CA::Email::init(); });
        }
}

# Envio generico de mails al cliente.
sub envioGenerico($$) {
	my ($pkg, $data) = @_;

	# Ahora envio el mail con attachment
	my $sender = Mail::Sender->new({
		smtp	=>	$SMTP_SERVER,
		from	=>	$FROM
	});

	if (ref ($sender->MailMsg({ to => $data->{to}, subject => $data->{subject}, msg => $data->{text} }))) {
		# Loguear el envio
		my $logdata = { cliente_id => $data->{cliente_id}, modulo => $data->{modulo}, email => $data->{to} };
		CA::EnvioEmail->agregar($logdata);
		return 1;
	} else {
		return 0;
	}
}

# Envio generico de mails al cliente.  El mail incluye un attach
sub envioGenericoAttach($$) {
	my ($pkg, $data) = @_;

	# Ahora envio el mail con attachment
	my $sender = Mail::Sender->new({
		smtp	=>	$SMTP_SERVER,
		fromaddr	=>	$FROM,
		from	=>	(defined $data->{from}) ? ($data->{from} . '<' . $FROM  . '>') : $FROM,
		replyto	=>	$FROM
	});


	my $opendata = { to => $data->{to}, subject => $data->{subject} };
	if (defined($data->{multipart})) {
		$opendata->{multipart} = $data->{multipart};
	}
	if ($sender->OpenMultipart($opendata)) {
		my $attach = $data->{attach};
		if (defined($data->{text})) {
			$sender->Body;
			$sender->SendEnc($data->{text});
		}
		$sender->Part($attach);
		my $done = 0;
		
		# Attachs adicionales
		for (my $i=2; (not $done); $i++) {
			if (defined($data->{'attach' . $i})) {
				# Segundo attach;
				$sender->Part($data->{'attach' . $i});
			} else {
				$done=1;
			}
		}
		my $result = $sender->Close;
		if ($result < 0) {
			return 0;
		} else {
			# Loguear el envio
			my $logdata = { cliente_id => $data->{cliente_id}, modulo => $data->{modulo}, email => $data->{to} };
			CA::EnvioEmail->agregar($logdata);
			return 1;
		}
	} else {
		return 0;
	}
}

sub enviarCuponPago($$$$$$) {
 	my ($pkg, $to, $cookie, $factura, $importe, $if) = @_;

	my $result = -1;
	my $func = "CA::Email::enviarCuponPago";
	if ($to) {
		# Primero genero el HTML del cupon, haciendo un request al sitio
		my $ua = LWP::UserAgent->new;
		$ua->agent($ENV{HTTP_USER_AGENT});
		my $url = $APPLICATION_URL . 'facturas.xsp?importe=' . $importe. '&acc=cupon&imprimir_cupon=1&comprobante_id=' . $factura->comprobante_id . '&mail=1';
		my $request = HTTP::Request->new('GET', $url);
		$request->push_header('Cookie', $cookie->as_string);
		$request->content_type('text/html');
		my $url_barcode = $APPLICATION_URL . 'barcode?comprobante_id=' . $factura->comprobante_id . '&importe=' . $importe;
		my $request_barcode = HTTP::Request->new('GET', $url_barcode);
		$request_barcode->push_header('Cookie', $cookie->as_string);
		my $url_css = $APPLICATION_URL . 'css/' . $if . '/ca.css';
		my $request_css = HTTP::Request->new('GET', $url_css);
		my $url_logos = $APPLICATION_URL . 'img/' . $if . '/logos.gif';
		my $request_logos = HTTP::Request->new('GET', $url_logos);
		my $response = $ua->request($request);
		my $response_barcode = $ua->request($request_barcode);
		my $response_logos = $ua->request($request_logos);
		my $response_css = $ua->request($request_css);
		if ($response->is_success and $response_barcode->is_success and $response_logos->is_success and $response_css->is_success) {
			my $html = $response->content;

			my $data = {
				to => $to,
				subject => 'Cuent@lternativa: cupón de pago ' . $factura->comprobante_id,
				modulo => 'facturas',
				multipart => 'related',
				cliente_id => $factura->cliente_id
			};

			$data->{text} = <<EOT;
Tal como Ud. solicitó a través de Cuenta\@lternativa, le enviamos adjunta la imagen del cupón de referencia.

Atención al Cliente
Grupo Alternativa 
Tel: 0810-3210-733 
Fax: (54-11) 4110-0199 
asistencia\@grupoalternativa.com 

EOT
			$data->{text} = undef();
			$data->{attach} = 
				{ description => 'Cupón de pago de Factura ' . $factura->comprobante_id,
				ctype => 'text/html; charset=us-ascii',
				encoding => 'Base64',
				disposition =>	'NONE',
				msg => $html
			};
			$data->{attach2} = 
				{ description => 'Código de barras de Factura ' . $factura->comprobante_id,
				ctype => 'image/png',
				encoding => 'Base64',
				disposition =>	'inline; filename="barcode.png"; type="PNG archive"' . "\r\nContent-ID: barcode",
				msg => $response_barcode->content
			};
			$data->{attach3} = 
				{ description => 'Logo Red Alternativa',
				ctype => 'image/gif',
				encoding => 'Base64',
				disposition =>	'inline; filename="logos.gif"; type="GIF archive"' . "\r\nContent-ID: logos",
				msg => $response_logos->content
			};
			$data->{attach4} = 
				{ description => 'Hoja de estilos',
				ctype => 'text/css',
				encoding => 'Base64',
				disposition =>	'inline; filename="cuenta.css"; type="CSS archive"' . "\r\nContent-ID: css",
				msg => $response_css->content
			};
			return $pkg->envioGenericoAttach($data);
		} else {
			if (! $response->is_success) {
				warn "$func: error al bajar HTML del cupon: $url\n";
			} elsif (! $response_barcode->is_success) {
				warn "$func: error al bajar codigo de barras del cupon\n";
			} elsif (! $response_logos->is_success) {
				warn "$func: error al bajar logos del cupon\n";
			} elsif (! $response_css->is_success) {
				warn "$func: error al bajar css del cupon\n";
			}
			return 0;
		}
	} else {
		return 0;
	}
}

sub enviarCuponPagoDineroMail($$$$$$) {
 	my ($pkg, $to, $cookie, $factura, $importe, $if) = @_;

	my $result = -1;
	my $func = "CA::Email::enviarCuponPagoDineroMail";
	if ($to) {
		# Primero genero el HTML del cupon, haciendo un request al sitio
		my $ua = LWP::UserAgent->new;
		$ua->agent($ENV{HTTP_USER_AGENT});
		my $url = $APPLICATION_URL . 'facturas.xsp?total=' . $importe. '&acc=dm&comprobante_id=' . $factura->comprobante_id . '&imprimir=1&mail=1';
		my $request = HTTP::Request->new('GET', $url);
		$request->push_header('Cookie', $cookie->as_string);
		$request->content_type('text/html');
		my $url_css = $APPLICATION_URL . 'css/' . $if . '/ca.css';
		my $request_css = HTTP::Request->new('GET', $url_css);
		my $url_logos = $APPLICATION_URL . 'img/' . $if . '/logos.gif';
		my $request_logos = HTTP::Request->new('GET', $url_logos);
		my $response = $ua->request($request);
		my $response_logos = $ua->request($request_logos);
		my $response_css = $ua->request($request_css);
		if ($response->is_success and $response_logos->is_success and $response_css->is_success) {
			my $html = $response->content;

			my $data = {
				to => $to,
				subject => 'Cuent@lternativa: cupón de pago ' . $factura->comprobante_id,
				modulo => 'facturas',
				multipart => 'related',
				cliente_id => $factura->cliente_id
			};

			$data->{text} = <<EOT;
Tal como Ud. solicitó a través de Cuenta\@lternativa, le enviamos adjunta la imagen del cupón de pago para DineroMail.

Atención al Cliente
Grupo Alternativa 
Tel: 0810-3210-733 
Fax: (54-11) 4110-0199 
asistencia\@grupoalternativa.com 

EOT
			$data->{text} = undef();
			$data->{attach} = 
				{ description => 'Cupón de pago para Dinero mail de Factura ' . $factura->comprobante_id,
				ctype => 'text/html; charset=us-ascii',
				encoding => 'Base64',
				disposition =>	'NONE',
				msg => $html
			};
			$data->{attach2} = 
				{ description => 'Logo Red Alternativa',
				ctype => 'image/gif',
				encoding => 'Base64',
				disposition =>	'inline; filename="logos.gif"; type="GIF archive"' . "\r\nContent-ID: logos",
				msg => $response_logos->content
			};
			$data->{attach3} = 
				{ description => 'Hoja de estilos',
				ctype => 'text/css',
				encoding => 'Base64',
				disposition =>	'inline; filename="cuenta.css"; type="CSS archive"' . "\r\nContent-ID: css",
				msg => $response_css->content
			};
			return $pkg->envioGenericoAttach($data);
		} else {
			if (! $response->is_success) {
				warn "$func: error al bajar HTML del cupon: $url\n";
			} elsif (! $response_logos->is_success) {
				warn "$func: error al bajar logos del cupon\n";
			} elsif (! $response_css->is_success) {
				warn "$func: error al bajar css del cupon\n";
			}
			return 0;
		}
	} else {
		return 0;
	}
}

sub enviarFactura($$$$) {
 	my ($pkg, $to, $cookie, $factura) = @_;

	my $result = -1;
	if ($to) {
		# Primero genero el HTML de la factura
		my $ua = LWP::UserAgent->new;
		$ua->agent($ENV{HTTP_USER_AGENT});
		my $url = $APPLICATION_URL . 'facturas.xsp?comprobante_id=' . $factura->comprobante_id . '&mail=1';
		#my $header = HTTP::Headers->new('Cookie' => $cookie->as_string);
		#$ua->prepare_request($request);
		my $request = HTTP::Request->new('GET', $url);
		$request->push_header('Cookie', $cookie->as_string);
		$request->content_type('text/html');
		my $response = $ua->request($request);
		my $html = $response->content;

		my $data = {
			to => $to,
			subject => 'Cuent@lternativa: factura ' . $factura->comprobante_id,
			modulo => 'facturas',
			cliente_id => $factura->cliente_id
		};

		$data->{text} = <<EOT;
Tal como Ud. solicitó a través de Cuenta\@lternativa, le enviamos adjunta la imagen de la Factura de referencia.

Atención al Cliente
Grupo Alternativa 
Tel: 0810-3210-733 
Fax: (54-11) 4110-0199 
asistencia\@grupoalternativa.com 

EOT
		$data->{attach} = 
			{ description => 'Factura ' . $factura->comprobante_id,
			ctype => 'text/html',
			encoding => 'Base64',
			disposition =>	'attachment; filename="factura.html"; type="HTML archive"',
			msg => $html
		};
		return $pkg->envioGenericoAttach($data);
	} else {
		return 0;
	}
}

# Envia la cuenta corriente de un cliente por e-mail
sub enviarCC($$$$) {
	my ($pkg, $cliente, $to, $fecha_inicio, $fecha_fin) = @_;

	# Obtener el CSV
	my $texto_csv = CA::GeneradorCSV->cuenta_corriente($cliente->cliente_id, $fecha_inicio, $fecha_fin);
	if (defined($texto_csv)) {
		my $data = { modulo => 'cc', cliente_id => $cliente->cliente_id,
			to => $to };
		$data->{subject} = 'Cuent@lternativa: Cuenta Corriente';

		my $nombre_cliente = $cliente->nombre_completo;
		$data->{text} =<<EOT;
Tal como Ud. solicitó a través de Cuent\@lternativa, le enviamos adjunto el resumen de su Cuenta Corriente. Este archivo lo puede abrir desde cualquier planilla de cálculos.

Atención al Cliente
Grupo Alternativa
Tel: 0810-3210-733
Fax: (54-11) 4110-0199
asistencia\@grupoalternativa.com 

EOT
		
		$data->{attach} = { description => 'Cuenta corriente',
			ctype => 'text/csv',
			encoding => 'Base64',
			disposition =>	'attachment; filename="cuenta_corriente.csv"; type="CSV archive"',
			msg => $texto_csv 
		};
		return $pkg->envioGenericoAttach($data);
	} else {
		# No se pudo generar el CSV
		return 0;
	}
}

# Envia por mail las tarifas de una cuenta
sub enviarTarifas($$$$;$) {
	my ($pkg, $cliente, $to, $cuenta, $prefijo) = @_;

	# Obtener el CSV
	my $texto_csv;
	if (defined($prefijo)) {
		$texto_csv = CA::GeneradorCSV->tarifas($cuenta, $prefijo);
	} else {
		$texto_csv = CA::GeneradorCSV->tarifas($cuenta);
	}
	if (defined($texto_csv)) {
		my $data = { to => $to, subject => 'Cuent@lternativa: Tarifario', modulo => 'tarifas', cliente_id => $cliente->cliente_id };
	
		my $nombre_cliente = $cliente->nombre_completo;
		my $servicio = $cuenta->servicio;
		my $login = $cuenta->login;
		$data->{text} =<<EOT;
Tal como Ud. solicitó a través de Cuent\@lternativa, le enviamos adjunto el listado de Tarifas para su cuenta de $servicio / $login.  Este archivo lo puede abrir desde cualquier  planilla de cálculos. 

Atención al Cliente
Grupo Alternativa
Tel: 0810-3210-733
Fax: (54-11) 4110-0199
asistencia\@grupoalternativa.com 

EOT
		$data->{attach} = 
			{ description => 'Tarifas para la cuenta ' . $servicio . ' / ' . $login,
			ctype => 'text/csv',
			encoding => 'Base64',
			disposition =>	'attachment; filename="tarifas.csv"; type="CSV archive"',
			msg => $texto_csv 
		};
		return $pkg->envioGenericoAttach($data);
	} else {
		return 0;
	}
}

sub enviarAlertaTrafico($$$$$$$) {
	my ($pkg, $cliente, $minutos, $importe, $moneda, $fecha_limite, $template) = @_;
	my $func = 'CA::Email::enviarAlertaTrafico';
	my $alerta;
	my $simbolo;
	if (defined($moneda)) {
		if ($moneda eq $CA::Cliente::DOLARES) {
			$simbolo = 'U$S';
		} else {
			$simbolo = '$';
		}
	}
	if (defined($minutos) and defined($importe)) {
		$alerta = 'Su consumo es de ' . $minutos . ' minutos por un importe (sin incluir IVA) de ' . $simbolo . $importe;
	} elsif (defined($importe)) {
		$alerta = 'Su consumo ha alcanzado ' . $simbolo . $importe;
	} elsif (defined($minutos)) {
		$alerta = 'Su consumo ha alcanzado ' . $minutos . ' minutos';
	} else {
		# Nunca deberia llegar aqui
		warn "$func: no hay alertas para enviar. cliente_id=" . $cliente->cliente_id;
		return 0;
	}
	my $texto = $template;
	my $rsocial = $cliente->rsocial;
	my $cliente_id = $cliente->cliente_id;
	$texto =~ s/CLIENTE_ID/$cliente_id/g;
	$texto =~ s/RAZON_SOCIAL/$rsocial/g;
	$texto =~ s/FECHA_HASTA/$fecha_limite/g;
	$texto =~ s/ALERTA/$alerta/g;

	my $data = { to => $cliente->email, subject => 'Cuent@lternativa: alerta de tráfico ', modulo => 'alertas', cliente_id => $cliente->cliente_id, text => $texto };
	return $pkg->envioGenerico($data);
}
sub enviarInformeTrafico($$$$) {
	my ($pkg, $cliente, $to, $informe, $if) = @_;

	# Obtener el CSV
	my $texto_csv = CA::GeneradorCSV->informe_trafico($informe);
	if (defined($texto_csv)) {
		my $data = { 
			from => ($if eq 'hola') ? 'cuent@hola' : 'cuenta@alternativa',
			to => $to, 
			subject => 'Informe. ' . $informe->titulo, 
			modulo => 'infmail', 
			cliente_id => $cliente->cliente_id 
		};
	
		my $nombre_cliente = $cliente->nombre_completo;
		my $titulo = $informe->titulo;
		my $interfaz = ($if eq 'hola') ? 'cuent@hola' : 'cuent@lternativa';
		my $nombre_informe = $informe->titulo;
		my $facturado = $informe->facturado ? 'Consumo facturado' : 'Consumo no facturado';

		$data->{text} =<<EOT;
$nombre_cliente:

Le enviamos adjunto el informe de $nombre_informe correspondiente a $facturado tal como usted lo solicitara a través de $interfaz.
Puede abrir el archivo con cualquier programa de planilla de cálculo.

Atención al Cliente  
Grupo Alternativa 
Tel : 0810-3210-733 
Fax: (54-11) 4110-0199 
asistencia\@grupoalternativa.com  

EOT
		$data->{attach} = 
			{ description => 'Informe de tráfico',
			ctype => 'text/csv',
			encoding => 'Base64',
			disposition =>	'attachment; filename="informe.csv"; type="CSV archive"',
			msg => $texto_csv 
		};
		return $pkg->envioGenericoAttach($data);
	} else {
		return 0;
	}
}


sub enviarConsumosNoFacturados($$$$$) {
	my ($pkg, $cliente, $data, $fecha_limite, $template) = @_;
	# Generar el CSV
	my $csv = CA::GeneradorCSV::generarCSV(\@HEADERS_INFORME_SEMANAL, $data);
	if (defined($csv)) {
		my $texto = $template;
		my $cliente_id = $cliente->cliente_id;
		my $rsocial = $cliente->rsocial;
		$texto =~ s/CLIENTE_ID/$cliente_id/g;
		$texto =~ s/RAZON_SOCIAL/$rsocial/g;
		$texto =~ s/FECHA_HASTA/$fecha_limite/g;
		my $data = { modulo => 'infmail', cliente_id => $cliente->cliente_id, to => $cliente->email, subject => $SUBJECT_INFORME_SEMANAL, text => $texto }; 	
		$data->{attach} = { 
			description => 'Informe',
			ctype => 'text/csv',
			encoding => 'Base64',
			disposition => 'attachment; filename="informe_trafico.csv"; type="CSV archive"',
			msg => $csv
		};
		if ($pkg->envioGenericoAttach($data)) {
			return 1;
		} else {
			warn "CA::Email::enviarConsumosNoFacturados: error al enviar el mail al cliente " . $cliente->cliente_id . "\n";
			return 0;
		}
	} else {

		warn "CA::Email::enviarConsumosNoFacturados: error al generar el CSV para el cliente " . $cliente->cliente_id . "\n";
		return 0;
	}
}

1;
