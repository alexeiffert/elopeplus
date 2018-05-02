# General Documentation

## Directories
- vr_js - Contains the "Angelos" API JavaScript
- opencv_js - Contains opencv.js and additional demo JavaScript, etc.

## To Contribute

### Source Code

#### Clone Repo
```
cd /var/www/html
git clone https://github.com/alexeiffert/elopeplus.git 
```

#### Understanding the Project
The Elope+ demo currently consists of two separate parts (separated into
the two directories above). The VR portion, in vr_js contains a VR
environment and live videosharing script. Each participant in the live
stream is shown in the VR environment as a prism with their video stream
broadcasted from each face. The second portion of the project is 
removing the background from each participant's video feed, to make for
a more visually appealing presentation. Currently, we are using opencv.js
(found in the opencv_js directory), which is C++ code transpiled into
JavaScript. We have written a modified version of a demo on the OpenCV
website, which works quite well for background subtraction; however,
due to lack of documentation, we have not been able to apply the mask
we've created to the video stream itself. Ultimately, we hope to use the
OpenCV-processed stream as the video feed for the VR environment.

### Install and configure web server
#### Install Apache2
```
sudo apt-get update
sudo apt-get install apache2
```

#### Adjust the Firewall 
```
sudo ufw app list
sudo ufw allow 'Apache Full'
sudo ufw status
```
You should see HTTP traffic allowed in the displayed output:
Output
    Status: active

    To                         Action      From
    --                         ------      ----
    OpenSSH                    ALLOW       Anywhere                  
    Apache Full                ALLOW       Anywhere                  
    OpenSSH (v6)               ALLOW       Anywhere (v6)             
    Apache Full (v6)           ALLOW       Anywhere (v6)

#### Check your Web Server

```
sudo systemctl status apache2
```

    ● apache2.service - LSB: Apache2 web server
   Loaded: loaded (/etc/init.d/apache2; bad; vendor preset: enabled)
  Drop-In: /lib/systemd/system/apache2.service.d
           └─apache2-systemd.conf
   Active: active (running) since Fri 2017-05-19 18:30:10 UTC; 1h 5min ago
     Docs: man:systemd-sysv-generator(8)
  Process: 4336 ExecStop=/etc/init.d/apache2 stop (code=exited, status=0/SUCCESS)
  Process: 4359 ExecStart=/etc/init.d/apache2 start (code=exited, status=0/SUCCESS)
    Tasks: 55
   Memory: 2.3M
      CPU: 4.094s
   CGroup: /system.slice/apache2.service
           ├─4374 /usr/sbin/apache2 -k start
           ├─4377 /usr/sbin/apache2 -k start
           └─4378 /usr/sbin/apache2 -k start

May 19 18:30:09 ubuntu-512mb-nyc3-01 systemd[1]: Stopped LSB: Apache2 web server.
May 19 18:30:09 ubuntu-512mb-nyc3-01 systemd[1]: Starting LSB: Apache2 web server...
May 19 18:30:09 ubuntu-512mb-nyc3-01 apache2[4359]:  * Starting Apache httpd web server apache2
May 19 18:30:09 ubuntu-512mb-nyc3-01 apache2[4359]: AH00558: apache2: Could not reliably determine the server's fully qualified domain name, using 127.0.1.1. Set the 'ServerName' directive globally to suppress this message
May 19 18:30:10 ubuntu-512mb-nyc3-01 apache2[4359]:  *
May 19 18:30:10 ubuntu-512mb-nyc3-01 systemd[1]: Started LSB: Apache2 web server.


#### Build OpenCV.js from source
(opencv.js is already located in the opencv_js directory)

To Install Emscripten, follow instructions of Emscripten SDK
(found on their website). Then, update:
```
    ./emsdk update
    ./emsdk install latest
    ./emsdk activate latest
```

Launch Git client and clone OpenCV repository.
```
git clone https://github.com/opencv/opencv.git
```

build in build_js directory:
```
cd opencv
python ./platforms/js/build_js.py build_js
```
