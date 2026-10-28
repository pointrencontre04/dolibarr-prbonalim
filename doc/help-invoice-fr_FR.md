# Facturer les bons

Les bons utilisés en caisse sont facturés au **prescripteur** qui les a émis. Une facture regroupe plusieurs bons d'un **même prescripteur**.

## Prérequis

- Les bons à facturer sont au statut **Clôturé**. Les bons **Crédités**, **Brouillons**, **Annulés** ou déjà **Facturés** ne peuvent pas être facturés.
- Tous les bons d'une même facture ont le **même prescripteur**.
- Le prescripteur est **Client** (voir [Ajouter un prescripteur](bonalim_help.php?page=issuer)).

### Clôturer les bons expirés

Un bon entièrement utilisé est clôturé automatiquement par la caisse. Un bon expiré mais pas entièrement utilisé reste **Crédité** et doit être clôturé à la main avant la facturation :

- **Bon utilisé en partie** : ouvrir le bon et cliquer sur **Clôturer**. Pour plusieurs bons : dans **Lister les Bons**, les cocher, choisir l'action **Clôturer** puis **Confirmer**. Seul le montant utilisé sera facturé.
- **Bon jamais utilisé** : il n'y a rien à facturer. L'**Annuler** plutôt que le clôturer.

## Créer la facture

1. Menu **Bons Alimentaires** → **Lister les Bons**.
2. Filtrer la liste : **État** = **Clôturé**, et choisir le **Prescripteur**.
3. Cocher les bons à facturer.
4. Dans la liste des actions, choisir **Créer une facture**, puis cliquer sur **Confirmer**.

Dolibarr ouvre directement la facture créée.

## Résultat

- Une facture **validée** est créée au nom du prescripteur, à la date du jour.
- Elle contient **une ligne par bon** : « Bon Alimentaire [réf. prescripteur] du [date de début] [bénéficiaire] ([réf. du bon]) ».
- Le montant de chaque ligne est le **montant utilisé** du bon, et non son montant initial. Les lignes sont sans TVA.
- Les bons passent au statut **Facturé**. La référence de la facture est ajoutée dans leur note privée (« Facturé sur FA… »).

La facture se gère ensuite comme toute autre facture client : génération du PDF, envoi par e-mail, saisie du règlement.

## En cas d'erreur

| Message | Que faire |
|---|---|
| Les bons alimentaires ont des prescripteurs différents | Ne cocher que des bons du même prescripteur. Faire une facture par prescripteur. |
| Les bons alimentaires ne sont pas tous au statut « Clôturé » | Décocher les bons qui ne sont pas clôturés, ou les clôturer d'abord (voir plus haut). |
| Aucune facture sélectionnée | Cocher au moins un bon avant de lancer l'action. |

Si une erreur se produit, **aucune facture n'est créée et aucun bon n'est modifié**. On peut corriger et recommencer.

## Cas particuliers

- **Bon déjà facturé autrement** (hors de cette procédure) : ouvrir le bon clôturé et cliquer sur **Classer Facturé**.
- **Bon facturé par erreur** : sur le bon, **Rouvrir** le remet au statut **Clôturé**. S'il lui restait du crédit, il repasse **Crédité** et redevient utilisable en caisse. **La facture n'est pas modifiée** : il faut la corriger séparément, par exemple avec un avoir.
