#!/bin/bash

# if [ stat --printf="%s" public.txt -lt stat --printf="%s" public.txt.1 ]  
# 	echo "public.txt.1 is biggest"
# fi

mv public.txt.1 public.txt

perl bokhylla2li.pl -b public.txt > bokhylla.inc
