#!/opt/local/bin/perl -w

# Copyright 2010 Magnus Enger Libriotech
#  
# This file is part of Bokhyllesjekker'n.
#  
# Bokhyllesjekker'n is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#  
# Bokhyllesjekker'n is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#  
# You should have received a copy of the GNU General Public License
# along with Bokhyllesjekker'n. If not, see <http://www.gnu.org/licenses/>.
#  
# Source code available from:
# http://github.com/MagnusEnger/bokhyllesjekkern/

use Getopt::Long;
use File::Slurp;
use Data::Dumper;
use Pod::Usage;
use strict;
use diagnostics;

# Get options
my ($bokhyllafile) = get_options();

# Check that the file exists
if (!-e $bokhyllafile) {
  print "The file $bokhyllafile does not exist...\n";
  exit;
}

# Read the file from bokhylla
my @bokhylla = read_file($bokhyllafile);
# Reverse the lines, newest at the top
@bokhylla = reverse(@bokhylla);

# Start PHP array
print '<?php $bokhylla = array(', "\n";

foreach my $bokhyllaline (@bokhylla) {
	# Skip lines starting with #
	next if (substr($bokhyllaline, 0, 1) eq '#');
	# Remove trailing newline
	$bokhyllaline =~ s/\n//g;
	# Split on |
	my ($no, $urn, $oaiids, $sesamids, $isbn, $pages, $title, $creator) = split(/\|/, $bokhyllaline);
	# Pick out the bit we need from the first URN
	my ($firsturn, $moreurn) = split/;/, $urn;
	$firsturn =~ m/URN:NBN:no-nb_(.*?)$/i;
	my $urnfrag = $1;
	# Take care of any ' in $title or $creator
	$title =~ s/'//g;
	$creator =~ s/'//g;
	print "'", '<li><a href="http://www.nb.no/utlevering/pdfbook?id=' . $urnfrag . '" class="searchresult">';
	if ($title) { 
		print $title;
	} else {
		print '[Uten tittel]';	
	}
	if ($creator) {
		print ' / ' . $creator;	
	}
	if ($pages) {
		print ' (' . $pages . ' s.)';
	}
	print '</a></li>', "', ", "\n";
}

# End PHP array
print ');', "\n ?>";

sub get_options {

  # Options
  my $bokhyllafile = '';
  my $help = '';
  
  GetOptions (
    'b|bokhyllafile=s' => \$bokhyllafile, 
	'h|?|help'  => \$help
  );

  pod2usage(-exitval => 0) if $help;
  pod2usage( -msg => "\nMissing Argument: -b, --bokhyllafile required\n", -exitval => 1) if !$bokhyllafile;

  return ($bokhyllafile);

}

__END__

=head1 NAME
    
bokhylla2li.pl - Process the contents of "bokhylla".
        
=head1 SYNOPSIS
            
./bokhylla.pl -b /tmp/public.txt > bokhylla.inc
               
=head1 OPTIONS
              
=over 4
                                                   
=item B<-b, --bokhyllafile>

Name of the file from Bokhylla to be read (wget http://www.nb.no/nbdigital/bokliste/public.txt)

=item B<-h, -?, --help>
                                               
Prints this help message and exits.

=back
                                                               
=cut