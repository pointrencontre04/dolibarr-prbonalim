--
-- Script run when an upgrade of Dolibarr is done. Whatever is the Dolibarr version.
--

ALTER TABLE llx_prbonalim_bonalim ADD COLUMN ref_issuer varchar(128);
