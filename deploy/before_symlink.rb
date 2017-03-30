########################################################################################################################
# fingerprinted assets into public/assets folder
########################################################################################################################

# application in /srv/www/{application}
app_short_name  = release_path.split("/")[3]

########################################################################################################################
# Compile fingerprinted assets into public/assets folder
########################################################################################################################

run "ln -s /data/ebs/#{app_short_name}/uploads #{release_path}/wp-content"
run "ln -s /data/ebs/#{app_short_name}/wp-config.php #{release_path}/wp-config.php"