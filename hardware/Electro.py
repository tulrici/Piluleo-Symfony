# ELECTRO.py

import RPi.GPIO as GPIO
import time
from Config import ELECTRO_PINS

class ElectroMagnetControl:
    def __init__(self, pin):
        GPIO.setmode(GPIO.BCM)
        self.pin = pin
        GPIO.setup(self.pin, GPIO.OUT)
        self.turn_off()

    def turn_on(self):
        GPIO.output(self.pin, GPIO.HIGH)

    def turn_off(self):
        GPIO.output(self.pin, GPIO.LOW)

    def cleanup(self):
        GPIO.cleanup(self.pin)

def activate_electro_by_time(time_of_day):
    # Dictionary for time of day mapped to electro-magnets
    time_map = {
        "Matin": ELECTRO_PINS["MATIN"],
        "Midi": ELECTRO_PINS["MIDI"],
        "Soir": ELECTRO_PINS["SOIR"],
        "Avant-coucher": ELECTRO_PINS["AVANT_COUCHER"]
    }

    if time_of_day not in time_map:
        raise ValueError(f"Invalid time of day: {time_of_day}")

    # Initialize the corresponding electro-magnet
    electro = ElectroMagnetControl(time_map[time_of_day])

    try:
        # Activate the electro-magnet for the specified time of day
        print(f"Activating electro-magnet for: {time_of_day}")
        electro.turn_on()
        
        # Keep it on for a certain amount of time (e.g., 10 seconds)
        time.sleep(10)
    
    finally:
        # Turn off and clean up
        electro.turn_off()
        electro.cleanup()

if __name__ == "__main__":
    activate_electro_by_time("Matin")  # Example: activate the "Matin" electro-magnet
