help:
	@echo "Please use \`make <target>' where <target> is one of"
	@echo "  clean          to delete all Makefile artifacts"
	@echo "  package        to package a phar and zip file for a release"

clean:
	rm -rf build/artifacts/*

# Packages the phar and zip
package:
	php build/packager.php $(SERVICE)
