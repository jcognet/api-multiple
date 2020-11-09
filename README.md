# api-multiple
Test d'appel d'API en // via SF 5.2 

## Installation du POC
1. Installer le projet en récupérant le projet 
2. Installer la partie PHP : composer install
3. Installer la partie front : yarn 

## Lancement du POC
1. Lancer un serveur applicatif (*symfony serve* fait l'affaire)
2. Compiler les assets : *yarn dev*
3. Lancer le serveur websocket : *bin/console brewery:websocket-server:start* (avec pourquoi l'option super verbose *-vvv*)
4. Lancer une recherche :)

## La configuration
La configuration est au niveau du fichier .env : 
* WEBSOCKET_PORT : le port d'écoute du websocket (partagé par le front et le back)
* MAX_RANDOM_SLEEP_TIME : durée d'attente (sleep) côté serveur pour accentuer le temps de réponse de chaque API.

## La partie fun
* Pour ajouter un appel API, il suffit juste de rajouter une classe utilisant l'interface *BreweryApiInterface* et étendant la classe abstraite *BreweryResearchApi* et le tour est joué.
(L'interface servant à taguer tous les services l'utilisant... Le système de dérivation n'est pas prise en compte)  
