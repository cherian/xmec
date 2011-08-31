#! /usr/bin/perl --

package xmec_config;
require Exporter;
@ISA = qw(Exporter);
@EXPORT = qw(_xmec_initdb xmec_send_mail _debug _warn _info _error $__xmec_home $_xmec_dbh);

#######################################################
# $__xmec_home - XMEC home directory name. 
#    The value is taken from the env. variable XMECHOME
#    Everything else is relative to this.
#######################################################

$__xmec_home = "";
if (defined($ENV{XMECHOME})) {
    $__xmec_home = $ENV{XMECHOME};
} elsif (defined($ENV{XMEC_HOME})) {
    $__xmec_home = $ENV{XMEC_HOME};
} elsif (defined($ENV{HOME})) {
    $__xmec_home = $ENV{HOME};
} else {
    die "XMECHOME/XMEC_HOME environment variable not set !\n";
}
$__xmec_home = "/usr162/home/x/m/xmec";

#########################################
# Get globals from xmec.conf file.
#########################################
sub _error;
sub _warn;
sub _debug;
sub _info;

$__xmec_config_dir = $__xmec_home . "/config";

unless (open (_XMECCONF, "$__xmec_config_dir/xmec.conf")) {
    die "open failed for $__xmec_config_dir/xmec.conf: $! \n";
}

while (<_XMECCONF>) {
    next if /^#/;
    if (/.*(\$\w+)(\W*=.*)$/) {
        eval $1.$2 ;
#        _debug "From conf file: $1.$2\n";
        push @EXPORT, $1;
    } 
}

close _XMECCONF;

#########################################
# DB vars.
#########################################

$_xmec_dbh = undef;


##############################################################################
# Common functions.
##############################################################################

sub _xmec_initdb
{

    foreach my $var ("__xmec_db_type", "__xmec_db_name", "__xmec_db_host", "__xmec_db_user",
                     "__xmec_db_pass") {
        die "Error: $var not set.\n" unless defined ($$var);
    }

    my $dsn = "DBI:$__xmec_db_type:database=$__xmec_db_name;host=$__xmec_db_host";

    $_xmec_dbh = DBI->connect($dsn, $__xmec_db_user, $__xmec_db_pass) or 
            die "Could not connect to database";
}

sub xmec_send_mail
{
    my ($msgref) = @_;

    return 0 unless defined ($$msgref);

    do {
        $__xmec_mailer = "/usr/sbin/sendmail -t";
        _warn "__xmec_mailer not defined, using /usr/sbin/sendmail\n";
    } unless defined ($__xmec_mailer);

    unless (open (SM, "|$__xmec_mailer")) {
        _error "Sending mail failed: $!\n";
        return 0;
    }

    print SM $$msgref;
    close SM;
    return 1;
}

sub _info 
{
    print "INFO: @_";
}

sub _debug 
{
    print "DEBUG: @_" if $__xmec_debug;
}

sub _error 
{
    print "ERROR: @_";
}

sub _warn 
{
    print "WARNING: @_";
}

#
# vim:ts=4:ai:expandtab:sw=4:
#
1;
