#!/bin/sh

# Changed by Tuomas Airaksinen <tuomas.airaksinen@tuma.stc.cx> and
# Maarten den Braber <mdb@twister.cx>
# Original script by Garrett LeSage <garrett@linux.com>
# Description feature by Maximiliano Garcia Silva (maxgs@bigfoot.com)

# This script converts images in the current directory to a
# thumbnail version (200x160) and a 'big' version (800x640). 
#
# You need ImageMagick (http://www.imagemagick.org) for this script
# in order to work.
#
# HINT: Even the images are already 640x480 it's still useful to
# convert them, because this minimizes the size of the images.

###############
#CONFIGURATION#
###############

# The place where this script places images:

THUMBS="thumbnails"
FULL="big"

# The file format you wish to change

FROM=jpg

# The end result file format
TO=jpg

# Description | <yes> <no>^M
DESCRIPTION=no



######################
#END OF CONFIGURATION#
######################

echo Running $0
echo

if [ ! -s $THUMBS ] 
then
	mkdir $THUMBS
fi

if [ ! -s $FULL ] 
then 	
	mkdir $FULL
fi

COUNT=0

for i in `ls *.$FROM`;
	do
	
	COUNT=`expr $COUNT + 1`

	CONVERT_OPTIONS='-quality 75 -geometry  200x160'
	_thumbs=`basename $i $FROM`$TO
	if [ ! -s "$THUMBS/$_thumbs" ] 
	then
		echo Thumbnailing $i...
		echo      convert $CONVERT_OPTIONS $i $THUMBS/$_thumbs 
		convert $CONVERT_OPTIONS $i $THUMBS/$_thumbs
	fi
	
	echo Converting $i...
	CONVERT_OPTIONS='-quality 75 -geometry  800x640'
	_full=`basename $i $FROM`$TO
	if [ ! -s "$FULL/$_full" ] 
	then
		echo      convert $CONVERT_OPTIONS $i $FULL/$_full
		convert $CONVERT_OPTIONS $i $FULL/$_full
	fi
	
done;

if [ "$DESCRIPTION" = "no" ]; then
  ls | grep -v php | grep -v txt | grep -v / > pictureinfo-en.txt
fi

exit;
