package CA::DB;

=head1 NAME

CA::DB - Acceso a la base de datos

=head1 DESCRIPTION

Provee una serie de metodos para efectuar queries a la base
de datos que devuelven tipos de datos faciles de manejar.

=head2 Funciones 

=over 4

=item *

$sth = prepare(QUERY)

Llama a la funcion DBI->prepare utilizando el handle de la base
de datos y devuelve un I<statement handle>.

=item *

$hash_ref = ors_h(QUERY, [ PARAMETROS ])

Ejecuta el query QUERY pasandole los parametros especificados
en la lista.  Se debe especificar un parametro por cada 
I<placeholder> del query.  

Devuelve unicamente la primera fila de los resultados, en forma
de una referencia a un I<HASH>.

=item *

$scalar = s_s(QUERY, [ PARAMETROS ] )

Ejecuta el query y devuelve unicamente la primera columna de
la primera fila de los resultados, en forma de un valor escalar.

=back

=cut

use strict;
use DBI;
use vars qw ($dbh);

sub init {
	$dbh = DBI->connect($ENV{'CA_DBURL'}, $ENV{'CA_USER'}, $ENV{'CA_PASSWORD'}, 
		{ 'AutoCommit' => 1, 'RaiseError' => 0 } );	
}

sub cleanup {
	if (defined $dbh) {
		$dbh->disconnect();
	}
}

sub prepare($$) {
	my ($pkg, $query) = @_;
	if (defined(my $sth = $dbh->prepare($query))) {
		return $sth;
	} else {
		return undef;
	}
}

sub ors_lch($;@) {
	my $query = shift;
	if (defined(my $sth = _select($query, @_))) {
		$sth->finish;
		my $r = $sth->fetchrow_hashref;
		my $nr = {};
		foreach my $key (keys %$r) {
			$nr->{lc($key)} = $r->{$key};
		}
		return $nr;
	} else {	
		return undef;
	}
}
sub ors_h($;@) {
	my $query = shift;
	if (defined(my $sth = _select($query, @_))) {
		my $r = $sth->fetchrow_hashref;
		$sth->finish;
		return $r;
	} else {	
		return undef;
	}
}
sub ors_a($;@) {
	my $query = shift;
	if (defined(my $sth = _select($query, @_))) {
		my $r = $sth->fetchrow_arrayref;
		$sth->finish;
		return $r;
	} else {	
		return undef;
	}
}

sub _select($;@) {
	my $query = shift;
	my $sth;
	if (not defined($sth = $dbh->prepare($query))) {
		warn "_select: prepare returned undef: \"$query\" (" . join(',', @_) . ")\n";
		return undef;
	} elsif (not $sth->execute(@_)) {
		warn "_select: execute returned false: \"$query\"\n";
		return undef;
	} else {
		return $sth;
	}
}
			
sub ors_s($;@) {
	my $query = shift;
	if (defined(my $sth = _select($query, @_))) {
		my $r;
		if (defined(my $row = $sth->fetchrow_arrayref)) {
			$r = $row->[0];
		}
		$sth->finish;
		return $r;
	} else {
		return undef;
	}
}

sub s_s ($;@) {
	my ($query, @args) =@_;
	ors_s($query,@args);
}

sub s_a($;@) {
	my $query = shift;
	if (defined(my $sth = _select($query, @_))) {
		my $rows = [];
		while(defined(my $row = $sth->fetchrow_arrayref)) {
			push(@$rows, $row->[0]);
		}
		$sth->finish;	
		return $rows;
	} else {
		return undef;
	}
}

sub s_hoh($$;@) {
	my $query = shift;
	my $key = shift;
	if (defined(my $sth = _select($query, @_))) {
		my $rows = {};
		while(defined(my $row = $sth->fetchrow_hashref)) {
			$rows->{$row->{$key}} = $row;
		}
		$sth->finish;
		return $rows;
	} else {
		return undef;
	}
}	

sub s_h($;@) {
	my $query = shift;
	if (defined(my $sth = _select($query, @_))) {
		my $rows = {};
		while (defined(my $row = $sth->fetchrow_arrayref)) {
			$rows->{$row->[0]} = $row->[1];
		}
		$sth->finish;	
		return $rows;
	} else {
		return undef;
	}
}

sub s_aoa($;@) {
	my $query = shift;
	if (defined(my $sth = _select($query, @_))) {
		my $result = [];
		while(defined(my $row1 = $sth->fetchrow_arrayref)) {
			push(@$result, [ @$row1 ]);
		}
		$sth->finish;	
		return $result;
	} else {
		return undef;
	}
}

sub s_aoh($;@) {
	my $query = shift;
	if (defined(my $sth = _select($query, @_))) {
		my $rows = [];
		while(defined(my $row = $sth->fetchrow_hashref)) {
			push(@$rows, $row);
		}
		$sth->finish;	
		return $rows;
	} else {
		return undef;
	}
}

sub dds($;@) {
	my $query = shift;
	my $sth;
	if (not defined($sth = $dbh->prepare($query))) {
		warn "dds: prepare returned undef: \"$query\"\n";
		return undef;
	} else {
		my $r = $sth->execute(@_);
		$sth->finish;
		warn "dds: execute returned false: \"$query\".  Params: " . join(',', @_) . "\n" unless($r);
		return $r;
	}
}	

sub sqlesc($) {
	my $t = shift;
	return $dbh->quote($t);
}

1;

sub BEGIN {
	if (not $ENV{'MOD_PERL'}) {
		$ENV{'CA_DBURL'} ||= '';
		$ENV{'CA_USER'} ||= '';
		$ENV{'CA_PASSWORD'} ||= '';
		init();
	} else {
		use Apache;
		Apache->push_handlers( PerlChildInitHandler => sub { CA::DB::init(); });
		Apache->push_handlers( PerlChildExitHandler => sub { CA::DB::cleanup(); });
	}
}

sub END {
	if (not $ENV{'MOD_PERL'}) {
		cleanup();
	}
}
