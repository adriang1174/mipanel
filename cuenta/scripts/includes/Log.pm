package CA::Log;

=head1 NAME

CA::Log - modulo para logueo

=head1 SYNOPSYS

Permite el logueo en archivos de texto de los scripts que se 
ejecutan desde crontab

=cut

use strict;
use IO::File;

*CA::Log::DEBUG = \1;
*CA::Log::INFO = \2;
*CA::Log::WARN = \3;
*CA::Log::ERROR = \4;
*CA::Log::CRIT = \5;

my $types = {
	1	=> 'debug',
	2	=> 'info',
	3	=> 'warn',
	4	=> 'error',
	5	=> 'crit'
};

sub loglevel($;$) {
	my $self = shift;
	if (@_) {
		my $level = shift;
		$self->[2] = $level;
	} else {
		return $self->[2];
	}
}

sub new($$;$) {
	my ($pkg, $filename, $loglevel) = @_;
	$loglevel ||= $CA::Log::INFO;
	my $fh = IO::File->new(">> $filename");
	if (defined($fh)) {

		my $self = [ $fh, $filename, $loglevel ];
		return bless($self, $pkg);
	} else {
		warn "No se pudo abrir $filename para escritura\n";
		return undef;
	}
}

sub log($$$) {
	my ($self, $level, $msg) = @_;
	if ($level >= $self->[2]) {
		my $type = $types->{$level};
		my $line = localtime(time()) .  " # [" . $$ . "] # [" . $type . "] $msg\n";
		$self->[0]->print($line);
		if ($level >= $CA::Log::WARN) {
			warn $line;
		}
	} else {
		return;
	}
}

sub crit($$) {
	my ($self, $msg) = @_;
	return $self->log($CA::Log::CRIT, $msg);
}
sub warn($$) {
	my ($self, $msg) = @_;
	return $self->log($CA::Log::WARN, $msg);
}

sub info($$) {
	my ($self, $msg) = @_;
	return $self->log($CA::Log::INFO, $msg);
}

sub error($$) {
	my ($self, $msg) = @_;
	return $self->log($CA::Log::ERROR, $msg);
}

sub debug($$) {
	my ($self, $msg) = @_;
	return $self->log($CA::Log::DEBUG, $msg);
}

sub close($) {
	my $self = shift;
	$self->[0]->close;
}

return 1;
