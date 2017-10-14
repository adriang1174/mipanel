package CA::Fecha;

=head1 NAME

CA::Fecha - Utilidades para manejar fechas

=head1 DESCRIPTION

Metodos:

=over 4

=item *

user2sql(FECHA)

Convierte una fecha ingresada por el usuario al formato de la base de datos.

=item *

timestamp2sql(TIMESTAMP)

Convierte un timestamp -segundos desde el epoch- al formato de la base de datos.

=item *

esFecha(STRING)

Controla si el string es o no una fecha valida.  Los formatos aceptados son
DD/MM/YYYY, DD-MM-YYYY y YYYY-MM-DD.

=item *

esFechaHora(STRING)

Controla si el string es una fecha con hora.  Es decir, si es una fecha seguida
de HH:MM:SS.


=back

=cut

use strict;
use overload '""' => \&as_string;

my @weekdays = qw (domingo lunes martes miercoles jueves viernes sabado domingo);
my @months = qw (enero febrero marzo abril mayo junio julio agosto septiembre octubre noviembre diciembre);

sub datetime2datehs($$) {
	my($pkg, $dt) = @_;
	my @ar = $pkg->datetime2array($dt);
	my $datehs = sprintf("%02i/%02i/%i %ihs", $ar[3], $ar[4], $ar[5], $ar[2]);
	return $datehs;

}
sub time2datetime($$) {
	my ($pkg, $t) = @_;
	my @lt = localtime($t);
	my $dt = sprintf("%i-%02i-%02i %02i:%02i:%02i", $lt[5]+1900, $lt[4]+1, $lt[3], $lt[2], $lt[1], $lt[0]);
	return $dt;
}

sub time2textdate($$) {
	my ($pkg, $time) = @_;
	my @l = localtime($time);
	my $t = sprintf("%s %i de %s de %i", $weekdays[$l[6]], $l[3], $months[$l[4]], 1900+$l[5]);	
	return $t;
}

sub date2date($$) {
	my($pkg, $dt) = @_;
	my @ar = $pkg->date2array($dt);
	my $date = sprintf("%02i/%02i/%i", $ar[0], $ar[1], $ar[2]);
	return $date;
}

sub date2array($$) {
	my ($pkg, $dt) = @_;
	my @a = $dt =~ /^(\d+)-(\d+)-(\d+)$/;
	my @b = reverse(@a);
	return @b;
}

sub datetime2array($$) {
	my ($pkg, $dt) = @_;
	if (my @a = $dt =~ /^(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)$/) {
		my @b = reverse(@a);
		return @b;
	} elsif ($dt =~ /^(\d+)-(\d+)-(\d+)$/) {
		my @b = (0,0,0,$3,$2,$1);
		return @b;
	}
	return undef;
}

sub datetime2date($$) {
	my($pkg, $dt) = @_;
	my @ar = $pkg->datetime2array($dt);
	my $date = sprintf("%02i/%02i/%i", $ar[3], $ar[4], $ar[5]);
	return $date;
}

sub datetime2hs($$) {
	my ($pkg, $dt) = @_;
	my @ar = $pkg->datetime2array($dt);
	my $hhmm = sprintf("%ihs", $ar[2]);
	return $hhmm;
}
sub datetime2hhmm($$) {
	my ($pkg, $dt) = @_;
	my @ar = $pkg->datetime2array($dt);
	my $hhmm = sprintf("%02i:%02i", $ar[2], $ar[1]);
	return $hhmm;
}

sub as_string {
	my $self = shift;
}

sub new($$) {
	my ($pkg, $dt) = @_;
	my $self = \{$pkg->datetime2array($dt)};
	return bless($self, $pkg);
}


sub esFecha($$) {
	my ($pkg, $fecha) = @_;
	my ($ano, $mes, $dia);
	if ($fecha =~ /^(\d{4,})-(\d{1,2})-(\d{1,2})$/) {
		($ano, $mes, $dia) = ($1, $2, $3);
	} elsif ($fecha =~ m!^(\d{1,2})/(\d{1,2})/(\d{4,})$!) {
		($dia, $mes, $ano) = ($1, $2, $3);
	} elsif ($fecha =~ m!^(\d{1,2})-(\d{1,2})-(\d{4,})$!) {
		($dia, $mes, $ano) = ($1, $2, $3);
	} elsif ($fecha =~ m!^(\d{1,2})/(\d{1,2})/(\d{1,2})$!) {
		($dia, $mes, $ano) = ($1, $2, $3);
		$ano+=2000;
	} elsif ($fecha =~ m!^(\d{1,2})-(\d{1,2})-(\d{1,2})$!) {
		($dia, $mes, $ano) = ($1, $2, $3);
		$ano+=2000;
	} else {
		return 0;
	}
	return (($dia >= 1) and ($dia <= 31) and ($mes >= 1) and ($mes <= 12) and ($ano >= 1980) and ($ano <= 2038));
}
	
sub esFechaHora($$) {
	my ($pkg, $fecha) = @_;
	if ($fecha =~ /^(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)$/) {
		return 1;
	} else {
		return 0;
	}
}

sub timestamp2sql($$) {
	my ($pkg, $ts) = @_;
	my @time = localtime($ts);
	return sprintf("%i-%02i-%02i %02i:%02i:%02i", $time[5]+1900, $time[4]+1, $time[3], $time[2], $time[1], $time[0]);
}

sub user2sql($$) {	
	my ($pkg, $fecha) = @_;
	my $ret;
	if ((not defined($fecha)) or (not $fecha)) {
		return undef;
	}
	if ($fecha =~ /^(\d{4,})-(\d{1,2})-(\d{1,2})$/) {
		$ret = $fecha;
	} elsif ($fecha =~ m!^(\d{1,2})/(\d{1,2})/(\d{4,})$!) {
		$ret = sprintf("%i-%02i-%02i", $3, $2, $1);
	} elsif ($fecha =~ m!^(\d{1,2})-(\d{1,2})-(\d{4,})$!) {
		$ret = sprintf("%i-%02i-%02i", $3, $2, $1);
	} elsif ($fecha =~ m!^(\d{1,2})/(\d{1,2})/(\d{1,2})$!) {
		$ret = sprintf("%i-%02i-%02i", $3+2000, $2, $1);
	} elsif ($fecha =~ m!^(\d{1,2})-(\d{1,2})-(\d{1,2})$!) {
		$ret = sprintf("%i-%02i-%02i", $3+2000, $2, $1);
	} else {
		$ret = undef;
	}
}

return 1;
