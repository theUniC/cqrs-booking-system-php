# Booking System

## Problem Statement

We want to make a booking solution for one hotel. The first 2 user stories are:

* As a user I want to see all free rooms.
* As a user I want to book a room.
* As an administrator I should be able to create new rooms

The Booking struct contains

* client id
* room name
* arrival date
* departure date

The Room struct contains

* Room ID
* Room Name
* Floor
* Number
* M2
* TV

And the Room struct contain only

* room name

## Todo list

* [ ] Book a room use case
  * [ ] Command to book a room
  * [ ] Command handler to perform the booking
  * [ ] Tests
* [ ] Get the list of free rooms use case
