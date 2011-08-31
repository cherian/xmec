#!/usr/bin/perl
##############################################################################
# Guestbook                     Version 2.3.1                                #
# Copyright 1996 Matt Wright    mattw@worldwidemart.com                      #
# Created 4/21/95               Last Modified 10/29/95                       #
# Scripts Archive at:           http://www.worldwidemart.com/scripts/        #
##############################################################################
# COPYRIGHT NOTICE                                                           #
# Copyright 1996 Matthew M. Wright  All Rights Reserved.                     #
#                                                                            #
# Guestbook may be used and modified free of charge by anyone so long as     #
# this copyright notice and the comments above remain intact.  By using this #
# code you agree to indemnify Matthew M. Wright from any liability that      #  
# might arise from it's use.                                                 #  
#                                                                            #
# Selling the code for this program without prior written consent is         #
# expressly forbidden.  In other words, please ask first before you try and  #
# make money off of my program.                                              #
#                                                                            #
# Obtain permission before redistributing this software over the Internet or #
# in any other medium.	In all cases copyright and header must remain intact.#
##############################################################################
# Set Variables

$guestbookurl = "http://www.xmec.net/guestbook.php";
$guestbookreal = "/usr162/home/x/m/xmec/public_html/guestbook.php";
$guestlog = "/usr162/home/x/m/xmec/public_html/guestbook/guestlog.html";
$cgiurl = "http://xmec.net/guestbook/guestbook.pl";
$date_command = "/bin/date";

# Set Your Options:
$mail = 0;              # 1 = Yes; 0 = No
$uselog = 1;            # 1 = Yes; 0 = No
$linkmail = 0;          # 1 = Yes; 0 = No
$separator = 0;         # 1 = <hr>; 0 = <p>
$redirection = 1;       # 1 = Yes; 0 = No
$entry_order = 1;       # 1 = Newest entries added first;
                        # 0 = Newest Entries added last.
$remote_mail = 0;       # 1 = Yes; 0 = No
$allow_html = 1;        # 1 = Yes; 0 = No
$line_breaks = 1;	# 1 = Yes; 0 = No

# If you answered 1 to $mail or $remote_mail you will need to fill out 
# these variables below:
$mailprog = '/usr/sbin/sendmail';
$recipient = 'webmaster@xmec.net';

# Done
##############################################################################

# Get the Date for Entry
$date = `$date_command +"%A, %B %d, %Y at %T (%Z)"`; chop($date);
$shortdate = `$date_command +"%D %T %Z"`; chop($shortdate);

# Get the input
read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});

# Split the name-value pairs
@pairs = split(/&/, $buffer);

foreach $pair (@pairs) {
   ($name, $value) = split(/=/, $pair);

   # Un-Webify plus signs and %-encoding
   $value =~ tr/+/ /;
   $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
   $value =~ s/<!--(.|\n)*-->//g;

   if ($allow_html != 1) {
      $value =~ s/<([^>]|\n)*>//g;
   }

   $FORM{$name} = $value;
}

# Print the Blank Response Subroutines
&no_comments unless $FORM{'comments'};
&no_name unless $FORM{'realname'};

# Begin the Editing of the Guestbook File
open (FILE,"$guestbookreal") || die "Can't Open $guestbookreal: $!\n";
@LINES=<FILE>;
close(FILE);
$SIZE=@LINES;

# Open Link File to Output
open (GUEST,">$guestbookreal") || die "Can't Open $guestbookreal: $!\n";

for ($i=0;$i<=$SIZE;$i++) {
   $_=$LINES[$i];
   if (/<!--begin-->/) { 

      if ($entry_order eq '1') {
         print GUEST "<!--begin-->\n";
      }

	  print GUEST '<center><table border="0" cellpadding="0" cellspacing="0" width="90%"> <tbody> <tr> <td height="4" width="4"><img src="images/corner.gif" height="4" width="4"></td> <td align="left" background="images/tb_top.gif" height="4"><img src="images/tb_left_topt.gif" height="4" width="8"></td> <td align="right" background="images/tb_top.gif" height="4"><img src="images/tb_right_topt.gif" height="4" width="8"></td> <td height="4" width="4"><img src="images/corner.gif" height="4" width="4"></td> </tr> <tr> <td background="images/tb_left.gif" height="50%" valign="top" width="4"><img src="images/tb_left_topb.gif" height="6" width="3"></td> <td colspan="2" rowspan="2">';
   
      if ($line_breaks == 1) {
         $FORM{'comments'} =~ s/\cM\n/<br>\n/g;
      }

	  print GUEST "<table width='100%' border=0>";
      print GUEST "<tr><td><b> $FORM{'comments'}</b><hr></td></tr>\n";

	  print GUEST "<tr bgcolor=\"#cfddd1\"><td>";

      if ( $FORM{'username'} ){
         if ($linkmail eq '1') {
            print GUEST " \&lt;<a href=\"mailto:$FORM{'username'}\">";
            print GUEST "$FORM{'username'}</a>\&gt;";
         }
         else {
            print GUEST "$FORM{'username'}&nbsp;&nbsp;";
         }
      }

      if ($FORM{'url'}) {
         #print GUEST "<a href=\"http:\/\/$FORM{'url'}\">$FORM{'realname'}</a>";
      }
      else {
         #print GUEST "<a href=\"mailto:$FORM{'username'}\">$FORM{'realname'}</a>";
	print GUEST "<a href=\"http:\/\/xmec.net\/view_details.php\?\.s\=1\&id\=$FORM{'username'}\">$FORM{'realname'}</a>";
      }

      print GUEST "</td></tr><tr bgcolor=\"#cfddd1\"><td>\n";

      if ( $FORM{'city'} ){
         print GUEST "$FORM{'city'},";
      }
     
      if ( $FORM{'state'} ){
         print GUEST " $FORM{'state'}";
      }

      if ( $FORM{'country'} ){
         print GUEST " $FORM{'country'}";
      }

      if ($separator eq '1') {
         print GUEST " - $date<hr>\n\n";
      }
      else {
         print GUEST " - $date<p>\n\n";
      }

	print GUEST "</td></tr></table>";

      if ($entry_order eq '0') {
         print GUEST "<!--begin-->\n";
      }

    print GUEST '</td> <td background="images/tb_right.gif" height="50%" valign="top" width="4"><img src="images/tb_right_topb.gif" height="6" width="3"></td> </tr> <tr> <td background="images/tb_left.gif" height="50%" valign="bottom" width="4"><img src="images/tb_left_bottomb.gif" height="6" width="3"></td> <td background="images/tb_right.gif" height="50%" valign="bottom" width="4"><img src="images/tb_right_bottomb.gif" height="6" width="3"></td> </tr> <tr> <td height="4" width="4"><img src="images/corner.gif" height="4" width="4"></td> <td align="left" background="images/tb_bottom.gif" height="4"><img src="images/tb_left_bottomt.gif" height="4" width="8"></td> <td align="right" background="images/tb_bottom.gif" height="4"><img src="images/tb_right_bottomt.gif" height="4" width="8"></td> <td height="4" width="4"><img src="images/corner.gif" height="4" width="4"></td> </tr> </tbody> </table><center><br>';

   }
   else {
      print GUEST $_;
   }
}

close (GUEST);

# Log The Entry

if ($uselog eq '1') {
   &log('entry');
}


#########
# Options

# Mail Option
if ($mail eq '1') {
   open (MAIL, "|$mailprog $recipient") || die "Can't open $mailprog!\n";

   print MAIL "Reply-to: $FORM{'username'} ($FORM{'realname'})\n";
   print MAIL "From: $FORM{'username'} ($FORM{'realname'})\n";
   print MAIL "Subject: Entry to Guestbook\n\n";
   print MAIL "You have a new entry in your guestbook:\n\n";
   print MAIL "------------------------------------------------------\n";
   print MAIL "$FORM{'comments'}\n";
   print MAIL "$FORM{'realname'}";

   if ( $FORM{'username'} ){
      print MAIL " <$FORM{'username'}>";
   }

   print MAIL "\n";

   if ( $FORM{'city'} ){
      print MAIL "$FORM{'city'},";
   }

   if ( $FORM{'state'} ){
      print MAIL " $FORM{'state'}";
   }

   if ( $FORM{'country'} ){
      print MAIL " $FORM{'country'}";
   }

   print MAIL " - $date\n";
   print MAIL "------------------------------------------------------\n";

   close (MAIL);
}

if ($remote_mail eq '1' && $FORM{'username'}) {
   open (MAIL, "|$mailprog -t") || die "Can't open $mailprog!\n";

   print MAIL "To: $FORM{'username'}\n";
   print MAIL "From: $recipient\n";
   print MAIL "Subject: Entry to Guestbook\n\n";
   print MAIL "Thank you for adding to my guestbook.\n\n";
   print MAIL "------------------------------------------------------\n";
   print MAIL "$FORM{'comments'}\n";
   print MAIL "$FORM{'realname'}";

   if ( $FORM{'username'} ){
      print MAIL " <$FORM{'username'}>";
   }

   print MAIL "\n";

   if ( $FORM{'city'} ){
      print MAIL "$FORM{'city'},";
   }

   if ( $FORM{'state'} ){
      print MAIL " $FORM{'state'}";
   }

   if ( $FORM{'country'} ){
     print MAIL " $FORM{'country'}";
   }

   print MAIL " - $date\n";
   print MAIL "------------------------------------------------------\n";

   close (MAIL);
}

# Print Out Initial Output Location Heading
if ($redirection eq '1') {
   print "Location: $guestbookurl\n\n";
}
else { 
   &no_redirection;
}

#######################
# Subroutines

sub no_comments {
   print "Content-type: text/html\n\n";
   print "<html><head><title>No Comments</title></head>\n";
   print "<body><h1>Your Comments appear to be blank</h1>\n";
   print "The comment section in the guestbook fillout form appears\n";
   print "to be blank and therefore the Guestbook Addition was not\n";
   print "added.  Please enter your comments below.<p>\n";
   print "<form method=POST action=\"$cgiurl\">\n";
   print "Your Name:<input type=text name=\"realname\" size=30 ";
   print "value=\"$FORM{'realname'}\"><br>\n";
   print "E-Mail: <input type=text name=\"username\""; 
   print "value=\"$FORM{'username'}\" size=40><br>\n";
   print "City: <input type=text name=\"city\" value=\"$FORM{'city'}\" ";
   print "size=15>, State: <input type=text name=\"state\" "; 
   print "value=\"$FORM{'state'}\" size=15> Country: <input type=text "; 
   print "name=\"country\" value=\"$FORM{'country'}\" size=15><p>\n";
   print "Comments:<br>\n";
   print "<textarea name=\"comments\" COLS=60 ROWS=4></textarea><p>\n";
   print "<input type=submit> * <input type=reset></form><hr>\n";
   print "Return to the <a href=\"$guestbookurl\">Guestbook</a>.";
   print "\n</body></html>\n";

   # Log The Error
   if ($uselog eq '1') {
      &log('no_comments');
   }

   exit;
}

sub no_name {
   print "Content-type: text/html\n\n";
   print "<html><head><title>No Name</title></head>\n";
   print "<body><h1>Your Name appears to be blank</h1>\n";
   print "The Name Section in the guestbook fillout form appears to\n";
   print "be blank and therefore your entry to the guestbook was not\n";
   print "added.  Please add your name in the blank below.<p>\n";
   print "<form method=POST action=\"$cgiurl\">\n";
   print "Your Name:<input type=text name=\"realname\" size=30><br>\n";
   print "E-Mail: <input type=text name=\"username\"";
   print " value=\"$FORM{'username'}\" size=40><br>\n";
   print "City: <input type=text name=\"city\" value=\"$FORM{'city'}\" ";
   print "size=15>, State: <input type=text name=\"state\" ";
   print "value=\"$FORM{'state'}\" size=2> Country: <input type=text ";
   print "value=USA name=\"country\" value=\"$FORM{'country'}\" ";
   print "size=15><p>\n";
   print "Comments have been retained.<p>\n";
   print "<input type=hidden name=\"comments\" ";
   print "value=\"$FORM{'comments'}\">\n";
   print "<input type=submit> * <input type=reset><hr>\n";
   print "Return to the <a href=\"$guestbookurl\">Guestbook</a>.";
   print "\n</body></html>\n";

   # Log The Error
   if ($uselog eq '1') {
      &log('no_name');
   }

   exit;
}

# Log the Entry or Error
sub log {
   $log_type = $_[0];
   open (LOG, ">>$guestlog");
   if ($log_type eq 'entry') {
      print LOG "$ENV{'REMOTE_ADDR'} - [$shortdate]<br>\n";
   }
   elsif ($log_type eq 'no_name') {
      print LOG "$ENV{'REMOTE_ADDR'} - [$shortdate] - ERR: No Name<br>\n";
   }
   elsif ($log_type eq 'no_comments') {
      print LOG "$ENV{'REMOTE_ADDR'} - [$shortdate] - ERR: No ";
      print LOG "Comments<br>\n";
   }
}

# Redirection Option
sub no_redirection {

   # Print Beginning of HTML
   print "Content-Type: text/html\n\n";
   print "<html><head><title>Thank You</title></head>\n";
   print "<body><h1>Thank You For Signing The Guestbook</h1>\n";

   # Print Response
   print "Thank you for filling in the guestbook.  Your entry has\n";
   print "been added to the guestbook.<hr>\n";
   print "Here is what you submitted:<p>\n";

#   print "<b>$FORM{'comments'}</b><br>\n";

#   if ($FORM{'url'}) {
#      print "<a href=\"http:\/\/$FORM{'url'}\">$FORM{'realname'}</a>";
#   }
#   else {
#      print "$FORM{'realname'}";
#   }

#   if ( $FORM{'username'} ){
#      if ($linkmail eq '1') {
#         print " &lt;<a href=\"mailto:$FORM{'username'}\">";
#         print "$FORM{'username'}</a>&gt;";
#      }
#      else {
#         print " &lt;$FORM{'username'}&gt;";
#      }
#   }

#   print "<br>\n";

#   if ( $FORM{'city'} ){
#      print "$FORM{'city'},";
#   }

#   if ( $FORM{'state'} ){
#      print " $FORM{'state'}";
#   }

#   if ( $FORM{'country'} ){
#      print " $FORM{'country'}";
#   }

#   print " - $date<p>\n";
	  print '<center><table border="0" cellpadding="0" cellspacing="0" width="90%"> <tbody> <tr> <td height="4" width="4"><img src="images/corner.gif" height="4" width="4"></td> <td align="left" background="images/tb_top.gif" height="4"><img src="images/tb_left_topt.gif" height="4" width="8"></td> <td align="right" background="images/tb_top.gif" height="4"><img src="images/tb_right_topt.gif" height="4" width="8"></td> <td height="4" width="4"><img src="images/corner.gif" height="4" width="4"></td> </tr> <tr> <td background="images/tb_left.gif" height="50%" valign="top" width="4"><img src="images/tb_left_topb.gif" height="6" width="3"></td> <td colspan="2" rowspan="2">';
   
      if ($line_breaks == 1) {
         $FORM{'comments'} =~ s/\cM\n/<br>\n/g;
      }

	  print "<table width='100%' border=0>";
      print "<tr><td><b> $FORM{'comments'}</b><hr></td></tr>\n";

	  print "<tr bgcolor=\"#cfddd1\"><td>";
      if ($FORM{'url'}) {
         print "<a href=\"http:\/\/$FORM{'url'}\">$FORM{'realname'}</a>";
      }
      else {
         print "$FORM{'realname'}";
      }

      if ( $FORM{'username'} ){
         if ($linkmail eq '1') {
            print " \&lt;<a href=\"mailto:$FORM{'username'}\">";
            print "$FORM{'username'}</a>\&gt;";
         }
         else {
            print " &lt;$FORM{'username'}&gt;";
         }
      }

      print "</td></tr><tr bgcolor=\"#cfddd1\"><td>\n";

      if ( $FORM{'city'} ){
         print "$FORM{'city'},";
      }
     
      if ( $FORM{'state'} ){
         print " $FORM{'state'}";
      }

      if ( $FORM{'country'} ){
         print " $FORM{'country'}";
      }

      if ($separator eq '1') {
         print " - $date<hr>\n\n";
      }
      else {
         print " - $date<p>\n\n";
      }

	print "</td></tr></table>";

      if ($entry_order eq '0') {
         print "<!--begin-->\n";
      }

    print '</td> <td background="images/tb_right.gif" height="50%" valign="top" width="4"><img src="images/tb_right_topb.gif" height="6" width="3"></td> </tr> <tr> <td background="images/tb_left.gif" height="50%" valign="bottom" width="4"><img src="images/tb_left_bottomb.gif" height="6" width="3"></td> <td background="images/tb_right.gif" height="50%" valign="bottom" width="4"><img src="images/tb_right_bottomb.gif" height="6" width="3"></td> </tr> <tr> <td height="4" width="4"><img src="images/corner.gif" height="4" width="4"></td> <td align="left" background="images/tb_bottom.gif" height="4"><img src="images/tb_left_bottomt.gif" height="4" width="8"></td> <td align="right" background="images/tb_bottom.gif" height="4"><img src="images/tb_right_bottomt.gif" height="4" width="8"></td> <td height="4" width="4"><img src="images/corner.gif" height="4" width="4"></td> </tr> </tbody> </table><center><br>';


   # Print End of HTML
   print "<hr>\n";
   print "<a href=\"$guestbookurl\">Back to the Guestbook</a>\n";         print "- You may need to reload it when you get there to see your\n";
   print "entry.\n";
   print "</body></html>\n";

   exit;
}

