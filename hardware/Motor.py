# MOTOR.py

import RPi.GPIO as GPIO
import time
from Config import MOTOR_PINS

class MotorController:
    def __init__(self):
        # Récupérer les broches à partir du fichier config
        self.IN1 = MOTOR_PINS["IN1"]
        self.IN2 = MOTOR_PINS["IN2"]
        self.IN3 = MOTOR_PINS["IN3"]
        self.IN4 = MOTOR_PINS["IN4"]

        # Configurer les broches GPIO
        GPIO.setmode(GPIO.BCM)
        GPIO.setup(self.IN1, GPIO.OUT)
        GPIO.setup(self.IN2, GPIO.OUT)
        GPIO.setup(self.IN3, GPIO.OUT)
        GPIO.setup(self.IN4, GPIO.OUT)

        # Séquence pour le moteur pas à pas (demi-pas)
        self.step_sequence = [
            [1, 0, 0, 0],
            [1, 1, 0, 0],
            [0, 1, 0, 0],
            [0, 1, 1, 0],
            [0, 0, 1, 0],
            [0, 0, 1, 1],
            [0, 0, 0, 1],
            [1, 0, 0, 1],
        ]

        # Définir le nombre de pas pour chaque position (jours de la semaine)
        self.steps_per_position = [64, 64, 64, 64, 64, 64, 64]

        # Variable pour suivre la position actuelle
        self.current_position = 0

    def set_step(self, step):
        GPIO.output(self.IN1, step[0])
        GPIO.output(self.IN2, step[1])
        GPIO.output(self.IN3, step[2])
        GPIO.output(self.IN4, step[3])

    def move_to_position(self, target_position):
        # Déplacement en avant ou en arrière en fonction de la position actuelle
        if target_position == self.current_position:
            return  # Si le moteur est déjà sur la position demandée, ne rien faire

        if target_position > self.current_position:
            # Avancer vers la position cible
            for position in range(self.current_position, target_position + 1):
                self.move_one_step(position)
        else:
            # Reculer vers la position cible
            for position in range(self.current_position, target_position - 1, -1):
                self.move_one_step(position)

        # Mettre à jour la position actuelle
        self.current_position = target_position

    def move_one_step(self, position):
        if position < 0 or position >= len(self.steps_per_position):
            raise ValueError("Invalid position index")
        steps = self.steps_per_position[position]
        for _ in range(steps):
            for step in self.step_sequence:
                self.set_step(step)
                time.sleep(0.01)  # Ajustez le délai selon la vitesse souhaitée
        time.sleep(5)  # Pause de 5 secondes après chaque position

    def cleanup(self):
        GPIO.cleanup()

# Exemple de fonction pour recevoir une commande externe
def command_from_interface(motor, day):
    days_map = {
        "lundi": 0,
        "mardi": 1,
        "mercredi": 2,
        "jeudi": 3,
        "vendredi": 4,
        "samedi": 5,
        "dimanche": 6
    }

    if day in days_map:
        motor.move_to_position(days_map[day])
    else:
        print(f"Jour invalide : {day}")

if __name__ == "__main__":
    motor = MotorController()

    try:
        # Exécution d'un test de commande externe (exemple)
        command_from_interface(motor, "mardi")  # Va déplacer le moteur jusqu'à mardi
    except KeyboardInterrupt:
        print("Interruption du programme.")
    finally:
        motor.cleanup()