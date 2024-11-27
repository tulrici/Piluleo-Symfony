import threading
import time
from Power import PowerControl
from Remote import RemoteControl
from Motor import MotorController
from Electro import activate_electro_by_time
from Alert import AlertSystem  # Importer le système d'alerte
from Config import BUTTON_PINS, LED_PINS, MOTOR_PINS

# Fonction pour le contrôle du moteur
def motor_thread_function(motor_control, target_day):
    try:
        motor_control.move_to_position(target_day)  # Mouvement du moteur vers un jour spécifique
    except KeyboardInterrupt:
        pass
    finally:
        motor_control.cleanup()

# Fonction pour le contrôle des électro-aimants
def electro_thread_function(time_of_day):
    try:
        activate_electro_by_time(time_of_day)  # Activation de l'électro-aimant pour un moment de la journée spécifique
    except KeyboardInterrupt:
        pass

# Fonction pour le système d'alerte
def alert_thread_function(alert_control):
    try:
        alert_control.run()  # Lancer la surveillance du bouton d'alerte
    except KeyboardInterrupt:
        pass
    finally:
        alert_control.cleanup()

def main():
    # Initialisation des contrôleurs avec les broches depuis config.py
    power_control = PowerControl(BUTTON_PINS["POWER"], LED_PINS["POWER"])
    remote_control = RemoteControl(BUTTON_PINS["REMOTE"], LED_PINS["REMOTE"])
    motor_control = MotorController()  # Pas besoin de passer les broches ici
    alert_control = AlertSystem(BUTTON_PINS["ALERT"])  # Initialiser le système d'alerte

    # Définir un jour et un moment de la journée pour tester (modifiables selon l'interface utilisateur)
    target_day = 2  # Par exemple, 0 = lundi, 1 = mardi, etc.
    time_of_day = "Matin"  # Choix entre "Matin", "Midi", "Soir", "Avant-coucher"

    # Lancer les threads pour les contrôleurs
    power_thread = threading.Thread(target=power_control.run)
    remote_thread = threading.Thread(target=remote_control.run)
    motor_thread = threading.Thread(target=motor_thread_function, args=(motor_control, target_day))
    electro_thread = threading.Thread(target=electro_thread_function, args=(time_of_day,))
    alert_thread = threading.Thread(target=alert_thread_function, args=(alert_control,))  # Thread pour l'alerte

    # Démarrer les threads
    power_thread.start()
    remote_thread.start()
    motor_thread.start()
    electro_thread.start()
    alert_thread.start()

    # Attendre que tous les threads se terminent
    try:
        power_thread.join()
        remote_thread.join()
        motor_thread.join()
        electro_thread.join()
        alert_thread.join()
    except KeyboardInterrupt:
        pass
    finally:
        # Nettoyage
        power_control.cleanup()
        remote_control.cleanup()
        motor_control.cleanup()
        alert_control.cleanup()

if __name__ == "__main__":
    main()
