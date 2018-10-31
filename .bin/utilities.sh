#!/usr/bin/env bash
#
# Utility functions to aid with setting up a local installation.

#######################################
# Ask a question of the user.
# Arguments:
#   Question to display to and ask of the user.
# Returns:
#   Answer to the question. One of: [y, n]
#######################################
ask_yes_no() {
	QUESTION=$1

	while :
	do
        read -r -p $'\e[32m'"$QUESTION"$' [y/N]: \e[0m' SHOULD_DO

		# Ensure that variable is caught and parsed correctly.
	    SHOULD_DO_ANSWER=$(echo "$SHOULD_DO" | tr '[:upper:]' '[:lower:]')

		# Evaluate output
		case "$SHOULD_DO_ANSWER" in
			y|"yes")
				echo "y"
				return
				;;
			n|"no"|"")
				echo "n"
				return
				;;
			*)
				echo "Please answer yes or no."
				;;
		esac
	done
}

#######################################
# Print a friendly message to the screen.
# Arguments:
#   Message to display
# Returns:
#   None
#######################################
print_message() {
	MESSAGE=$1

	echo tput setaf 2 "\n  $MESSAGE" tput sgr0
}

#######################################
# Print an error message to the screen.
# Arguments:
#   Message to display
# Returns:
#   None
#######################################
print_error() {
	MESSAGE=$1

	tput setaf 1 "\n  $MESSAGE" tput sgr0
}

#######################################
# Ensure that a user has required software installed before continuing.
# Arguments:
#   None
# Returns:
#   None
#######################################
check_for_software() {
	HAS_VAGRANT=`command -v vagrant 2&>/dev/null || echo "false"`
	HAS_COMPOSER=`command -v composer 2&>/dev/null || echo "false"`
	HAS_NODE=`command -v node 2&>/dev/null || echo "false"`

	if [[ $HAS_COMPOSER = "false" ]]; then
		print_error "You must have Composer installed to continue"
		print_error "Go to https://getcomposer.org/doc/00-intro.md#manual-installation for more"
		exit;
	fi

	if [[ $HAS_VAGRANT = "false" ]]; then
		print_error "You must have Vagrant installed to continue"
		print_error "Go to https://www.vagrantup.com/downloads.html for more."
		exit;
	fi

	# @todo:: also check Node version
	if [[ $HAS_NODE = "false" ]]; then
        print_error "You must have Node installed to continue"
        print_error "Go to https://nodejs.org/en/download/ for more"
		exit;
    fi
}

#######################################
# Ensure all submodules are installed.
# Arguments:
#   None
# Returns:
#   None
#######################################
install_submodules() {
    print_message "🕚 Installing Git dependencies"

    git submodule update --init --recursive
}

#######################################
# Install all composer dependencies.
# Arguments:
#   None
# Returns:
#   None
#######################################
install_composer() {
    print_message "🕚 Installing PHP dependencies"

    composer install
}

#######################################
# Install all npm dependencies.
# Arguments:
#   None
# Returns:
#   None
#######################################
install_npm() {
    print_message "🕚 Installing frontend dependencies"

    npm install

    # Running the production build to get the user started.
    npm run build
}

#######################################
# Setup Chassis in the appropriate folder.
# Arguments:
#   None
# Returns:
#   None
#######################################
setup_chassis() {
    # Clone and pull down Chassis.
    if [[ ! -d chassis ]]; then
        print_message "🕚 Cloning Chassis"
        git clone --progress --recursive git@github.com:Chassis/Chassis.git .
    fi

    print_message "🚚 Moving Config Files"

    # If we have a custom configuration, copy it into the right Chassis subdir.
    if [ -f "config.local.yaml" ]
    then
        if [[ ! -d "chassis/content" ]]; then
            mkdir chassis/content/
        fi

        cp config.local.yaml chassis/content/config.local.yaml
    fi

    # Copy the local WordPress config file.
    cp local-config.php chassis/local-config.php

    # Copy the default Chassis config
    cp config.yaml chassis/config.local.yaml

    print_message "🕚 Starting up our machine"

    cd chassis/
    vagrant up
    cd ../
}

#######################################
# Open a URL using methods available on the system
# Arguments:
#   URL to open
# Returns:
#   None
#######################################
openurl() {
	if hash xdg-open 2>/dev/null; then
		xdg-open "$@"
	else
		open "$@"
	fi
}

#######################################
# If the user desires, open the site in their browser.
# Arguments:
#   LOCAL_HOST Host name to use for local site.
# Returns:
#   None
#######################################
maybe_open_site() {
    SHOULD_OPEN=$(ask_yes_no "Open WordPress Login page in your browser?")

    if [ "$SHOULD_OPEN" == "y" ];
    then
        openurl http://chassis.local/wp-admin/
    fi
}
