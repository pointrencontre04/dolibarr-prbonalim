# Créer et créditer un bon

Un bon alimentaire est émis par un **prescripteur** au profit d'un **bénéficiaire** (la famille). Il n'est utilisable en caisse qu'une fois **validé** : il passe alors au statut **Crédité**.

## Prérequis

- Le **prescripteur** existe dans Dolibarr et porte le tag des prescripteurs (voir [Ajouter un prescripteur](bonalim_help.php?page=issuer)).
- Le **bénéficiaire** existe dans Dolibarr comme **Tiers**. Ce doit être le même Tiers que celui sélectionné comme client en caisse.

## Créer le bon

1. Menu **Bons Alimentaires** → **Nouveau Bon**.
2. Remplir les champs :
   - **Réf. prescripteur** : le numéro inscrit sur le bon papier. Ce champ est facultatif mais conseillé, car ce numéro est repris sur la facture.
   - **Montant** : la valeur du bon.
   - **Prescripteur** : l'organisme qui a émis le bon.
   - **Bénéficiaire** : la famille qui va utiliser le bon.
   - **Date début** et **Date fin** : la période de validité inscrite sur le bon. La date de fin est facultative.
3. Cliquer sur **Créer**.

Le bon est créé au statut **Brouillon**, avec une référence provisoire « (PROV…) ». **Un bon en brouillon ne peut pas être utilisé en caisse.**

## Valider le bon (le créditer)

1. Sur la fiche du bon, vérifier les informations. Le bouton **Modifier** permet de les corriger.
2. Cliquer sur **Valider**, puis confirmer.

Le bon reçoit sa référence définitive et passe au statut **Crédité** : il est maintenant utilisable en caisse.

Pour valider plusieurs bons d'un coup : dans **Lister les Bons**, cocher les bons en brouillon, choisir l'action **Valider** puis **Confirmer**.

## Utilisation en caisse

- En caisse, sélectionner le bénéficiaire comme client. Au moment du paiement, le bouton **Bons Alimentaires** apparaît s'il lui reste du crédit sur des bons **Crédités**.
- Les bons sont utilisés du plus ancien (date de début) au plus récent. Un même achat peut utiliser plusieurs bons.
- Un bon peut être utilisé en plusieurs fois : le **Montant restant** diminue à chaque achat et le bon reste **Crédité**.
- Quand le montant restant arrive à 0, le bon passe automatiquement au statut **Clôturé**.
- **Attention :** la caisse ne vérifie pas les dates de validité. Un bon dont la date de fin est dépassée reste utilisable tant qu'il est **Crédité**. Pour l'arrêter, il faut le clôturer ou l'annuler (voir ci-dessous).

## Les statuts d'un bon

| Statut | Signification | Utilisable en caisse |
|---|---|---|
| **Brouillon** | Bon saisi, pas encore validé | Non |
| **Crédité** | Bon validé, avec du crédit restant | Oui |
| **Clôturé** | Bon entièrement utilisé, ou clôturé à la main | Non |
| **Facturé** | Bon facturé au prescripteur | Non |
| **Annulé** | Bon annulé avant toute utilisation | Non |

## Corriger ou arrêter un bon

- **Bon en brouillon** : **Modifier** pour le corriger, ou **Supprimer**.
- **Bon crédité mais pas encore utilisé** :
  - **Retour en brouillon** pour le modifier, puis **Valider** à nouveau ;
  - ou **Annuler** s'il ne doit pas être utilisé.
- **Bon crédité déjà utilisé en partie** : il ne peut plus être modifié ni annulé. **Clôturer** permet de l'arrêter, par exemple quand il est expiré. Le crédit restant est alors perdu et seul le montant utilisé sera facturé.
- **Bon annulé** : **Rouvrir** le remet au statut **Crédité**, ou **Supprimer** l'efface.
