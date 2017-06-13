#!/bin/bash

# Set ACL permissions
sudo setfacl -b storage
sudo setfacl -b bootstrap/cache
sudo setfacl -Rdm g:www-data:rw storage
sudo setfacl -Rdm g:www-data:rw bootstrap/cache
sudo chgrp -R www-data storage
sudo chgrp -R www-data bootstrap/cache
sudo chmod -R g-w *
sudo chmod -R g+rw storage
sudo chmod -R g+rw bootstrap/cache
sudo chgrp -R www-data *
