Lights
==============================

![Raspberry Pi](https://raw.github.com/charleswolfe/lights/master/docs/images/all_done_pi.jpg )
Lights is my take on Geoff Johnson's Raspberry Pi mains switching tutorial.

Except I use Woods 13569 from amazon (mine is 'channel B').
[http://www.amazon.com/Woods-13569-Wireless-Control-Outlets/dp/B003ZTWYXY/ref=sr_1_1?ie=UTF8&qid=1360605592&sr=8-1&keywords=remote+outlet]
I'm planning to add a flashier UI, PHP and Javascript and make a mobile application.

NOTE: The Woods 13569 uses a 315mHz transmitter unlike the 433mHz Geoff's unit has.

I am also using the channel 'B' type, so if your is channel A, you will need to follow Geoffs guide on his page [http://www.hoagieshouse.com/RaspberryPi/RCSockets/RCPlug.html]

I did feel like Geoff was missing some better documentation on how to hookup the breadboard to receive codes and visualize them with Audio galaxy.
Here are two pictures which might help:
![Breadboard 1](https://raw.github.com/charleswolfe/lights/master/docs/images/breadboard_hookup1.jpg)
![Breadboad closerup](https://raw.github.com/charleswolfe/lights/master/docs/images/breadboard_hookup2.jpg)

All-in-all, it's was pretty easy to follow his instructions, I doubled up the bits when transcibing the code, so instead of 1000, I wrote 11000000, it worked with Geoffs sleep of 222000 in switch.cpp

In this pic, I used some dupont connectors (hard to crimp, hard to solder, but soooo much better looking than a floppy cable)
![Raspberry Pi showing 315mHz tranmitter installed with dupont connectors](https://raw.github.com/charleswolfe/lights/master/docs/images/pi_apart.jpg)


