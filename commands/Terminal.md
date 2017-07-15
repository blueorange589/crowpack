# FILES / FOLDERS
Create symlink

    ln -s /var/www/vhosts/ecash_cfe /var/www/vhosts/ecash-staging.com/ecash_root

# SSH
Generate public key
    
    ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
    eval "$(ssh-agent -s)"
    sh-add ~/.ssh/id_rsa
    xclip -sel clip < ~/.ssh/id_rsa.pub

# MYSQL
Export

	 mysqldump -u mysql_user -p DATABASE_NAME > backup.sql
	 
Import

	mysql -u mysql_user -p DATABASE < backup.sql

# COMPOSER
install dependencies
    
    composer install --no-dev
		

    

    