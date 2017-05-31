# Docker Webhooker
This is a Docker-Container which runs a Apache2 with PHP7 under Ubuntu 16.04.

It only has one index.php which accepts `POST`-calls with the parameter `key`.
Corresponding to this `key` in the `config.json` is a `command` defined which will run if the script receives a defined `key`.

See the container under <https://hub.docker.com/r/aeimer/webhooker>
 
## Configuration
```json
{"config":[
  {
    "key": "123456789qwertz:restart",
    "command": "sudo shutdown -r now"
  },
  {
      "key": "123456789qwertz:deploy",
      "command": "sudo /opt/deploy.sh"
    }
]}
```

This is the only configuration you need, it's basically some key => command pairs.   
Please note, that the keys have to be at least ten characters long. **FOR SECURITY REASONS!**

For the keys you use any scheme you want, in this example we just have one "base"-key which then is followed by the task.
Feel free to handle it in a different way ;)

An sample config-file can be found [here](config.dist.json).

**PLEASE KEEP IN MIND THAT YOU SHOULD USE SSL FOR THESE CALLS!!!**

## Start the docker container
To start the container just run:

```bash
docker run -d --rm -p 80:80 -v ~/config.json:/opt/config.json --name webhooker aeimer/webhooker
# or (to place the `config.json` somewhere else)
docker run -d --rm -p 80:80 -v ~/config.json:/custom/path/c.json -e "CONFIG_FILE=/custom/path/c.json" --name webhooker aeimer/webhooker
```

### Environment Variables
- `CONFIG_FILE` - optionally - sets the path to the config-file | default: `/opt/config.json`#

### Volumes
You have at least to add a volume which adds the `config.json`-file to the container.

### Logs
To get the logs just call `docker logs [container-name]`. Everything what happens gets logged to the default docker log.

## Call the webhook
To trigger the webhook just make a call with eg. cURL:
```bash
curl --data key=123456789qwertz:restart https://example.com
```

