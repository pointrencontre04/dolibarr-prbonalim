# Ajouter un prescripteur

Un prescripteur (CCAS, Croix-Rouge, assistante sociale…) est un **Tiers** de Dolibarr. Pour qu'il apparaisse dans la liste « Prescripteur » d'un bon alimentaire, le Tiers doit :

- être **Client**, car c'est à lui que la facture des bons est adressée ;
- être **En activité** ;
- porter le **tag des prescripteurs**, choisi par l'administrateur dans la configuration du module.

## Créer un nouveau Tiers prescripteur

1. Menu **Tiers** → **Nouveau tiers**.
2. Remplir le **Nom** (par exemple « CCAS de … »).
3. Dans **Prospect / Client**, choisir **Client**.
4. Laisser **État** sur **En activité**.
5. Dans **Tags/catégories clients**, sélectionner le **tag des prescripteurs**.
6. Compléter l'adresse, le téléphone et l'e-mail, qui servent pour la facture.
7. Cliquer sur **Créer tiers**.

## Transformer un Tiers existant en prescripteur

1. Ouvrir la fiche du Tiers.
2. Cliquer sur **Modifier**.
3. Vérifier que le Tiers est **Client** et **En activité**.
4. Dans **Tags/catégories clients**, ajouter le **tag des prescripteurs**.
5. Cliquer sur **Enregistrer**.

## Vérifier

1. Menu **Bons Alimentaires** → **Nouveau Bon**.
2. Le prescripteur doit apparaître dans la liste **Prescripteur**.

## Le prescripteur n'apparaît pas dans la liste ?

Ouvrir la fiche du Tiers et vérifier ces trois points :

- le Tiers est bien **Client** ;
- le Tiers est **En activité**, et non **Fermé** ;
- le **tag des prescripteurs** est bien présent. Un tag « enfant » de ce tag ne suffit pas, il faut le tag lui-même.

En cas de doute sur le nom du tag des prescripteurs, demander à l'administrateur de Dolibarr.
