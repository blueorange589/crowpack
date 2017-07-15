# GIT
Add project to existing repository

		git init
		git add .
		git commit -m 'First commit'
		git remote add origin repourl
		git remote -v
		git push -f origin master

Clone project

    git clone git@github.com:blueorange589/crowpack.git  /when in /var/www/html  will copy contents into /crowpack

Checkout to new branch

    git fetch
    git checkout dev-ozgur
    
Add to Staged

    git add -A      stages All
    git add .       stages new and modified, without deleted
    git add -u      stages modified and deleted, without new
    
Commit

    git commit      Commit staged
    git commit -a   Auto add and remove before commit