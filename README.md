Yes, I still play version 1.  This is just an experiment, and is not even to
the experimentation phase on the plugin side yet.  Only using it in command
line mode for the moment, and only updating this repository on occasion.

Don't try this as the repo may be broken.

'Dungeons and Dragons' is copyrighted by TSR ( or whoever owns it now )
Used without permission.

# DnD First Edition #

## Plugin mode ##

The only thing that works is the admin screen with the procedure to import
character csv files, but without the correct csv format, that's useless.
See the section below for more info.

## Commandline mode ##

The DND_FIRST_EDITION_DIR constant has to be set to program base directory.  It
is located in command_line/setup.php.  Also in that file is the CSV_PATH
constant. Don't know what to tell you about that one, since my csv character
files are exports from a gnumeric spreadsheet, which is not in this repository.
And without that, you can't import a character, which renders this whole thing
useless for your purposes.  I suppose characters could be entered into the
command_line/characters.php file manually, but I'll leave that to anyone who
wants to try it.  Let me know how it works out...

Be sure to set up a transient directory (outside the program directory), and
define the DND_TRANSIENT_DIR constant located in the command_line/functions.php file.

### Treasure ###

treasure.php, in the command_line directory, is written to be run in standalone
mode.  Run by itself, it will display the main magic item table.  With a numeric
parameter, it will display the corresponding sub-table. In a few cases more
numeric parameters may display more information.
