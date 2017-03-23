########################################################################################################################
# fingerprinted assets into public/assets folder
########################################################################################################################

# application in /srv/www/{application}
app_short_name  = release_path.split("/")[3]

########################################################################################################################
# Compile fingerprinted assets into public/assets folder
########################################################################################################################

run "ln -s /data/ebs/#{release_path}/uploads #{release_path}/#{app_short_name}/current/wp-content/uploads"
run "ln -s /data/ebs/#{release_path}/wp-config.php #{release_path}/#{app_short_name}/current/wp-config.php"
