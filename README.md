# Planner
Il prototipo è articolato in modo da avere un comportamento differente per gli 
utenti dipendenti e per gli utenti amministratori. Per questa motivazione è stata 
progettata una fase iniziale di autenticazione, in base alla quale sarà mostrata 
un’interfaccia anziché un’altra. L’utente dipendente può semplicemente 
visualizzare le attività da svolgere in un’interfaccia grafica che permette la 
rappresentazione delle stesse in rappresentazione mensile e giornaliera. L’utente 
admin può invece accedere ad ulteriori funzionalità. Difatti ha la facoltà di 
aggiungere reparti, indicando codice e nome, e attività, inserendo codice, nome, 
il reparto a cui verrà assegnata e infine le ore totali necessarie per completarla. 
Quest’ultimo valore viene preso da una stima effettuata da un apposito reparto e 
si presuppone che sia stato acquisito in precedenza. Ogni reparto aggiorna 
automaticamente il numero di dipendenti durante la fase di registrazione degli 
utenti stessi. Inoltre, l’amministratore ha la possibilità di rimuovere le attività 
assegnate direttamente dall’interfaccia grafica dove vengono visualizzate. 
