#!/bin/bash

ASSETS_SRC="$PWD/assets"
DISTDIR="$PWD/wp-dist"
SVNDIR="$PWD/wp-svn"
ASSETS_TARGET="$SVNDIR/assets"

if [ ! -d $DISTDIR ]; then
	echo "Missing wp-dist dir, expected to find at: $DISTDIR"
	exit 1
fi

if [ ! -d $SVNDIR ]; then
	echo "Missing wp-svn dir, expected to find at: $SVNDIR"
	exit 1
fi

if [ ! -d $ASSETS_TARGET ]; then
	echo "Missing wp-svn/assets dir, expected to find at: $ASSETS_TARGET"
	exit 1
fi

set -x

echo "Clearing out target assets..."
rm -f $ASSETS_TARGET/*

echo "Copying plugin directory assets from git to svn..."
cp $ASSETS_SRC/* $ASSETS_TARGET/
