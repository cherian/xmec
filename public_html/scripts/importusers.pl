#!/usr/bin/perl --

use lib "/usr162/home/x/m/xmec/scripts";
use xmec_config;
use strict;
use DBI;
use lib "$__xmec_libperl_dir";
use Spreadsheet::ParseExcel::Simple;
use POSIX qw(strftime);

$| = 1;

my $dbh;
my $file = "";
my $sendemail = 1;
my $errstr = "";
my $dryrun = 0;
my $delete = 0;
my $total = 0;

my $emaildir;
my $emailtemplate = "newaccount.msg";
my $from_emailid = "webmasters\@xmec.net";

$| = 1;
$__xmec_debug = 0;

while ($_ = shift, defined ($_) && /^-./) {
    if (/-n/) { 
        $sendemail = 0; 
    } elsif (/-f/) { 
        $file = shift; 
    } elsif (/-t/) { 
        $emailtemplate = shift; 
    } elsif (/-s/) { 
        $from_emailid = shift; 
    } elsif (/-d/) { 
        $dryrun = 1; 
    } elsif (/-e/) { 
        $delete = 1; 
    } elsif (/-v/) { 
        $__xmec_debug = 1; 
    } else {
        last;
    }
}

die "Usage: $0 -f <filename> [-t template] [-s from_email] [-d] [-n] [-e] [-v] 
            filename  : XLS file with user info
            template  : email template to use (default - newaccount.msg)
            from_email: From address to use for email (default - webmasters\@xmec.net)
            -e        : delete from database (default is insert)
            -d        : dry run
            -v        : verbose
            -n        : do not send email\n\n" if (defined($_) || !$file);

&_xmec_initdb;
$dbh = $_xmec_dbh;

if (defined($__xmec_template_dir)) {
    $emaildir = $__xmec_template_dir;
} else {
    _warn "__xmec_template_dir not defined, assuming $__xmec_home/templates\n";
    $emaildir = "$__xmec_home/templates";
}

my %uinfo = ('id' => 'ROLL_NO', 
             'branch' => 'BRANCH', 
             'first_name' => 'FIRST_NAME', 
             'middle_name' => 'MIDDLE_NAME', 
             'last_name' => 'LAST_NAME', 
             'date_of_birth' => 'DOB', 
             'sex' => 'SEX', 
             'personal_email' => 'PERS_EMAIL', 
             'official_email' => 'OFFICIAL_EMAIL', 
             'company' => 'COMPANY');

my %paddr = ('house_name' => 'PERM_HOUSE_NAME', 
             'street' => 'PERM_STREET', 
             'area' => 'PERM_AREA',
             'city' => 'PERM_CITY', 
             'state' => 'PERM_STATE', 
             'country' => 'PERM_COUNTRY', 
             'postal_code' => 'PERM_POSTAL_CODE', 
             'telephone_no' => 'PERM_TELEPHONE');

my %caddr = ('house_name' => 'COMPANY_NAME', 
             'street' => 'COMPANY_STREET', 
             'area' => 'COMPANY_AREA',
             'city' => 'COMPANY_CITY', 
             'state' => 'COMPANY_STATE', 
             'country' => 'COMPANY_COUNTRY', 
             'postal_code' => 'COMPANY_POSTAL_CODE', 
             'telephone_no' => 'COMPANY_TELEPHONE');

my @mand = ('ROLL_NO', 'BRANCH', 'FIRST_NAME', 'PERS_EMAIL');

if ($delete) {
  @mand = ('ROLL_NO');
}

my %order = ();

my $i = 0;
foreach (values %uinfo, values %paddr, values %caddr) {
    $order{$_} = $i++;
}

die "$file : $! " unless -r $file;

_info "Processing $file ...\n";
my $xls = Spreadsheet::ParseExcel::Simple->read("$file");
my ($sheet) = $xls->sheets;

$sheet->next_row; # skip first row

my $found;
$i = 0;
foreach my $row ($sheet->next_row) {
    $found = 0;
    foreach (values %uinfo, values %paddr, values %caddr) {
        if ($_ =~ /$row/) {$found = 1; $order{$_} = $i; last;}
    }
    $i++;
    if (!$found && $row != "") { _warn "Invalid column $row, ignoring...\n"; }
}

foreach (@mand) {
    do {
        _error "Mandatory column, $_ not found, aborting...\n";
        exit 1;
    } unless defined $order{$_};
}

_info "Processing entries ...\n";

my $i = 2; # used as row count.
my @invalid = ();
ROW: while ($sheet->has_data) {
    my @row = $sheet->next_row;
    $i++;
    foreach (@mand) {
        do {
            _warn "Empty $_, ignoring row $i\n";
            push (@invalid, $i);
            next ROW;
        } unless $row[$order{$_}];
    }
            
    my $uid;
    my $passwd;
    my $regno = $row[$order{$uinfo{'id'}}];

    if ($delete) {
      _info "Deleting user $regno ...\n";
      delete_user($regno);
      delete_auth($regno);
      delete_address($regno, 'PERMANENT');
      delete_address($regno, 'COMPANY');
      delete_address($regno, 'PRESENT');
      next ROW;
    }

    ###
    # Insert into db
    #
    _info "Adding user $regno ...\n";
    if ($uid = find_user($regno)) {
        # user details exits 
        _error "Ignoring $regno - already exists.\n";
        push (@invalid, $i);
        next ROW;
    }

    _error "Ignoring $regno - Adding user info failed ($errstr).\n",
    push (@invalid, $i),
    next ROW unless $uid = add_user(\@row);

    _error "Ignoring $regno - Adding login info failed ($errstr).\n",
    push (@invalid, $i),
    delete_user($uid),
    next ROW unless $passwd = add_auth(\@row, $uid);

    _error "Ignoring $regno - Adding perm address failed ($errstr).\n",
    push (@invalid, $i),
    delete_user($uid),
    delete_auth($uid),
    next ROW unless add_address(\@row, $uid, 'PERMANENT');

    _error "Ignoring $regno - Adding comp address failed ($errstr).\n",
    push (@invalid, $i),
    delete_user($uid),
    delete_auth($uid),
    delete_address($uid, 'PERMANENT'),
    next ROW unless add_address(\@row, $uid, 'COMPANY');

    _info "User $regno added.\n";

    if ($sendemail) {
        $total += 1;
        if ($total > 50) { _debug "Sleeping 10 secs.."; sleep(15); $total = 0; }
        send_email($regno, $passwd, \@row) or 
            _warn "Sending mail failed for $regno : $errstr.\n";
    }
}


exit 0; # We are done

#############

sub add_user
{
    my ($l) = @_ ;
    my @vals = ();
 
    unless (@$l[$order{$uinfo{'id'}}]) {
        $errstr = $uinfo{'id'}." not found"; 
        return 0;
    }
    
    # TODO: nn/yyyy format conversion ??

    my $q = "INSERT INTO xmec_user SET ";
     
    foreach (keys %uinfo) {
        $q .= "$_ = ?, ", push (@vals, @$l[$order{$uinfo{$_}}]) 
            if @$l[$order{$uinfo{$_}}];
    }
      
    my $id = @$l[$order{$uinfo{'id'}}];
    $q .= "alias = ?,", push (@vals, $id);
    $q .= "preferences = 0";

    if (!$dryrun) {
        my $sth = $dbh->prepare($q) 
            or do { $errstr = $dbh->errstr; return 0; };

        $dbh->do("LOCK TABLES xmec_user WRITE")
            or do { $errstr = $dbh->errstr; return 0; };

        $sth->execute(@vals);

        $q = "SELECT id FROM xmec_user WHERE alias = '$id'";
        my ($c1) = $dbh->selectrow_array($q) or do { $errstr = $dbh->errstr; };

        $dbh->do("UNLOCK TABLES") or die $dbh->errstr;

        return $c1;
    }

    return 1;
}

sub add_auth
{
    my ($l, $uid) = @_;

    my $pass = int(rand(999999));

    if (!$uid) {
        _error "error adding auth: not enough info\n";
        $errstr = "not enough info";
        return 0;
    }

    if (!$dryrun) {
        $dbh->do(qq{
            INSERT INTO xmec_auth SET user_id = '$uid',
            type = 'NORMAL',
            password = PASSWORD('$pass')}
        ) or do { $errstr = $dbh->errstr; return 0; };
    }

    return $pass;
}

sub add_address
{
    my ($l, $uid, $type) = @_;

    my $hash;
    if ($type =~ /COMPANY/) {
        $hash = \%caddr;
    } elsif ($type =~ /PERMANENT/) {
        $hash = \%paddr;
    } else {
        $errstr = "Invalid type";
        return 0;
    }

    my @vals = ();
    my $q = "INSERT INTO xmec_address SET ";

    foreach (keys %$hash) {
        my %tmp1 = %$hash;
        my $tmp = $tmp1{$_};
        $q .= "$_ = ?, ", push (@vals, @$l[$order{$tmp}]) 
            if @$l[$order{$tmp}];
    }
      
    $q .= "type = ?, ", push (@vals, $type);
    $q .= "user_id = ?, ", push (@vals, $uid);
    $q .= "visibility = 'XMEC'";

    my $ret = 1;
    if (!$dryrun) {
        $dbh->do("LOCK TABLES xmec_address WRITE")
            or do { $errstr = $dbh->errstr; return 0; };

        $dbh->do($q, undef, @vals)
            or do { $errstr = $dbh->errstr; $ret = 0; };

        $dbh->do("UNLOCK TABLES") or die $dbh->errstr;
    }

    _debug "added $type address.\n" if $ret;
    return $ret;
}

sub find_user
{
    if (!$dryrun) {
        my ($c1) = $dbh->selectrow_array(q{
            SELECT id from xmec_user where id = ?
            }, undef, @_) ; # or die $dbh->errstr;
        return $c1;
    }

    return 0;
}

sub delete_address
{
    my ($uid, $type) = @_;
    _debug "delete_address ($uid, $type)\n";

    if (!$dryrun) {
        $dbh->do(qq{
            DELETE xmec_address WHERE user_id = '$uid' AND
            type = '$type'}); # or die $dbh->errstr;
    }
}

sub delete_user
{
    my ($uid) = @_;
    _debug "delete_user ($uid)\n";

    if (!$dryrun) {
        $dbh->do(qq{
            DELETE xmec_user WHERE id = '$uid'}); # or die $dbh->errstr;
    }
}

sub delete_auth
{
    my ($uid) = @_;
    _debug "delete_auth ($uid)\n";

    if (!$dryrun) {
        $dbh->do(qq{
            DELETE xmec_auth WHERE user_id = '$uid'}); # or die $dbh->errstr;
    }
}

sub send_email
{
    my ($regno, $passwd, $l) = @_;

    _debug "Sending email...\n";
    unless (@$l[$order{$uinfo{'personal_email'}}]) {
        $errstr = $uinfo{'personal_email'}." not found"; 
        return 0;
    }

    local ($_);
    my $msg = "";
    unless (open (MAIL, "<$emaildir/$emailtemplate")) {
        $errstr = "$emaildir/$emailtemplate: $!";
        return 0;
    }

    my $name = @$l[$order{$uinfo{'first_name'}}];
    $name .= " ". @$l[$order{$uinfo{'middle_name'}}];
    $name .= " ". @$l[$order{$uinfo{'last_name'}}];

    my $first_name = @$l[$order{$uinfo{'first_name'}}];
    my $middle_name = @$l[$order{$uinfo{'middle_name'}}];
    my $last_name = @$l[$order{$uinfo{'last_name'}}];
    my $personal_email = @$l[$order{$uinfo{'personal_email'}}];
    my $official_email = @$l[$order{$uinfo{'official_email'}}];

    while (<MAIL>) {
        s/%from%/$from_emailid/ig;
        s/%name%/$name/ig;
        s/%first_name%/$first_name/ig;
        s/%middle_name%/$middle_name/ig;
        s/%last_name%/$last_name/ig;
        s/%rollno%/$regno/ig;
        s/%id%/$regno/ig;
        s/%password%/$passwd/ig;
        s/%passwd%/$passwd/ig;
        s/%email%/$personal_email/ig;
        s/%personal_email%/$personal_email/ig;
        s/%official_email%/$official_email/ig;
        $msg .= $_;
    }

    my $ret = 1;
    $ret = xmec_send_mail(\$msg) unless ($dryrun);
    _debug "Sent mail.\n";
    return $ret;
}

# vim:ts=4:ai:expandtab:sw=4:
