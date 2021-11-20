#!/bin/bash

while true; do
xdotool keyup Up
xdotool keydown Left
sleep 3
xdotool keyup Left
xdotool keydown Down
sleep 3
xdotool keyup Down
xdotool keydown Right
sleep 3
xdotool keyup Right
xdotool keydown Up

sleep 3
done
