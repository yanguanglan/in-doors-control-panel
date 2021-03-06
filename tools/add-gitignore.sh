#!/bin/sh

# Make git add empty directories to the repository
# https://gist.github.com/justinfrench/18780
#
# Recursively add a .gitignore file to all directories
# in the working directory which are empty and don't
# start with a dot. Helpful for tracking empty dirs
# in a git repository.

for i in $(find . -type d -regex ``./[^.].*'' -empty); do touch $i"/.gitignore"; done;
