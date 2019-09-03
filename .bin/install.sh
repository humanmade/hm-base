#!/bin/bash
set -euo pipefail
IFS=$'\n\t'

#
# Scripts to setup a local development environment.

# Import our utilities.
. .bin/utilities.sh

# Fail on any error (and yes, I know this not perfect)
set -e

IFS= read -d '' -r HEADER <<"EOF" ||:
      :+oo/      .hmNh    oyy. /dMMm:   /syo.
   +dMMMMMMN.    oMMMy   :MMM+mMMMMMN oNMMMMm
  mMNo-.dMMM+    dMMM+   oMMMMM+ dMMMmMdhMMMN
  ++    sMMMo    NMMM.   yMMMM:  hMMMM+ .MMMd
        yMMM+   .MMMM:/+oNMMMs   NMMMo  :MMMs
        hMMMo/oydMMMMMMMMMMMM.   MMMN   oMMM+
       /NMMMMMMNmMMMh-. .MMMd   :MMMh   yMMM-
    +dMMMMMM/-  oMMMo   :MMMs   +MMMo   dMMM
  oNMMy+MMMN    sMMMo   +MMM+   sMMM:   mMMM
.mMMh. /MMMh    sMMMo   sMMM:   +ddy    hMMM-
hMMy   sMMM+    +MMMh   hMMM.           :MMMNs+os
MMM-   NMMN     .MMMM:  -/:.             :hNMMMMh
dMMh:/mMMN:      +MMMMy:..-/s.               ..
 yMMMMMMy.        -hMMMMMMMNh-
   -/:-              -///:.
EOF

echo "$HEADER"

check_for_software

install_submodules
install_composer
install_npm

setup_chassis

print_message "✅ Installation Complete"

maybe_open_site
