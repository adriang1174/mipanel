package CA::Config;

=head1 NAME

CA::Config - Configuracion de la aplicacion

=head1 SYSNOPSYS

Contiene algunas variables estaticas de configuracion y el acceso a las
tablas config y cliente_config, donde se guardan la mayoria de las variables.
config guarda las variables generales de la aplicacion, mientras que cliente_config
guarda variables especificas de cada cliente.

=head1 DESCRIPTION

Metodos disponibles:

=over 4

=item *

getValue(CLAVE, [CLIENTE_ID])

Devuelve el valor de una variable, dada su clave.  Si se especifica CLIENTE_ID,
buscara en cliente_config. En caso contrario, en config.

=setValue(CLAVE, VALOR, [CLIENTE_ID])

Setea el valor de una variable.  En caso de especificar CLIENTE_ID el valor lo
setea en cliente_config para el cliente especificado.  En caso contrario,
en config.  Si la variable no existe, inserta una fila con el valor.

=cut

*CA::Config::USUARIO = \'web';
*CA::Config::PROGRAMA = \'ca';
*CA::Config::BANDA_DEFAULT = \0;
*CA::Config::DATE_FORMAT = \'dd/MM/yyyy';

use CA::DB;
use strict;


# Obtiene el valor de una variable de configuracion, sea para clientes o generica
sub getValue($$;$) {
	my ($pkg, $clave, $cliente_id) = @_;
	if (defined($cliente_id)) {
		# Es variable de cliente
		my $query = 'select valor from cliente_config where cliente_id = ? and clave = ?';
		return CA::DB::s_s($query, $cliente_id, $clave);
	} else {
		# Es variable generica
		my $query = 'select valor from config where clave = ?';
		return CA::DB::s_s($query, $clave);
	}
}

# Setea el valor de una variable de configuracion, sea para clientes o generica
sub setValue($$$;$) {
	my ($pkg, $clave, $valor, $cliente_id) = @_;
	if (not defined($valor)) {
		$valor = '';
	}
	if (defined($cliente_id)) {
		my $qins = 'insert into cliente_config (cliente_id, clave, valor) values (?, ?, ?)';
		my $qupd = 'update cliente_config set valor = ? where cliente_id = ? and clave = ?';
		my $qsel = 'select count(*) from cliente_config where cliente_id = ? and clave = ?';
		my $count = CA::DB::s_s($qsel, $cliente_id, $clave);
		if ($count > 0) {
			return CA::DB::dds($qupd, $valor, $cliente_id, $clave);
		} else {
			return CA::DB::dds($qins, $cliente_id, $clave, $valor);
		}
	} else {
		my $query = 'update config set valor = ? where clave = ?';
		return CA::DB::dds($query, $valor, $clave);
	}
}

return 1;
