package CA::EnvioEmail;

=head1 NAME

CA::EnvioEmail - Logs de envios de mail


=head1 DESCRIPTION

Envio de mail a un cliente

=head2 Atributos

=over 4

=item *

id()

ID interno

=item *

cliente_id()

Cliente

=item *

modulo()

Modulo

=item *

fecha()

Fecha

=item *

email()

Email


=back

=head2 Metodos de clase

=over 4

=item *

load($id)

Carga de la base de datos un objeto EnvioEmail

=back


=cut


use strict;
use CA::DB;

use CA::Cliente;






# Crea un nuevo objeto EnvioEmail.  Recibe como parametro una referencia a un HASH.
# Si incluye el id, es porque es un objeto existente
# y simplemente hace un bless del HASH.  Si no, lo inserta en la base de datos.

sub new($$) { 
	my ($pkg, $data) = @_;
	
	if (defined($data->{id})) {
		# Tiene primary key.  Crear objeto en memoria.
		return bless($data, $pkg);
	} else {
		return undef;
	}
}

# Agregar un nuevo objeto a la tabla
sub agregar($$) {
	my ($pkg, $data) = @_;

	# No tiene primary key.  Agregar a DB y crear objeto 
	my $query = 'insert into enviosemail(id, cliente_id, modulo, fecha, email) values(?, ?, ?, now(), ?)';
	my $qseq = "select nextval('enviosemail_id')";
	my $id = CA::DB::s_s($qseq);
	if (defined($id)) {
		my $sth = CA::DB->prepare($query);
		my $r;
		if (defined($sth)) {
			if ($sth->execute($id, $data->{cliente_id}, $data->{modulo}, $data->{email})) {
				$r = $pkg->load($id);
				
			} else {
				warn "CA::EnvioEmail: execute failed for $query: " . $sth->errstr;
			}
			$sth->finish;
		} else {
			warn "CA::EnvioEmail: error al preparar query $query\n";
		}
		return $r;
	}
}


# Carga de la base de datos un objeto EnvioEmail.  Recibe como parametro el primary key
sub load($$) {
        my ($pkg, $id) = @_; 
        my $query = 'select * from enviosemail where id = ?';
        if (defined(my $r = CA::DB::ors_h($query, $id))) {
                return bless($r, $pkg);
        } else {
                return undef;
        }
}









sub verificarAgregar($$) {
        my ($pkg,$data) = @_;
        my $errors = $pkg->verificar($data);
        return $errors;
}

sub verificarModificar($$) {
        my ($pkg,$data) = @_;
        my $errors = $pkg->verificar($data);
        return $errors;
}

sub verificar($) {
        my ($pkg, $data) = @_;
	my $errors = {};
        
		
			
	if (length($data->{id}) == 0)  {
		$errors->{id} = "Debe completar el campo id";
	}
			
		
	
		
			
	if (length($data->{cliente_id}) == 0)  {
		$errors->{cliente_id} = "Debe completar el campo cliente_id";
	}
			
		
	
		
			
	if (length($data->{modulo}) == 0)  {
		$errors->{modulo} = "Debe completar el campo modulo";
	}
			
		
	
		
			
	if (not CA::Fecha->esFechaHora($data->{fecha})) {
		$errors->{fecha} = "Debe seleccionar una fecha v&á;lida ";
	}
			
		
	
		
			
	if (length($data->{email}) == 0)  {
		$errors->{email} = "Debe completar el campo email";
	}
			
		
	
        return $errors;
}


sub mayDelete($) {
	my $self = shift;
	return 1;
}


sub delete($) {
	my $self = shift;
	 
	my $query = 'delete from enviosemail where id = ? ';
	if (CA::DB::dds($query, $self->id)) {
		return 1;
	} else {
		return 0;
	}
	
}




sub id($) {
	my $self = shift;
	return $self->{id};

}

sub cliente_id($) {
	my $self = shift;
	return $self->{cliente_id};

}

sub cliente($) {
	my $self = shift;
	if ($self->cliente_id) {
		return CA::Cliente->load($self->cliente_id);
	} else {
		return undef;
	}

}

sub modulo($) {
	my $self = shift;
	return $self->{modulo};

}

sub fecha($) {
	my $self = shift;
	return $self->{fecha};

}

sub email($) {
	my $self = shift;
	return $self->{email};

}







return 1;
