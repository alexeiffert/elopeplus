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

#### Check your Web Server's Status

```
sudo systemctl status apache2
```

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
