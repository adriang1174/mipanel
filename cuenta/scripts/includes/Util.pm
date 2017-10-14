package CA::Util;

=head1 NAME

CA::Util - Funciones de utilidad general

=head1 DESCRIPTION

Funciones disponibles:

=over 4

=item *

esClienteValido(CLIENTE_ID)

Indica si el parametro es un codigo de cliente valido.

=item *

esEmailValido(EMAIL)

Indica si el parametro es una direccion de email valida.

=item *

currency2txt(IMPORTE)

Convierte un importe a texto con palabras.
Ej: 923,32 = novecientos veintitres con 32 centavos.

=item *

esImporteValido(IMPORTE)

Indica si un importe es o no valido.

=back

=cut


use strict;

my @UNIDADES = qw(cero un dos tres cuatro cinco seis siete ocho nueve diez once doce trece catroce quince dieciséis diecisiete dieciocho diecinueve veinte veintiuno veintidós veintitrés veinticuatro veinticinco veintiséis veintisiete veintiocho veintinueve);
my @DECENAS = qw(diez veinte treinta cuarenta cincuenta sesenta setenta ochenta noventa cien);
my @CENTENAS = qw(ciento doscientos trescientos cuatrocientos quinientos seiscientos setecientos ochocientos novecientos);

# Indica si un codigo de cliente es o no valido, para verificar los parametros recibidos del browser
sub esClienteIdValido($$) {
	my ($pkg, $cliente_id) = @_;
	if ($cliente_id =~ /^\d+$/) {
		# es agente
		return 1;
	} elsif ($cliente_id =~ /^C\d+$/) {
		# Es cliente final
		return 1;
	} else {
		return 0;
	}
}

sub esEmailValido($$) {
	my ($pkg, $email) = @_;
	if (not defined($email)) {
		return 0;
	} else {
		my ($nombre, $dominio) = split(/@/, $email);
		if ((not $nombre) or (not $dominio)) {
			return 0;
		} elsif ($nombre !~ /^[\w._-]+$/) {
			return 0;
		} elsif ($dominio !~ /^[\w.-]+$/) {
			return 0;
		} else {
			return 1;
		}
	}
}

sub currency2Txt($$) {
        my ($pkg, $valor) = @_;

        my $entero = 0;
        my $decimal = 0;
	my $negativo = $valor < 0;
        my $indexPunto = index($valor, '.');

        if ($indexPunto != -1) {
                $entero = substr($valor, 0, $indexPunto);
                $decimal = substr($valor, $indexPunto+1);
        } else {
                $entero = $valor;
        }


        my $str;
	if ($negativo) {
		 $str = ' menos ' . $pkg->_traducirNumero(substr($entero, 1));
	} else {
		 $str = ' ' . $pkg->_traducirNumero($entero);
	}
        if ($decimal > 0) {
                $str .= (' con ' . $pkg->_traducirNumero($decimal) . ' centavos');
        }

        return $str;
}

sub _traducirNumero($$$) {
        my ($pkg, $numero, $str) = @_;

        $str ||= '';
        if (length($numero) == 1) {
                $str .= ' ' . $UNIDADES[$numero];
        } elsif (length($numero) == 2) {
                if ($numero < 30) {
                        $str .= ' ' . $UNIDADES[$numero];
                } else {
                        my $decena = substr($numero, 0, 1);
                        if (($numero % 10) == 0) {
                                $str .= ' ' . $DECENAS[$decena-1];
                        } else {
                                $str .= ' ' . $DECENAS[$decena-1] . ' y ' . $pkg->_traducirNumero(substr($numero, 1), $str);
                        }
                }
        } elsif (length($numero) == 3) {
                if ($numero == 100) {
                        $str .= ' cien';
                } else {
                        my $centena = substr($numero, 0, 1);
                        if (($numero % 100) == 0) {
                                $str .= ' ' . $CENTENAS[$centena-1];
                        } else {
                                $str .= ' ' . $CENTENAS[$centena-1] . ' ' . $pkg->_traducirNumero(substr($numero, 1), $str);
                        }
                }
        } else {
                # Miles
                my $leading = substr($numero, 0, length($numero)-3);
                my $trailing = substr($numero, length($numero)-3);

                return $pkg->_traducirNumero($leading) . ' mil ' . $pkg->_traducirNumero($trailing);
        }

        return $str;
}

sub checkCreatePidfile($) {
        my $pidfile = shift;
	my $func = 'CA::Util::checkCreatePidfile';
        if (-f $pidfile) {
                return -1;
        } else {
                if (open(PID, "> $pidfile")) {
                        if (print PID $$, "\n") {
                                if (close(PID)) {
                                        return 1;
                                } else {
                                        warn "$func: no se pudo cerrar el archivo $pidfile: $!\n";
                                        return 0;
                                }
                        } else {
                                warn "$func: no se pudo escribir en $pidfile: $!\n";
                                return 0;
                        }
                } else {
                        warn "$func: no se pudo abrir $pidfile para escritura: $!\n";
                        return 0;
                }
        }
}

sub esImporteValido($$) {
	my ($pkg, $importe) = @_;
	return $importe =~ /^\d+([,.]\d+)?$/;
}
return 1;
