Projects-Importer
=================

Creates a WordPress WXR File From Make:Projects

Usage
-----

From the command line, I run this: 

	curl -o projects.xml localhost:8888/projects-importer/

Batch
-----

If you want to batch the process out, you can do something like this:
	
	curl "http://localhost:8888/projects-importer/?offset={200,400,600,800,1000,1200,1400,1600,1800,2000,2200,2400,2600,2800,3000,3200,3400,3600,3800}" -o "projects-export-#1.xml"