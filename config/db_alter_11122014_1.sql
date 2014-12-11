/* 22:58:32 localhost */ ALTER TABLE `anagrafica` ADD `cellulare` VARCHAR(30)  NULL  DEFAULT NULL  AFTER `prov`;
/* 22:58:45 localhost */ ALTER TABLE `anagrafica` ADD `telefono` VARCHAR(30)  NULL  DEFAULT NULL  AFTER `cellulare`;
/* 22:58:51 localhost */ ALTER TABLE `anagrafica` ADD `email` VARCHAR(100)  NULL  DEFAULT NULL  AFTER `telefono`;
/* 23:02:23 localhost */ ALTER TABLE `annuale` ADD `scadenza_tessera` DATE  NULL  AFTER `tessera`;
/* 23:02:32 localhost */ ALTER TABLE `annuale` ADD `scadenza_visita` DATE  NULL  AFTER `scadenza_tessera`;
