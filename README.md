# test-adimeo

Temps passé : ~5h

Pour ce test j'ai séparé mon code en 3 modules distincts :

=> event_block, ou j'ai crée le bloc à afficher sur la page détail de chaque evenement, la création d'un tableau contenant les trois évenements à afficher,ainsi que le tpl permettant la mise en page de des évenement.

=> event_utils, ou j'ai déclaré un service ou se trouvent les fonctions permettant de récuperer la liste des events, les trier par date ou récuperer certains fields d'un evenement, avec dans l'idée que j'aurai peut etre à réutiliser ces fonction pour la partie CRON & Queueworker

=> event_cron, module ou je déclaire la tache cron avec hook_cron, dans lequel j'appelle le service event_utils, afin d'utiliser ma fonction permettant de lister les evenements dont la date de fin est dépassée, et crée un item dans la queue pour avec chacun d'entre eux. Dans un deuxième temps, le QueueWorker implemente la fonction process item, ou je dépublie simplement chacun des évenements de la queue après avoir vérifier qu'ils ne le soient pas déja.
