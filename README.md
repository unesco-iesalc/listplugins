# listplugins
Moodle tool that list in command line all the dirs where are plugins located. Useful for automate upgrades

This is an example of a sh script tha uses this plugin
newmoodledir=/home/cvicente/moodledev/moodlenew
moodledir=/home/cvicente/moodledev/moodle
php $moodledir/local/listplugins/list.php --list >plugin.lst
while read line;do
newline=${line/$moodledir/$newmoodledir}
cp -r $line $newline
done < plugin.lst
cp $moodledir/config.php $newmoodledir/config.php
cp $moodledir/config-dist.php $newmoodledir/config-dist.php
mv $moodledir $moodledir.old
mv $newmoodledir $moodledir