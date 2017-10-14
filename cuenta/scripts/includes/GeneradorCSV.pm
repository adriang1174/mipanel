package CA::GeneradorCSV;

=head1 NAME

CA::GeneradorCSV - generador de archivos CSV

=head1 SYNOPSYS

Genera archivos con formato CSV para los distintos modulos del sistema.

=head1 DESCRITION

Metodos:

=over 4

=item *

cuenta_corriente(CLIENTE_ID, FECHA_INICIO, FECHA_FIN)

Genera la cuenta corriente de un cliente entre las fechas especificadas.


=item *

tarifas(CUENTA [, PREFIJO])

Tarifas de una cuenta.  Opcionalmente se puede especificar un prefijo.

=item *

informe_trafico(INFORME)

Genera el CSV de un informe de trafico.

=item *

generarCSV(HEADERS, DATA)

Metodo interno utilizado por los demas para hacer la generacion del archivo.

=back

=cut


use strict;
use CA::Movimiento;
use CA::DB;
use CA::Fecha;

# Reporte de cuenta corriente
# 
# Toma cliente_id, fecha de inicio y fecha de fin
# Devuelve 
# Fecha de emision,Codigo de comprobante,Fecha de vencimiento,Debe,Haber,Saldo

sub cuenta_corriente($$$$) {
	my ($pkg, $cliente_id, $fecha_inicio, $fecha_fin) = @_;

	# Obtener el saldo inicial
	my $saldo_inicial = CA::Movimiento->saldoInicial($cliente_id, $fecha_inicio);

	my $query = "select to_char(fechemision, '$CA::Config::DATE_FORMAT') as fecha_emision, tipodoc, sucdoc, numdoc, to_char(fechvto, '$CA::Config::DATE_FORMAT') as fechvto, importe from cc where cliente_id = ? and fechemision >= ? and fechemision <= ? order by fechemision"; 
	my $rows = CA::DB::s_aoh($query, $cliente_id, $fecha_inicio, $fecha_fin);

	my @headers = ('Emision', 'Comprobante', 'Vencimiento', 'Debe', 'Haber', 'Saldo');
	my @data = ();

	my $saldo = $saldo_inicial;
	
	my @saldo_inicial = ($rows->[0]{fecha_emision}, 'Saldo inicial', '', '', '', $saldo_inicial);
	push(@data, \@saldo_inicial);
	foreach my $row (@$rows) {
		my $comprobante_id = sprintf("%s-%04i-%08i", $row->{tipodoc}, $row->{sucdoc}, $row->{numdoc});
		my ($debe, $haber);
		my $importe = $row->{importe};
		if (substr($row->{tipodoc}, 0, 1) eq 'R') {
			# Es recibo
			$haber = $importe;
			$debe = 0;
			$saldo-=$importe;
		} else {
			$debe = $importe;
			$haber = 0;
			$saldo+=$importe;
		}
		my @fila = ($row->{fecha_emision}, $comprobante_id, $row->{fechvto}, $debe, $haber, sprintf("%.2f", $saldo));
		push(@data, \@fila);
	}

	return generarCSV(\@headers, \@data);
}

# Tarifas para una cuenta dada
# Devuelve prefijo,destino,moneda,tarifa,fechadesde,fechahasta
sub tarifas($$;$) {
	my ($pkg, $cuenta, $prefijo) = @_;
	my $tarifas;
	if (defined($prefijo)) {
		$tarifas = $cuenta->tarifasPorPrefijo($prefijo);
	} else {
		$tarifas = $cuenta->tarifas;
	}
	my @headers = ('Servicio', 'Login', 'Prefijo', 'Destino', 'Moneda', 'Tarifa', 'Inicio','Fin');
	my @data = ();
	foreach my $tarifa (@$tarifas) {
		my @row = ($cuenta->servicio, $cuenta->login, $tarifa->{destino}, $tarifa->{destinotxt}, $tarifa->{moneda}, $tarifa->{tarifa});
		if (defined($tarifa->{fechadesde})) {
			push(@row, CA::Fecha->datetime2date($tarifa->{fechadesde}));
		} else {
			push(@row, "");
		}
		if (defined($tarifa->{fechahasta})) {
			push(@row, CA::Fecha->datetime2date($tarifa->{fechahasta}));
		} else {
			push(@row, "");
		}
		push(@data, \@row);
	}
	return generarCSV(\@headers, \@data);
}

sub generarCSV($$) {
	my ($headers, $data) = @_;
	my $text = join(',', map { '"' . $_ . '"' } @$headers) . "\n";
	foreach my $row (@$data) {
		$text .= join(',', map { '"' . $_ . '"' } @$row) . "\n";
	}
	return $text;
}

sub informe_trafico($$) {
	my ($pkg, $informe) = @_;
	my $data = $informe->data;
	my $headers = $informe->headerLabels();
	my @data;
	# Recorrer cada fila e ir guardando en @data los valores
	my $ncols = $informe->ncolumnas;
	foreach my $fila (@$data) {
		my $cols = $fila->{columnas};
		my @row;
		if (($fila->{tipo} eq 'footer-agrupacion') or ($fila->{tipo} eq 'footer')) {
			# Agrupaciones.  Ponerle el encabezado, espacios en blanco,
			# y los totales que siempre van a la derecha al final

			push(@row, $cols->[0]{valor}); # Encabezado
			my $blancos = $ncols - scalar(@$cols);
			for (my $i=0; $i<$blancos; $i++) {
				push(@row, '');
			}
			push(@row, map { $_->{valor} } splice(@$cols, 1)); # Resto de los campos
		} else {
			@row = map { $_->{valor} } @$cols;
		}
		push(@data, \@row);
	}
	return generarCSV($headers, \@data);
}

1;
