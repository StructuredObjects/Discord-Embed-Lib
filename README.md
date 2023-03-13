# Discord-Embed-Lib

<img src="https://puu.sh/JBvAT/73093a7512.png">

# How to install dependency?
```
sudo apt install php php-curl -y
```

# How to use?
```
$embed = new DiscordEmbed("https://discordapp.com/api/webhooks/channel/token");
$embed->_CreateEmbed("TEST", "TEST", array("TEST" => ["DES TEST", "true"], "NEW" => ["TEST", "true"]));
$embed->send();
```
