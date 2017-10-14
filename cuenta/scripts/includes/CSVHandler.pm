package CA::CSVHandler;

=head1 NAME

CA::CSVHandler - Handler de apache para archivos CSV

=head1 SYNOPSYS

Se encarga de responder los requests de exportaciones a CSV de reportes,
tarifas y cualquier otra informacion.

En todos los casos se realizan las verificaciones correspondientes para
que los usuarios no puedan acceder a informacion de otros usuarios, cambiando
los parametros del link.

=cut

use strict;
use Apache;
use Apache::Request;
use Apache::Log;
use Apache::Constants qw(:common);
use Apache::File;
use CA::Factura;
use CA::Informe;
use CA::GeneradorCSV;
use CA::Fecha;

sub handler($) {
	my $r = shift;
	my $log = $r->log;
	my %args = $r->args;
	
	my $usuario = $r->pnotes('usuario');

	my $tipo = $args{t};
	my ($error, $texto);

	if ($tipo eq 'cc') {
		# Cuenta corriente.  Vienen fecha inicio y fecha fin.
		my ($fecha_inicio, $fecha_fin) = ($args{fecha_inicio}, $args{fecha_fin});
		if (CA::Fecha->esFecha($fecha_inicio) and CA::Fecha->esFecha($fecha_fin)) {
			if ($usuario->esAgente()) {
				if ($args{cliente_id} and CA::Util->esClienteIdValido($args{cliente_id})) {
					my $c = CA::Cliente->load($args{cliente_id});
					if (defined($c) and ($usuario->esAgenteDe($c))) {
						$texto = CA::GeneradorCSV->cuenta_corriente($c->cliente_id, $fecha_inicio, $fecha_fin);
					} else {
						$error = 'Cliente inexistente';
					}
				} else {
					$error = 'Cliente inválido';
				}
			} else {
				$texto = CA::GeneradorCSV->cuenta_corriente($usuario->cliente_id, $fecha_inicio, $fecha_fin);
			}
		} else {
			$error = 'Fechas invalidas';
		}
	} elsif ($tipo eq 'tarifas') {
		# Export de tarifas - viene el servicio y el login
		my ($servicio, $login) = ($args{servicio}, $args{login});
		my $cuenta = CA::Cuenta->buscarPorClienteIdServicioLogin($usuario->cliente_id, $servicio, $login);
		if (defined($cuenta)) {
			$texto = CA::GeneradorCSV->tarifas($cuenta);
		} else {
			$error = 'Cuenta inexistente';
		}
	} elsif ($tipo eq 'trafico') {
		# Informe de trafico
		# Viene codigo de informe
		my $codigo = $args{tinforme_codigo};
		if ($usuario->puedeVerInforme($codigo)) {
			if ($codigo =~ /^TRAF\.FACT\.COMP\./) {
				# Informe por comprobante.  Debe venir tambien el codigo de comprobante
				my $codigo_comprobante = $args{comprobante};
				my ($comprobante, $tipodoc, $numdoc, $sucdoc);
				if (defined($codigo_comprobante) and (CA::Factura->esCodigoValido($codigo_comprobante))) {
					my $factura;
					if (not defined($factura = CA::Factura->buscarPorComprobanteId($codigo_comprobante))) {
						$error = 'Comprobante inexistente';
					} elsif (! $usuario->esComprobantePropio($factura)) {
						$error = 'Comprobante inexistente';
					} else {
						# OK. Crear el informe
						my $data = { cliente_id => $usuario->cliente_id, codigo => $codigo, comprobante => $factura, codlinea => $args{codlinea}, linea => $args{linea}, tiposervicio => $args{tiposervicio} };
							
						my $informe = CA::Informe->new($data);
						if (not defined($informe)) {
							$error = 'Informe inexistente';
						} elsif (not $informe->ejecutar) {
							$error = 'Error al ejecutar el informe';
						} else {
							# Ok.  Armar el CSV
							$texto = CA::GeneradorCSV->informe_trafico($informe);
						}	
					}
					
				} else {
					$error = 'Debe especificar el comprobante';
				}
			} elsif ($codigo =~ /^TRAF\.(FACT|CORR)\.FILT\./) {
				# Informes por filtros
				my $fact = $1 eq 'FACT';
				my ($tiposervicio, $linea);
				if ($args{linea}) {
					($tiposervicio, $linea) = (substr($args{linea}, 0, 1), substr($args{linea}, 1));
				}
				if (! $usuario->puedeVerInforme($codigo)) {
					$error = 'No tiene acceso al informe seleccionado';
				} elsif ($args{fecha_inicio} and (! CA::Fecha->esFecha($args{fecha_inicio}))) {
					$error ='Fecha de inicio invï¿½ida';
				} elsif ($args{fecha_fin} and (! CA::Fecha->esFecha($args{fecha_fin}))) {
					$error='Fecha de fin invï¿½ida';
				} elsif (defined($linea) and (not $usuario->tieneLinea($tiposervicio, $linea))) {
					$error='Lï¿½ea inexistente.';
				} else {
					my $data = {
						codigo => $codigo,
						cliente_id => $usuario->cliente_id
					};
					if ($args{destino}) {
						$data->{destino} = $args{destino};
						$data->{destino} =~ s/\D//g;
					}
					if (defined($linea)) {
						$data->{linea} = $linea;
					}
					if (defined($tiposervicio)) {
						$data->{tiposervicio} = $tiposervicio;
					}
					if ($args{fecha_fin}) {
						$data->{fecha_fin} = CA::Fecha->user2sql($args{fecha_fin});
					}
					if ($args{fecha_inicio}) {
						$data->{fecha_inicio} = CA::Fecha->user2sql($args{fecha_inicio});
					}
					my $informe = CA::Informe->new($data);
					if (defined($informe)) {
						if ($informe->ejecutar) {
							$texto = CA::GeneradorCSV->informe_trafico($informe);
						} else {	
							$error = 'Error al ejecutar el informe';
						}
					} else {	
						$error = 'Informe inexistente';
					}
				}
			} else {
				$error = 'Codigo de informe desconocido';
			}
		} else {
			$error = 'No tiene acceso al informe solicitado';
		}
	} else {
		$error = 'Tipo de informe desconocido';
	}

	if (defined($error)) {
		$r->content_type('text/plain');
		$r->print($error);
		return OK;
	} else {
		$r->content_type('text/csv');
		$r->set_content_length(length($texto));
		$r->send_http_header();
		$r->print($texto);
		return OK;
	}
}

1;
