# Squiggcam (Back End)

A small hobby project for turning an old Samsung Galaxy S4 into a home security camera.

Built with PHP/Laravel, this is the back end for controlling notifications, changing settings on the
camera and for retrieving available video footage.

and sending motion events/videos to the front-end and the Pusher notification 
reviewing motion events/videos captured.

It communicates via JSON API to the front-end, a custom API to the phone app, and uses Pusher service
for mobile phone notifications.

Code works and is used for my home video surveillance (watching cats), but is not perfect / fully tested etc.

## TODO
- Better error handling for failure to reach phone camera 
- Alternative way of retrieving downloaded videos
