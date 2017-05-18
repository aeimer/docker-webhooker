# Docker Webhooker
This is a Docker-Container which runs a Apache2 with PHP7 under Ubuntu 16.04.

It only has one index.php which accepts `POST`-calls with the parameter `key`.
Corresponding to this `key` in the `config.json` is a `command` defined which will run if the script receives a defined `key`.
 
## Configuration
````json
{"data":[
  {
    "key": "123456789qwertz:restart",
    "command": "sudo shutdown -r now"
  },
  {
      "key": "123456789qwertz:deploy",
      "command": "sudo /opt/deploy.sh"
    }
]}
````

This is the only configuration you need, it's basically some key => command pairs.   
Please note, that the keys have to be at least ten characters long. **FOR SECURITY REASONS!**

For the keys you use any scheme you want, in this example we just have one "base"-key which then is followed by the task.
Feel free to handle it in a different way ;)

**PLEASE KEEP IN MIND THAT YOU SHOULD USE SSL FOR THESE CALLS!!!**

## Start the docker container
To start the container just run:

````bash
docker run -d -p 80:80 aeimer/webhooker
````

See the container under <https://hub.docker.com/r/aeimer/webhooker>
